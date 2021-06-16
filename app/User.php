<?php

namespace App;
use Mail;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordReset;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasPermissionsTrait;

    protected $fillable = [
        'name', 'email', 'password',
        'username', 'social_fb', 'social_tw',
        'social_ig', 'social_lk', 'phone', 'city', 'state',
        'bio', 'profile_pic', 'google_id', 'facebook_id', 'is_verified', 'verification_code',
		'paypal_btn', 'coinbase_btn',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public static function updateUser($request) {                    
        if (!empty($request)) {
            $user				= self::find($request['uid']);
            $user->name			= filter_var($request['name'], FILTER_SANITIZE_STRING);
            $user->social_fb	= filter_var($request['social_fb'], FILTER_SANITIZE_STRING);
            $user->social_tw	= filter_var($request['social_tw'], FILTER_SANITIZE_STRING);
            $user->social_ig	= filter_var($request['social_ig'], FILTER_SANITIZE_STRING);
            $user->social_lk	= filter_var($request['social_lk'], FILTER_SANITIZE_STRING);
            $user->bio			= filter_var($request['bio'], FILTER_SANITIZE_STRING);
            $user->profile_pic	= filter_var($request['profile_pic'], FILTER_SANITIZE_STRING);
            $user->username		= filter_var($request['username'], FILTER_SANITIZE_STRING);
            $user->phone		= filter_var($request['phone'], FILTER_SANITIZE_STRING);
            $user->client_id	= filter_var($request['client_id'], FILTER_SANITIZE_STRING);
            $user->city			= filter_var($request['city'], FILTER_SANITIZE_STRING);
            $user->state		= filter_var($request['state'], FILTER_SANITIZE_STRING);
            $user->paypal_btn	= filter_var($request['paypal_btn']);
            $user->coinbase_btn	= filter_var($request['coinbase_btn']);
            $user->save();
        }
    }
	
	public function sendPasswordResetNotification($token){
		$user_info			= User::where('email', $this->email)->first();
		$reset_pass_link	= $token;
		
		/*Send Email to WRITER START*/
		$email_data_array	= array('user_name' => $user_info->username, 'email' => $user_info->email, 'email_subject' => 'Password Reset', 'reset_pass_link' => $reset_pass_link);
		$email_data			= (object) $email_data_array;
		Mail::send('mails.reset_password', array('email_data' => $email_data), function($message) use ($email_data) {
			$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
		});
		/*Send Email END*/
	}

}
