<?php

namespace App\Http\Controllers\Auth;

use DB;
use Mail;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/login?action=verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:10', 'confirmed'],
        ]);
    }

	public function register(Request $request){
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
	
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $request){
		$rules = array(
            'name'		=> 'required',
            'email'		=> 'required',
            'password'	=> 'required',
            'username'	=> 'required',
        );
        $validator = Validator::make($request, $rules);
		
		$filename = '';
		if (isset($request['profile_pic'])) {
			$file = $request['profile_pic'];
			$filename = $file->getClientOriginalName();
			$file->move('assets/images/user_profile', $filename);
			$filename = $filename;
        }
		
		$verification_code = Str::random(25);
		
		/*Send Email START*/
		$email_data_array	= array('user_name' => $request['name'], 'email' => $request['email'], 'email_subject' => 'Verify Your Account', 'verification_code' => $verification_code);
		$email_data			= (object) $email_data_array;
		
		Mail::send('mails.email_verification', array('email_data' => $email_data), function($message) use ($email_data) {
			$message->to($email_data->email, $email_data->user_name)->subject($email_data->email_subject);
		});
		/*Send Email END*/
		
        $user = User::create([
            'name'					=> $request['name'],
            'email'					=> $request['email'],
            'username'				=> $request['username'],
            'password'				=> Hash::make($request['password']),
            'social_fb'				=> $request['social_fb'],
            'social_tw'				=> $request['social_tw'],
            'social_ig'				=> $request['social_ig'],
            'social_lk'				=> $request['social_lk'],
            'bio'					=> $request['bio'],
            'phone'					=> $request['phone'],
            'city'					=> $request['city'],
            'state'					=> $request['state'],
            'verification_code'		=> $verification_code,
            'profile_pic'			=> $filename,
        ]);
		DB::table('users_roles')->insert(
			['user_id' => $user->id, 'role_id' => '3']
        );
		
		return $user;
    }
}
