<?php

namespace App\Http\Controllers\Auth;

use DB;
use Auth;
use Mail;
use App\User;
use Exception;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GoogleAndFacebookController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public $password		= 'irp1234';
	public $redirect_url	= '/submissions';
	 
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function handleGoogleCallback(){
        try {
            $user		= Socialite::driver('google')->user();
            $finduser	= User::where('google_id', $user->id)->first();
			
			if($finduser){
                Auth::login($finduser);
                return redirect($this->redirect_url);
            }else{
                $new_user = User::create([
                    'name'			=> $user->name,
                    'username'		=> $user->name,
                    'email'			=> $user->email,
                    'google_id'		=> $user->id,
					'is_verified'	=> '1',
                    'password'		=> Hash::make($this->password),
                ]);
				
				DB::table('users_roles')->insert(
					['user_id' => $new_user->id, 'role_id' => '3']
				);
				
				/*Send Email to WRITER START*/
				$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'email_subject' => 'The Byline Project Registration Confirmation');
				$email_data			= (object) $email_data_array;
				Mail::send('mails.email_welcome', array('email_data' => $email_data), function($message) use ($email_data) {
					$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
				});
				/*Send Email END*/
				
                Auth::login($new_user);
                return redirect($this->redirect_url);
            }
        } catch (Exception $e) {
			return redirect('/login?action=exist');
        }
    }
	
	/**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
	
	/**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function handleFacebookCallback(){		
		try {
            $user		= Socialite::driver('facebook')->user();
            $finduser	= User::where('facebook_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect($this->redirect_url);
            }else{
                $new_user = User::create([
                    'name'			=> $user->name,
                    'username'		=> $user->name,
                    'email'			=> $user->email,
                    'facebook_id'	=> $user->id,
					'is_verified'	=> '1',
                    'password'		=> Hash::make($this->password),
                ]);
				
				DB::table('users_roles')->insert(
					['user_id' => $new_user->id, 'role_id' => '3']
				);
				
				/*Send Email to WRITER START*/
				$email_data_array	= array('user_name' => $user->name, 'email' => $user->email, 'email_subject' => 'The Byline Project Registration Confirmation');
				$email_data			= (object) $email_data_array;
				Mail::send('mails.email_welcome', array('email_data' => $email_data), function($message) use ($email_data) {
					$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
				});
				/*Send Email END*/
				
                Auth::login($new_user);
                return redirect($this->redirect_url);
            }
        } catch (Exception $e) {
			return redirect('/login?action=exist');
        }
    }
}