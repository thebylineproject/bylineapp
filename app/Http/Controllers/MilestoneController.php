<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Helper;
use App\Submissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MilestoneController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id) {
		$submissions = DB::table('submissions')
                ->select('*')
                ->where('sid', '=', $id)
                ->get();
		
		$submissions_author = DB::table('users')
				->where('id', '=', $submissions[0]->user_id)
				->select('*')->get();
			
        $submission_milestone = DB::table('submission_milestone')
			->where('submission_id', '=', $id)
			->select('*')
			->orderBy('due_date', 'ASC')
			->get();
			
		$new_array	= array();
		$counter	= 0;
		$i			= 0;
		$curr_date	= strtotime("now");
		
		foreach($submission_milestone as $milestone){
			$active = '';
			if(strtotime($milestone->due_date) > $curr_date){
				if($i == 0){
					$active = 'active';
					$i++;
				}
			}
			$new_array[$counter]['milestone_id'] = $milestone->milestone_id;
			$new_array[$counter]['user_id'] = $milestone->user_id;
			$new_array[$counter]['submission_id'] = $milestone->submission_id;
			$new_array[$counter]['title'] = $milestone->title;
			$new_array[$counter]['description'] = $milestone->description;
			$new_array[$counter]['due_date'] = $milestone->due_date;
			$new_array[$counter]['created_at'] = $milestone->created_at;
			$new_array[$counter]['updated_at'] = $milestone->updated_at;
			$new_array[$counter]['active'] = $active;
			$counter++;
		}
		
		$submission_milestone = array_reverse($new_array);		
        return view('milestones.manage_milestones', compact('submission_milestone', 'id', 'submissions', 'submissions_author'));
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id) {
        return view('milestones.add_milestones', compact('id'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $sid = $request['sid'];		
		$submission_user = Submissions::where('sid', $sid)->pluck('user_id')->toArray();
		
        $rules = array(
            'title' => 'required',
            'description_milesstone' => 'required',
            'due_date' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/milestones/create/' . $sid)->withInput();
        }

        $user_id = Auth::user()->id;
        $CurrentDatetime = date("Y-m-d H:i:s");
        DB::table('submission_milestone')->insert(array('user_id' => $user_id, 'submission_id' => $request['sid'], 'title' => $request['title'], 'description' => $request['description_milesstone'], 'due_date' => $request['due_date'], 'created_at' => $CurrentDatetime, 'updated_at' => $CurrentDatetime));
		
		/*Send Email START*/
		$user				= User::find($submission_user[0]);
		$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'email_subject' => 'Milestone has been added', 'title' => $request['title']);
		$email_data			= (object) $email_data_array;
		Mail::send('mails.milestone', array('email_data' => $email_data), function($message) use ($email_data) {
			$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
		});
		/*Send Email END*/		
		
		//Insert Notification
        DB::table('notifications')->insert(array('created_by' => $user_id, 'user_id' => $submission_user[0], 'sub_id' => $sid, 'noti_message' => 'Admin has created a milestone "'.$request['title'].'" for you!', 'created_at' => $CurrentDatetime, 'updated_at' => $CurrentDatetime));
		
        Session::flash('message', 'Milesstone Added Successfully.');
        Session::flash('alert-class', 'alert-success');

        return redirect('/milestones/' . $sid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $milestones = DB::table('submission_milestone')
                ->select('*')
                ->where('milestone_id', '=', $id)
                ->get();
        return view('milestones.edit_milestone', compact('milestones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $sid = $request['sid'];
        $milestone_id = $request['milestone_id'];
        $rules = array(
            'title' => 'required',
            'description_milesstone' => 'required',
            'due_date' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/edit_milestone/' . $milestone_id);
        }
        $CurrentDatetime = date("Y-m-d H:i:s");
        DB::table('submission_milestone')->where('milestone_id', $milestone_id)->update(array('title' => $request['title'], 'description' => $request['description_milesstone'], 'due_date' => $request['due_date'], 'updated_at' => $CurrentDatetime));
        Session::flash('message', 'Update successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/milestones/' . $sid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $submissionsID = DB::table('submission_milestone')
                ->select('*')
                ->where('milestone_id', '=', $id)
                ->get();
        DB::table('submission_milestone')->where('milestone_id', '=', $id)->delete();
        Session::flash('message', 'Deleted successfully.');
        Session::flash('alert-class', 'alert-success');
        $sid = $submissionsID[0]->submission_id;
        return redirect('/milestones/' . $sid);
    }

}
