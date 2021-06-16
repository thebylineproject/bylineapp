<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Submissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class SubmissionsController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user_id	= Auth::user()->id;
        $role_id	= DB::table('users_roles')->where('user_id', '=', $user_id)->first();
        $user_info	= DB::table('users')->where('id', '=', $user_id)->first();
		
		if($user_info->welcome_note == 1){
			if ($role_id->role_id == 3) {
				$submissions = DB::table('submissions')
						->join('users', 'users.id', '=', 'submissions.user_id')
						->where('submissions.user_id', '=', $user_id)
						->select('submissions.*', 'users.name As user_name')
						->orderBy('created_at', 'DESC')
						->get();
			} else {
				$submissions = DB::table('submissions')
						->join('users', 'users.id', '=', 'submissions.user_id')
						->select('submissions.*', 'users.name As user_name')
						->orderBy('created_at', 'DESC')
						->get();
			}
			return view('submissions.manage_submissions', ['user_info' => $user_info, 'submissions' => $submissions]);
		}else{
			return redirect('/pitches/create');
		}
    }

    public function create() {
        return view('submissions.create_submissions');
    }

    public function store(Request $request) {
        $rules = array(
            'title' => 'required',
            'description' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/submission/create')->withInput();
        }
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['status'] = 'New';
        $images = array();
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $file->move('assets/images', $name);
                $images[] = $name;
            }
        }
        $input['images'] = implode("|", $images);
        $CurrentDatetime = date("Y-m-d H:i:s");
        
        DB::table('submissions')->insert(array('title' => $input['title'], 'description' => $input['description'], 'fundraising_goal' => $request['fundraising_goal'], 'images' => $input['images'], 'user_id' => $input['user_id'], 'status' => $input['status'], 'created_at' => $CurrentDatetime, 'updated_at' => $CurrentDatetime));

        Session::flash('message', 'Submission Added Successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/submissions');
    }

    public function edit(Request $request, $id) {
        $submissions = DB::table('submissions')
                ->select('*')
                ->where('sid', '=', $id)
                ->get();

        $submission_status = DB::table('submission_status')
                ->orderBy('title', 'asc')
                ->select('*')
                ->get();

        $fundraisingAmountAll = DB::table('fundraising')
                ->select('*')
                ->where('submission_id', '=', $id)
                ->where('status', '=', 'COMPLETED')
                ->get();
        $fundraisingAmount = 0;
        foreach ($fundraisingAmountAll as $key => $value) {
            $amount = str_replace(',', '', $value->amount);
            $fundraisingAmount += $amount;
        }

        $user = DB::table('users')
                ->select('*')
                ->where('id', '=', $submissions[0]->user_id)
                ->get();

        $fundraising_goal = $amount = str_replace(',', '', $submissions[0]->fundraising_goal);
        return view('submissions.edit_submissions', compact('submissions', 'user', 'submission_status', 'fundraisingAmount', 'fundraising_goal'));
    }

    public function update(Request $request) {
        $rules = array(
            'title' => 'required',
            'description' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/edit_submissions/' . $request['sid'] . '');
        }
        $input = $request->all();
        //here we will get all images first and then we will update images
        $submissionsImages = DB::table('submissions')
                ->select('images', 'user_id')
                ->where('sid', '=', $request['sid'])
                ->get();

        $oldImages = $submissionsImages[0]->images;
        $images = array();
        $newImages = '';
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $file->move('assets/images', $name);
                $images[] = $name;
            }
            $newImages = implode("|", $images);
            $newImages = '|' . $newImages;
        }
        $allImages = $oldImages . $newImages;
        $CurrentDatetime = date("Y-m-d H:i:s");
        DB::table('submissions')->where('sid', $request['sid'])->update(array('title' => $request['title'], 'fundraising_goal' => $request['fundraising_goal'], 'description' => $request['description'], 'status' => $request['submission_status'], 'tip_enable' => $request['tip_enable'], 'images' => $allImages, 'updated_at' => $CurrentDatetime));

        /* Send Email START */
        $user = User::find($submissionsImages[0]->user_id);
        $email_data_array = array('user_name' => $user->name, 'email' => $user->email, 'email_subject' => 'Submission Status Updated', 'submission_name' => $request['title'], 'submission_status' => $request['submission_status']);
        $email_data = (object) $email_data_array;
        Mail::send('mails.submission_updated', array('email_data' => $email_data), function($message) use ($email_data) {
            $message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
        });
        /* Send Email END */

        Session::flash('message', 'Update successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/submissions');
    }

    public function updateDocId(Request $request) {
        $sid = $request['sid'];
        $submission_user = Submissions::where('sid', $sid)->pluck('user_id')->toArray();

        $CurrentDatetime = date("Y-m-d H:i:s");
        DB::table('submissions')->where('sid', $request['sid'])->update(array('doc_id' => $request['doc_id'], 'status' => 'Draft', 'updated_at' => $CurrentDatetime));

        /* Send Email START */
        $user = User::find($submission_user[0]);
        $email_data_array = array('user_name' => $user->name, 'email' => $user->email, 'doc_id' => $request['doc_id'], 'email_subject' => 'The Byline Project Google Doc' . $sid);
        $email_data = (object) $email_data_array;
        Mail::send('mails.submission_google_doc', array('email_data' => $email_data), function($message) use ($email_data) {
            $message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
        });
        /* Send Email END */

        //Insert Notification
        DB::table('notifications')->insert(array('created_by' => Auth::user()->id, 'user_id' => $submission_user[0], 'sub_id' => $sid, 'noti_message' => 'Google Doc has been created associated with your submission#' . $sid, 'created_at' => $CurrentDatetime, 'updated_at' => $CurrentDatetime));

        Session::flash('message', 'Document Created Successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/submissions');
    }

    public function getNotificationsCounter(Request $request) {
        $user_id = $request['user_id'];
        $notifications = DB::select(DB::raw("SELECT * FROM notifications WHERE user_id = '" . $user_id . "' and is_view = '0'"));
        echo (count($notifications));
        die();
    }

    public function getNotifications(Request $request) {
        $user_id = $request['user_id'];
        $user_info = User::where('id', $user_id)->pluck('profile_pic')->toArray();
        $notifications = DB::select(DB::raw("SELECT * FROM notifications WHERE user_id = '" . $user_id . "' and is_view = '0'"));

        $HTML = '<li class="head text-light bg-dark"><div class="row"><div class="col-lg-12 col-sm-12 col-12"><span>Notifications (' . count($notifications) . ')</span> <span class="pull-right"><a href="javascript:;" onclick="readNoti();">Clear all</a></span></div></div></li>';
        foreach ($notifications as $noti) {
            $HTML .= '<li class="notification-box">
						<div class="row">
							<div class="col-lg-1 col-sm-1 col-1 text-center">';
            
            $HTML .= '		</div>
							<div class="col-lg-10 col-sm-10 col-10">
								<strong class="text-info"><a href="' . url('/milestones/' . $noti->sub_id) . '">' . $noti->noti_message . '</a></strong>
								<div></div>
								<small class="text-warning">' . date('d F, Y', strtotime($noti->created_at)) . '</small>
							</div>
							<div class="col-lg-1 col-sm-1 col-1"></div>
						</div>
					</li>';
        }
        $HTML .= '<li class="footer bg-dark text-center"></li>';
        echo $HTML;
    }

    public function readNotifications(Request $request) {
        $user_id = $request['user_id'];
        $CurrentDatetime = date("Y-m-d H:i:s");
        DB::table('notifications')->where('user_id', $user_id)->where('is_view', '0')->update(array('is_view' => '1', 'updated_at' => $CurrentDatetime));
    }

    public function destroy(Request $request, $id) {
        DB::table('submissions')->where('sid', '=', $id)->delete();
        Session::flash('message', 'Deleted successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/submissions');
    }

    public function removeImage($id) {
        $explodeData = explode('|', $id);
        $id = $explodeData[0];
        $item = $explodeData[1];
        $submissionsImages = DB::table('submissions')
                ->select('images')
                ->where('sid', '=', $id)
                ->get();
        $parts = explode('|', $submissionsImages[0]->images);
        while (($i = array_search($item, $parts)) !== false) {
            unset($parts[$i]);
        }
        $parts = implode('|', $parts);
        DB::table('submissions')->where('sid', $id)->update(array('images' => $parts));
    }
	
	public function publish_submission(Request $request) {
		$submission_id		= $request->sid;
		$google_doc_data	= json_decode($request->docBody, true);
		
		$google_doc_content	= '';
		foreach ($google_doc_data['content'] as $key_doc => $val_doc) {
			if ($key_doc > 0) {
				$google_doc_content .= $val_doc['paragraph']['elements'][0]['textRun']['content'];
			}
		}
		
		$google_doc_content .= '<br/> [bylinetips submission="'.$submission_id.'"]';
		
        $submissions = DB::table('submissions')
                ->select('*')
                ->where('sid', '=', $submission_id)
                ->get();

        $userInfo = DB::table('users')
                ->select('*')
                ->where('id', '=', $submissions[0]->user_id)
                ->get();

        $pubInfo = DB::table('white_labels')
                ->select('*')
                ->where('created_by', '=', '1')
                ->get();

        $API_FILENAME		= 'import_byline_articles.php';
        $endpoint			= $pubInfo[0]->publisher_website;
        $END_POINT_URL		= $endpoint . $API_FILENAME;
        $client				= new \GuzzleHttp\Client();
        $submission_images	= array();
		
        if ($submissions[0]->images) {
            foreach (explode('|', $submissions[0]->images) as $key_image => $val_image) {
                if ($val_image) {
                    $submission_images[] = "https://".$_SERVER['SERVER_NAME'].'/assets/images/' . $val_image;
                }
            }
        }

        $client->curl = [
            CURLOPT_TCP_KEEPALIVE	=> 1,
        ];
		
		$story_link	= "https://".$_SERVER['SERVER_NAME']."/share/".$submission_id."/story";
        $response	= $client->request('GET', $END_POINT_URL, [
            'headers' => [
                'Authorization' => $pubInfo[0]->auth_token,
            ],
            'query' => [
                'submission_id'	=> $submission_id,
                'post_title'	=> $submissions[0]->title,
                //'post_excerpt'=> $submissions[0]->description
                'post_content'	=> $google_doc_content,
                'images'		=> $submissions[0]->images,
                'username'		=> $userInfo[0]->username,
                'first_name'	=> $userInfo[0]->name,
                'email'			=> $userInfo[0]->email,
                'user_pass'		=> $userInfo[0]->password,
                'user_bio'		=> $userInfo[0]->bio,
                'created_date'	=> $userInfo[0]->created_at,
                'sub_images'	=> $submission_images,
            ]
        ]);

        $content	= json_decode($response->getBody()->getContents(), true);
        if ($content['code'] == '200') {
			$reporter_name		= $userInfo[0]->name;
            /* Send Email To ADMINS/EDITORS START */
			$admins_writers		= DB::table('users')
				->join('users_roles', 'users.id', '=', 'users_roles.user_id')
				->where('users_roles.role_id', '!=', '3')
				->get();
				if (!$admins_writers->isEmpty()) {
					foreach ($admins_writers as $value) {
						$email_data_array = array('user_name' => $value->name, 'email' => $value->email, 'story_link' => $story_link, 'reporter_name' => $reporter_name, 'email_subject' => 'Submission has been Published to OKP', 'submission_name' => $submissions[0]->title);
						$email_data = (object) $email_data_array;
						Mail::send('mails.submission_published', array('email_data' => $email_data), function($message) use ($email_data) {
							$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
						});
					}
				} 
            /* Send Email END */
            $message = 'success';
        } else {
            $message = 'error';
        }
       	echo $message;
	}
}
