<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Helper;
use App\Submissions;
use App\Fundraising_requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FundraisingController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request, $id) {
        $fundraising = DB::table('fundraising')
                ->where('submission_id', '=', $id)
				->where('status', '=', 'COMPLETED')
                ->select('*')
                ->orderBy('fid', 'DESC')
                ->get();

        $submissions = DB::table('submissions')
                        ->where('sid', '=', $id)
                        ->select('*')->get();
						
        $submissions_author = DB::table('users')
                        ->where('id', '=', $submissions[0]->user_id)
                        ->select('*')->get();

        return view('fundraising.manage_fundraising', compact('fundraising', 'id', 'submissions', 'submissions_author'));
    }

    public function create(Request $request, $id) {
        $submissions = DB::table('submissions')
                        ->where('sid', '=', $id)
                        ->select('*')->get();

        $submissions_author = DB::table('users')
                        ->where('id', '=', $submissions[0]->user_id)
                        ->select('*')->get();
        return view('fundraising.add_fundraising', compact('id', 'submissions', 'submissions_author'));
    }

    public function store(Request $request) {
        $sid	= $request['sid'];
        $rules	= array(
            'funder_name'	=> 'required',
            'amount'		=> 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/fundraising/create/' . $sid)->withInput();
        }
        $user_id			= Auth::user()->id;
        $CurrentDatetime	= date("Y-m-d H:i:s");
        $last_inserted_id	= DB::table('fundraising')->insertGetId(
			array(
				'user_id'			=> $user_id,
				'submission_id'		=> $request['sid'],
				'funder_name'		=> $request['funder_name'],
				'reference_id'		=> $request['reference_id'],
				'amount'			=> $request['amount'], 
				'status'			=> 'STARTED', 
				
				'created_at'		=> $CurrentDatetime,
				'updated_at'		=> $CurrentDatetime
			)
		);
		
        return redirect('/fundraising/checkout/' . $last_inserted_id);
    }

    public function edit(Request $request, $id) {
        $fundraising = DB::table('fundraising')
                ->select('*')
                ->where('fid', '=', $id)
                ->get();
        return view('fundraising.edit_fundraising', compact('fundraising'));
    }

    public function update(Request $request) {
        $sid = $request['sid'];
        $fid = $request['fid'];

        $rules = array(
            'amount' => 'required',
            'funder_name' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/edit_fundraising/' . $fid);
        }
        $CurrentDatetime = date("Y-m-d H:i:s");
        DB::table('fundraising')->where('fid', $fid)->update(array('amount' => $request['amount'], 'funder_name' => $request['funder_name'], 'updated_at' => $CurrentDatetime));
        Session::flash('message', 'Update successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/fundraising/' . $sid);
    }

    public function destroy($id) {
        $submissionsID = DB::table('fundraising')
                ->select('*')
                ->where('fid', '=', $id)
                ->get();
        $sid = $submissionsID[0]->submission_id;
        DB::table('fundraising')->where('fid', '=', $id)->delete();
        Session::flash('message', 'Deleted successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/fundraising/' . $sid);
    }

    public function report() {
        $fundraising = DB::table('fundraising')
				->join('submissions', 'submissions.sid', '=', 'fundraising.submission_id')
				->where('fundraising.status', '=', 'COMPLETED')
                ->select('fundraising.*', 'submissions.title as sub_title')
                ->orderBy('fundraising.fid', 'DESC')
                ->get();

        return view('reports.create_report', compact('fundraising'));
    }
	
    public function filter_report(Request $request) {
		$amount	= '';
		$date	= '';
		
		if(isset($request->start_date) && isset($request->end_date)){
			$date = " AND fundraising.created_at BETWEEN '".$request->start_date."' AND '".$request->end_date."'";
		}
		
		if(isset($request->amount)){
			$amount = " AND fundraising.amount_paid >= ".$request->amount;
		}
		
		$fundraising = DB::select(DB::raw("select fundraising.*, submissions.title as sub_title from fundraising 
							LEFT JOIN submissions on submissions.sid = fundraising.submission_id
							where fundraising.status = 'COMPLETED'".$amount.$date));
		
        return view('reports.filter_report', compact('fundraising'));
    }
	
    public function fundraising_request(Request $request, $id) {
        $submissions = DB::table('submissions')
                        ->where('sid', '=', $id)
                        ->select('*')->get();
						
        $submissions_author = DB::table('users')
                        ->where('id', '=', $submissions[0]->user_id)
                        ->select('*')->get();

        return view('fundraising.fundraising_request', compact('id', 'submissions', 'submissions_author'));
    }
	
    public function request_submit(Request $request) {
        $sid		= $request['sid'];
		$validator	= Validator::make($request->all(), [
            'reason'		=> 'required|string',
            'amount'		=> 'required|string',
			'images'		=> 'required|mimes:pdf,xlsx,xls',
        ]);

        if ($validator->fails()) {
			return redirect('/fundraising/request/'.$sid)
				->withErrors($validator)
				->withInput();
        }
		
		$filename		= '';
		if ($files		= $request->file('images')) {
			$file_ext	= $files->getClientOriginalExtension();
			$filename	= 'IRP_'.time().'_'.rand(0, 1000000).'.'.$file_ext;
						  $files->move('assets/images', $filename);
        }
		
		$input					= request()->except(['_token']);
        $input['user_id']		= Auth::user()->id;
		$input['submission_id']	= $sid;
		$input['expense_report']= $filename;
        $input['status']		= 'Pending';
        $input['created_at']	= date("Y-m-d H:i:s");
		
		Fundraising_requests::create($input);
		Session::flash('message', 'Request Submitted successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/submissions');
    }
	
    public function requests_history(Request $request) {
		$user_id	= Auth::user()->id;
        $role_id	= DB::table('users_roles')->where('user_id', '=', $user_id)->first();
		
        if ($role_id->role_id == 3) {
            $fundraising_requests = DB::table('fundraising_requests')
                    ->join('users', 'users.id', '=', 'fundraising_requests.user_id')
                    ->join('submissions', 'submissions.sid', '=', 'fundraising_requests.submission_id')
                    ->where('fundraising_requests.user_id', '=', $user_id)
                    ->select('fundraising_requests.*', 'submissions.title', 'users.name As user_name')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        } else {
            $fundraising_requests = DB::table('fundraising_requests')
                    ->join('users', 'users.id', '=', 'fundraising_requests.user_id')
                    ->join('submissions', 'submissions.sid', '=', 'fundraising_requests.submission_id')
                    ->select('fundraising_requests.*', 'submissions.title', 'users.name As user_name')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        }
		
        return view('fundraising.manage_fundraising_requests', compact('fundraising_requests'));
    }
	
    public function request_status(Request $request) {		
		$input						= request()->except(['_token', 'request_id']);
        $input['status_updated_by']	= Auth::user()->id;
		Fundraising_requests::where('frid', $request->request_id)->update($input);
	}
	
    public function fundraising_request_edit(Request $request, $id) {
		$fundraising = Fundraising_requests::where('frid', $id)->get();
		$submissions = Submissions::where('sid', $fundraising[0]->submission_id)->get();
		$author		 = User::where('id', $fundraising[0]->user_id)->get();
		
        return view('fundraising.edit_fundraising_request', compact('id', 'fundraising','submissions', 'author'));
    }
	public function request_submit_update(Request $request) {
		$frid		= $request->frid;
		$validator	= Validator::make($request->all(), [
            'reason'	=> 'required|string',
            'amount'	=> 'required|string',
        ]);

        if ($validator->fails()) {
			return redirect('/fundraising/request_modify/'.$frid)
				->withErrors($validator)
				->withInput();
        }
		
		$filename		= '';
		if ($files		= $request->file('images')) {
			$file_ext	= $files->getClientOriginalExtension();
			$filename	= 'IRP_'.time().'_'.rand(0, 1000000).'.'.$file_ext;
						  $files->move('assets/images', $filename);
        }
		
		$input			= request()->except(['_token']);
		
		if($filename == ''){
			$input['expense_report']	= $request->expense_report;
		}else{
			$input['expense_report']	= $filename;
		}
        
		Fundraising_requests::where('frid', $request->frid)->update($input);
		Session::flash('message', 'Request Updated successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/fundraising/requests_history');
    }
	public function download($file_name) {
		$file_path = public_path('assets/images/'.$file_name);
		return response()->download($file_path);
	}
}
