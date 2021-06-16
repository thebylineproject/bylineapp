<?php

namespace App\Http\Controllers;
#use Coinbase;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Submissions;
use App\Funsraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class DonationController extends Controller {
    public function index($submission_id){
        $sub_id			= $submission_id;
		$submissions	= DB::table('submissions')
			->select('*')
			->where('sid', '=', $sub_id)
			->get();
			
		$user	= DB::table('users')
			->select('*')
			->where('id', '=', $submissions[0]->user_id)
			->get();
			
		$fundraising	= DB::table('fundraising')
			->select('*')
			->where('submission_id', '=', $sub_id)
			->where('status', '=', 'COMPLETED')
			->where('is_contribute', '=', '1')
			->orderBy('fid', 'DESC')
			->get();
		
		$latest_donation	= DB::table('fundraising')
			->select('*')
			->where('submission_id', '=', $sub_id)
			->where('status', '=', 'COMPLETED')
			->orderBy('fid', 'DESC')
			->first();
		
		$total_donations = 0;
		foreach($fundraising as $sum_amount){
			$total_donations += $sum_amount->amount_paid;
		}

		$fundraising_goal = $amount = str_replace(',', '', $submissions[0]->fundraising_goal);
        return view('donations.submission_view', compact('submissions', 'user', 'fundraising', 'total_donations', 'latest_donation'));
    }
	
	public function store(Request $request) {
        $user_id			= 0;
        $CurrentDatetime	= date("Y-m-d H:i:s");
		
		if(isset($request['display_cont'])){$display_cont = 1;}else{$display_cont = 0;}
		
        $last_inserted_id	= DB::table('fundraising')->insertGetId(
			array(
				'user_id'			=> $user_id,
				'submission_id'		=> $request['sid'],
				'funder_name'		=> $request['funder_name'],
				'reference_id'		=> $request['reference_id'],
				'amount'			=> $request['amount'],
				'is_contribute'		=> $display_cont,
				'status'			=> 'STARTED',
				'created_at'		=> $CurrentDatetime,
				'updated_at'		=> $CurrentDatetime
			)
		);
		return redirect('/donations/checkout/' . $last_inserted_id);
    }
	
	public function checkout($id) {
        $fundraising = DB::table('fundraising')
                ->select('fundraising.*','submissions.title','users.client_id')
                ->where('fid', '=', $id)
                ->join('submissions', 'fundraising.submission_id', '=', 'submissions.sid')
                ->join('users', 'submissions.user_id', '=', 'users.id')
                ->get();
		
		$submissions	= Submissions::where('sid', '=', $fundraising[0]->submission_id)->firstOrFail();
		$user_info		= User::find($submissions->user_id);

        return view('donations.checkout', compact('fundraising', 'user_info'));
    }
	
    public function store_payment(Request $request) {
        $CurrentDatetime = date("Y-m-d H:i:s");
		if($request->transaction_status == 'COMPLETED'){
			$fundraising_info	= DB::table('fundraising')
				->select('*')
				->where('reference_id', '=', $request->reference_id)
				->get();
			$submission_user		= Submissions::where('sid', $fundraising_info[0]->submission_id)->get();
			$fundraising_goal		= $amount = str_replace(',', '', $submission_user[0]->fundraising_goal);
			$fundraising_donation	= DB::select(DB::raw("SELECT SUM(amount_paid) AS total_donation FROM fundraising WHERE submission_id = '".$fundraising_info[0]->submission_id."' AND status = 'COMPLETED'"));
			
			DB::table('fundraising')->where('reference_id', $request->reference_id)->update(
				array(
					'payer_name'		=> $request->payer_name,
					'payer_email'		=> $request->payer_email,
					'amount_paid'		=> $request->amount,
					'payee_email'		=> $request->payee_email,
					'transaction_id'	=> $request->transaction_id,
					'status'			=> $request->transaction_status,
					'payment_method'	=> 'PayPal',
					'paid_at'			=> $CurrentDatetime//$request->created_at
				)
			);
			
			$user				= User::find($submission_user[0]->user_id);
			
			$tipper_name		= $request->payer_name;
			$reporter_name		= $user->name;
			$story_link			= "https://".$_SERVER['SERVER_NAME']."/share/".$fundraising_info[0]->submission_id."/story";
			
			/*Send Email To Donor START*/
			$email_data_array	= array('user_name' => $request->payer_name, 'email' => $request->payer_email, 'story_link' => $story_link, 'reporter_name' => $reporter_name, 'email_subject' => 'Thank you for making tip', 'donation_amount' => $request->amount);
			$email_data			= (object) $email_data_array;
			Mail::send('mails.donation_thankyou', array('email_data' => $email_data), function($message) use ($email_data) {
				$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
			});
			/*Send Email To Donor END*/
			
			/*Send Email To Writer START*/
			$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'story_link' => $story_link, 'tipper_name' => $tipper_name, 'email_subject' => 'The Byline Project Tip Received', 'donation_amount' => $request->amount);
			$email_data			= (object) $email_data_array;
			Mail::send('mails.donation_received', array('email_data' => $email_data), function($message) use ($email_data) {
				$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
			});
			/*Send Email To Writer END*/
			
			/*Send Email To Writer And Admin for Goal Completion END*/
			if($fundraising_donation[0]->total_donation >= $fundraising_goal){
				/*Send Email To Writer START*/
				$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'story_link' => $story_link, 'email_subject' => 'Fundraising Goal Met');
				$email_data			= (object) $email_data_array;
				Mail::send('mails.fundraising_goal_met', array('email_data' => $email_data), function($message) use ($email_data) {
					$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
				});
				/*Send Email To Writer END*/
				/*Send Email To ADMINS/EDITORS START*/
				$admins_writers	= DB::table('users')
						->join('users_roles', 'users.id', '=', 'users_roles.user_id')
						->where('users_roles.role_id', '!=', '3')
						->get();
				if(!$admins_writers->isEmpty()){
					foreach($admins_writers as $value){
						$email_data_array	= array('user_name' => $value->name, 'email' => $value->email, 'reporter_name' => $reporter_name, 'story_link' => $story_link, 'email_subject' => 'Fundraising Goal Met');
						$email_data			= (object) $email_data_array;
						Mail::send('mails.fundraising_goal_met_admin', array('email_data' => $email_data), function($message) use ($email_data) {
							$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
						});
					}
				}
				/*Send Email END*/
			}
						
			return 1;
		}else{
			return 0;
		}
    }
	
    public function thank_you() {
		return view('donations.thankyou');
    }
	
    public function payment_failed() {
        return view('donations.paymentfailed');
    }
	
	public function verify($verification_code){
		$user	= DB::table('users')
			->select('*')
			->where('verification_code', '=', $verification_code)
			->get();
		
		if(!$user->isEmpty()){
			DB::table('users')->where('verification_code', $verification_code)->update(
				array(
					'is_verified'		=> '1',
					'verification_code'	=> ''
				)
			);
			
			/*Send Email To ADMINS/EDITORS START*/
			$admins_writers	= DB::table('users')
					->join('users_roles', 'users.id', '=', 'users_roles.user_id')
					->where('users_roles.role_id', '!=', '3')
					->get();
			if(!$admins_writers->isEmpty()){
				foreach($admins_writers as $value){
					$email_data_array	= array('user_name' => $value->name, 'email' => $value->email, 'email_subject' => 'The Byline Project New Registration Confirmation');
					$email_data			= (object) $email_data_array;
					Mail::send('mails.email_welcome', array('email_data' => $email_data), function($message) use ($email_data) {
						$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
					});
				}
			}
			/*Send Email END*/
			/*Send Email to WRITER START*/
			$email_data_array	= array('user_name' => $user[0]->name, 'email' => $user[0]->email, 'email_subject' => 'The Byline Project Registration Confirmation');
			$email_data			= (object) $email_data_array;
			Mail::send('mails.email_welcome', array('email_data' => $email_data), function($message) use ($email_data) {
				$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
			});
			/*Send Email END*/
			
			return redirect('/login?action=verified');
		}else{
			return redirect('/login?action=verifyfail');
		}
    }
}
