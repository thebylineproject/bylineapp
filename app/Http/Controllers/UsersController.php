<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/* // Get the currently authenticated user...
  $user = Auth::user();

  // Get the currently authenticated user's ID...
  $id = Auth::id(); */

class UsersController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $users = DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->join('roles', 'roles.id', '=', 'users_roles.role_id')
                ->select('users.*', 'roles.name As rolename')
                ->orderBy('users.id', 'ASC')
                ->get();
        return view('users.manage_users', ['users' => $users]);
    }
    public function edit(Request $request, $id) {
        $roles = DB::table('roles')->get();
        $user = DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->join('roles', 'roles.id', '=', 'users_roles.role_id')
                ->select('users.*', 'roles.name As rolename', 'roles.id As role_id')
                ->where('users.id', '=', $id)
                ->get();
        return view('users.edit_users', compact('user', 'roles'));
    }
    public function update(Request $request) {
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/edit_user/' . $request['uid'] . '');
        }

        $input = $request->all();
		
		$filename = '';
		if ($file = $request->file('profile_pic')) {
			$filename = $file->getClientOriginalName();
			$file->move('assets/images/user_profile', $filename);
			$input['profile_pic'] = $filename;
        }else{
			$input['profile_pic'] = $request['profile_pic_old'];
		}
		
        User::updateUser($input);

        DB::table('users_roles')->where('user_id', $request['uid'])->update(array('role_id' => $request['role']));

        Session::flash('message', 'Update successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/manage_users');
    }
    public function destroy(Request $request, $id) {
        if (User::find($id)) {
            DB::table('users_permissions')->where('user_id', '=', $id)->delete();
            DB::table('users_roles')->where('user_id', '=', $id)->delete();
            DB::table('users')->where('id', '=', $id)->delete();
            
            Session::flash('message', 'Deleted successfully.');
            Session::flash('alert-class', 'alert-success');
            return redirect('/manage_users');
        }
    }
    public function addUserForm() {
        $roles = DB::table('roles')->get();
        return view('users.create_users', compact('roles'));
    }
    public function saveUser(Request $request) {
        $rules = array(
            'name'		=> 'required',
            'email'		=> 'required',
            'password'	=> 'required',
            'role'		=> 'required',
            'username'	=> 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/add_new_user');
        }
        
		$filename = '';
		if ($file = $request->file('profile_pic')) {
			$filename = $file->getClientOriginalName();
			$file->move('assets/images/user_profile', $filename);
			$filename = $filename;
        }
		
		$CurrentDatetime = date("Y-m-d H:i:s");
        $new_user = DB::table('users')->insertGetId(
			['name' => $request['name'], 'email' => $request['email'], 'password' => Hash::make($request['password']), 'social_fb' => $request['social_fb'], 'social_tw' => $request['social_tw'], 'social_ig' => $request['social_ig'], 'social_lk' => $request['social_lk'], 'bio' => $request['bio'], 'profile_pic' => $filename, 'username' => $request['username'], 'phone' => $request['phone'], 'city' => $request['city'], 'state' => $request['state'], 'created_at' => $CurrentDatetime, 'updated_at' => $CurrentDatetime
			]
        );
		
        DB::table('users_roles')->insert(
			['user_id' => $new_user, 'role_id' => $request['role']]
        );
        Session::flash('message', 'User Added Successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/manage_users');
    }
	
    public function user_profiles() {
        $users = DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->join('roles', 'roles.id', '=', 'users_roles.role_id')
                ->select('users.*', 'roles.name As rolename')
				->where('roles.id', '=', '3')
                ->get();
        return view('users.user_profiles', ['users' => $users]);
    }
    public function user_profile_view(Request $request, $id) {
        $user = DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->join('roles', 'roles.id', '=', 'users_roles.role_id')
                ->select('users.*', 'roles.name As rolename', 'roles.id As role_id')
                ->where('users.id', '=', $id)
                ->get();
        
        $submissions = DB::table('submissions')
                ->select('*')
                ->orderBy('created_at', 'DESC')
                ->where('user_id', '=', $user[0]->id)
                ->get();                                   
        return view('users.user_profile_view', compact('user','submissions'));
    }
	public function my_profile() {
		$user_id	= Auth::user()->id;
        $user 		= DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->join('roles', 'roles.id', '=', 'users_roles.role_id')
                ->select('users.*', 'roles.name As rolename', 'roles.id As role_id')
                ->where('users.id', '=', $user_id)
                ->get();
        
        $submissions = DB::table('submissions')
                ->select('*')
                ->orderBy('created_at', 'DESC')
                ->where('user_id', '=', $user_id)
                ->get();  
		
		$my_submissions			= DB::select(DB::raw('SELECT GROUP_CONCAT(sid) AS submissions FROM submissions WHERE user_id = '.$user_id));
		if($my_submissions[0]->submissions != ''){
			$my_submissions_amount_sum	= DB::select(DB::raw("SELECT SUM(amount_paid) AS total_amount FROM fundraising WHERE status = 'COMPLETED' AND submission_id IN (".$my_submissions[0]->submissions.")"));
			if ($my_submissions_amount_sum[0]->total_amount > 0)
				$submissions_amount = '$'.$my_submissions_amount_sum[0]->total_amount;
            else{
				$submissions_amount = '$0';
			}
		}else{
			$submissions_amount = '$0';
		}
        return view('users.my_profile', compact('user', 'submissions', 'submissions_amount'));
    }
    public function update_profile() {
		$user_id	= Auth::user()->id;
        $user 		= DB::table('users')
					->join('users_roles', 'users.id', '=', 'users_roles.user_id')
					->join('roles', 'roles.id', '=', 'users_roles.role_id')
					->select('users.*', 'roles.name As rolename', 'roles.id As role_id')
					->where('users.id', '=', $user_id)
					->get();
		
		$has_apr_pitch = DB::table('pitches')
                ->select('*')
                ->where('user_id', $user_id)
                ->where('status', '1')
                ->get();
		
        return view('users.my_profile_edit', compact('user', 'has_apr_pitch'));
    }
    public function update_my_profile(Request $request) {
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'All fields are required.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/update_profile/');
        }

        $input = $request->all();
		$filename = '';
		if ($file = $request->file('profile_pic')) {
			$filename = $file->getClientOriginalName();
			$file->move('assets/images/user_profile', $filename);
			$input['profile_pic'] = $filename;
        }else{
			$input['profile_pic'] = $request['profile_pic_old'];
		}
		
        User::updateUser($input);
        Session::flash('message', 'Update successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/my_profile');
    }
}
