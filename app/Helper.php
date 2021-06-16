<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

if(!function_exists('get_submission_name')){
	function get_submission_name($sub_id){
		$submissions_info	= DB::table('submissions')
			->where('sid', $sub_id)
			->first();
		return $submissions_info;
	}
}
if(!function_exists('get_user_info')){
	function get_user_info($user_id){
		$user_info	= DB::table('users')
			->where('id', $user_id)
			->get();
		
		return $user_info;
	}
}
