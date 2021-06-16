<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Pitches;
use App\Submissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PitchesController extends Controller{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(){
		$user = Auth::user();
		if($user->hasRole('writer')){
			$pitches = Pitches::addSelect(
				['user_name' => User::select(DB::raw('name'))
					->whereColumn('id', 'pitches.user_id')
				]
			)
			->where('pitches.user_id', '=', $user->id)
			->orderBy('pid', 'desc')
			->get();
		}else{
			$pitches = Pitches::addSelect(
				['user_name' => User::select(DB::raw('name'))
					->whereColumn('id', 'pitches.user_id')
				]
			)
			->orderBy('pid', 'desc')
			->get();
		}
		return view('pitches.manage_pitches', ['pitches' => $pitches]);
	}
    public function create(){
        $user_id	= Auth::user()->id;
        $user_info	= DB::table('users')->where('id', '=', $user_id)->first();
		
		DB::table('users')->where('id', $user_id)->update(
			array(
				'welcome_note' => '1',
			)
		);
		
        return view('pitches.create_pitch', ['user_info' => $user_info]);
	}
    public function store(Request $request){
		$validator = Validator::make($request->all(), [
            'title'				=> 'required|string',
            'description'		=> 'required|string',
			'what'				=> 'required|string',
			'why'				=> 'required|string',
			'how'				=> 'required|string',
			'rel_link_1'		=> 'required|url',
			'rel_link_2'		=> 'required|url',
			'rel_link_3'		=> 'required|url',
        ], 
		[
			'description.required' => 'This pitch story field is required.',
			'what.required' => 'This field is required.',
			'why.required' => 'This field is required.',
			'how.required' => 'This field is required.',
			'rel_link_1.required' => 'The relevant link 01 field is required.',
			'rel_link_2.required' => 'The relevant link 02 field is required.',
			'rel_link_3.required' => 'The relevant link 03 field is required.',
			'rel_link_1.url' => 'The relevant link 01 format is invalid.',
			'rel_link_2.url' => 'The relevant link 02 format is invalid.',
			'rel_link_3.url' => 'The relevant link 03 format is invalid.',
		]);

        if ($validator->fails()) {
			Session::flash('message', 'There was an error with your submission. Please review the form below and fix as necessary.');
        	Session::flash('alert-class', 'alert-danger');
			return redirect('/pitches/create')
				->withErrors($validator)
				->withInput();
        }
		
		$input				= request()->except(['_token']);
        $input['user_id']	= Auth::user()->id;
        $images				= array();
		
		$budget_sheet_filename = '';
        if ($budget_sheet = $request->file('budget_sheet')) {
			$file_ext	= $budget_sheet->getClientOriginalExtension();
			$budget_sheet_filename	= 'IRP_'.time().'_'.rand(0, 1000000).'.'.$file_ext;
			$budget_sheet->move('assets/images', $budget_sheet_filename);
			$input['budget_sheet']	= $budget_sheet_filename;
        }
		
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
            	$file_ext	= $file->getClientOriginalExtension();
				$filename	= 'IRP_'.time().'_'.rand(0, 1000000).'.'.$file_ext;
                $file->move('assets/images', $filename);
                $images[]	= $filename;
            }
        }
        $input['images']		= implode("|", $images);
        $input['created_at']	= date("Y-m-d H:i:s");
		
		Pitches::create($input);
		
		/*Send Email To ADMINS/EDITORS START*/
		$admins_editors	= DB::table('users')
				->join('users_roles', 'users.id', '=', 'users_roles.user_id')
				->where('users_roles.role_id', '!=', '3')
				->get();
		if(!$admins_editors->isEmpty()){
			$user_info				= Auth::user();
			foreach($admins_editors as $value){
				$email_data_array	= array('user_name' => $value->name, 'email' => $value->email, 'email_subject' => 'New Submission Submitted', 'pitch_name' => $input['title'], 'reporter_name' => $user_info->name);
				$email_data			= (object) $email_data_array;
				Mail::send('mails.pitch_created_admin', array('email_data' => $email_data), function($message) use ($email_data) {
					$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
				});
			}
		}
		/*Send Email END*/
		/*Send Email START*/
		$user				= Auth::user();
		$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'email_subject' => 'Successfully submitted a new Pitch', 'pitch_name' => $input['title']);
		$email_data			= (object) $email_data_array;
		Mail::send('mails.pitch_created', array('email_data' => $email_data), function($message) use ($email_data) {
			$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
		});
		/*Send Email END*/
		
        Session::flash('message', 'Pitch Created Successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/pitches');
    }
    public function details(Request $request, $id){
        $pitch_info = DB::table('pitches')
                ->select('*')
                ->where('pid', $id)
                ->get();

        return view('pitches.view_pitch_details', compact('pitch_info'));
	}
    public function edit(Pitches $pitches){}
    public function update(Request $request, Pitches $pitches){
		$input					= request()->except(['_token']);
		$pitch_status			= $request->pitchstatus;
		
		if($pitch_status == 'Accepted'){
			$input['status']	= '1';
		}else{
			$input['status']	= '2';
		}
		
        $input['approved_by']	= Auth::user()->id;
		unset($input['pitchstatus']);
		Pitches::where('pid', $request->pid)->update($input);
		
		$pitch_user				= Pitches::where('pid', $request->pid)->get();
		$submission_array		= array(
			'user_id'			=> $pitch_user[0]['user_id'],
			'approved_by'		=> $pitch_user[0]['approved_by'],
			'title'				=> $pitch_user[0]['title'],
			'description'		=> $pitch_user[0]['description'],
			'images'			=> $pitch_user[0]['images'],
			'status'			=> 'New'
		);
		
		if($pitch_status == 'Accepted'){
			Submissions::create($submission_array);
		}
		
		/*Send Email START*/
		$user				= User::find($pitch_user[0]['user_id']);
		$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'email_subject'=> 'Your Submission Has Been '.$pitch_status.'!', 'pitch_name' => $pitch_user[0]['title'], 'pitch_status' => $pitch_status);
		$email_data			= (object) $email_data_array;
		Mail::send('mails.pitch_approved', array('email_data' => $email_data), function($message) use ($email_data) {
			$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
		});
		/*Send Email END*/
				
        Session::flash('message', 'Pitch '.$pitch_status.' Successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/pitches');
	}
    public function destroy(Pitches $pitches){}
}
