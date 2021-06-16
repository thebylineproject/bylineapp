<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

// Authentication route
Auth::routes();

// Cache clear route
Route::get(
	'cache-clear', function () {
		\Artisan::call('config:cache');
		\Artisan::call('cache:clear');
		\Artisan::call('config:clear');
		return redirect()->back();
	}
);

Route::get('/', function () {
    return redirect('/homepage');
});

//FRONTSITE
Route::get('/', 'MainsiteController@homepage')->name('homepage');
Route::get('/legal', 'MainsiteController@legal')->name('legal');
Route::get('/faq', 'MainsiteController@faq')->name('faq');
Route::get('/terms', 'MainsiteController@terms')->name('terms');
Route::get('/policy', 'MainsiteController@policy')->name('policy');

Route::get('verify/{id}', 'DonationController@verify')->name('verify');

//Login with Google
Route::get('auth/google', 'Auth\GoogleAndFacebookController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleAndFacebookController@handleGoogleCallback');

//Login with Facebook
Route::get('/redirect', 'Auth\GoogleAndFacebookController@redirectToFacebook');
Route::get('/callback', 'Auth\GoogleAndFacebookController@handleFacebookCallback');

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/roles', 'PermissionController@Permission');

Route::post('/publish_submission', 'SubmissionsController@publish_submission')->name('publish_submission');

//PITCHES
Route::get('/pitches', 'PitchesController@index')->name('pitches');
Route::get('/pitches/create', 'PitchesController@create')->name('create_pitch');
Route::post('/pitches/create', 'PitchesController@store')->name('store_pitch');
Route::get('/details/{id}', 'PitchesController@details')->name('details');
Route::post('/update_pitch', 'PitchesController@update')->name('update_pitch');

//List All Submissions
Route::get('/submissions', 'SubmissionsController@index')->name('submissions');
Route::get('/submission/create', 'SubmissionsController@create')->name('create_submission');
Route::post('/submission/create', 'SubmissionsController@store')->name('store_submission');
Route::get('/delete_submissions/{id}', 'SubmissionsController@destroy')->name('destroy');
Route::get('/edit_submissions/{id}', 'SubmissionsController@edit')->name('edit_submissions');
Route::post('/update_submission', 'SubmissionsController@update')->name('update_submission');
Route::DELETE('/removeImage/{id}', 'SubmissionsController@removeImage')->name('removeImage');

//Update Doc ID
Route::post('/updateGoogleDocId', 'SubmissionsController@updateDocId')->name('updateGoogleDocId');

//List All Milessotnes
Route::get('/milestones/{id}', 'MilestoneController@index')->name('milestones');
Route::get('/milestones/create/{id}', 'MilestoneController@create')->name('create');
Route::get('/delete_milestone/{id}', 'MilestoneController@destroy')->name('destroy');
Route::post('/milestones/store', 'MilestoneController@store')->name('store_milestone');
Route::get('/edit_milestone/{id}', 'MilestoneController@edit')->name('edit_milestone');
Route::post('/update_milestone', 'MilestoneController@update')->name('update_milestone');

//DOWNLOAD ALL FILES
Route::get('/download/{file}', 'FundraisingController@download');

//LIST ALL FUNDRASING

Route::get('/fundraising/requests_history', 'FundraisingController@requests_history')->name('requests_history');

Route::get('/fundraising/request/{id}', 'FundraisingController@fundraising_request')->name('fundraising_request');
Route::post('/fundraising/request_submit', 'FundraisingController@request_submit')->name('request_submit');
Route::post('/fundraising/request_status', 'FundraisingController@request_status')->name('request_status');
Route::get('/fundraising/request_modify/{id}', 'FundraisingController@fundraising_request_edit')->name('fundraising_request_edit');
Route::post('/fundraising/request_submit_update', 'FundraisingController@request_submit_update')->name('request_submit_update');


Route::get('/fundraising/{id}', 'FundraisingController@index')->name('fundraising');
Route::get('/fundraising/create/{id}', 'FundraisingController@create')->name('create');
Route::post('/fundraising/store', 'FundraisingController@store')->name('store_fundraising');
Route::get('/delete_fundraising/{id}', 'FundraisingController@destroy')->name('destroy');
Route::get('/edit_fundraising/{id}', 'FundraisingController@edit')->name('edit_fundraising');
Route::post('/update_fundraising', 'FundraisingController@update')->name('update_fundraising');

#Public Donation pages
Route::get('/share/{id}/{slug}', 'DonationController@index')->name('share');
Route::post('/donation_checkout', 'DonationController@store')->name('donation_checkout');//save payment info
Route::get('/donations/checkout/{id}', 'DonationController@checkout')->name('checkout');// show checkout page
Route::post('/donations/store_payment', 'DonationController@store_payment')->name('store_payment');//save paypal response
Route::get('/donations/thank_you/', 'DonationController@thank_you')->name('thank_youu');//thank you page
Route::get('/donations/payment_failed/', 'DonationController@payment_failed')->name('payment_failedd');//fail page

//Notifications
Route::post('/getNotificationsCounter', 'SubmissionsController@getNotificationsCounter')->name('getNotificationsCounter');
Route::post('/getNotifications', 'SubmissionsController@getNotifications')->name('getNotifications');
Route::post('/readNotifications', 'SubmissionsController@readNotifications')->name('readNotifications');

//Writer Profiles
Route::get('/profiles', 'UsersController@user_profiles')->name('profiles');
Route::get('/user/{id}', 'UsersController@user_profile_view')->name('user');

//Reports
Route::get('/reports', 'FundraisingController@report')->name('reports');
Route::post('/reports', 'FundraisingController@filter_report')->name('filter_report');

//My Profile
Route::get('/my_profile', 'UsersController@my_profile')->name('my_profile');
Route::get('/update_profile', 'UsersController@update_profile')->name('update_profile');
Route::post('/update_profile', 'UsersController@update_my_profile')->name('update_my_profile');
	
Route::group(['middleware' => 'role:admin'], function() {
    //Users
    Route::get('/add_new_user', 'UsersController@addUserForm')->name('new_user');
    Route::post('/create_user', 'UsersController@saveUser')->name('create_user');

    Route::get('/manage_users', 'UsersController@index')->name('manage_users');
    Route::get('/edit_user/{id}', 'UsersController@edit')->name('edit_user');
    Route::post('/update', 'UsersController@update')->name('update');
    Route::get('/delete_user/{id}', 'UsersController@destroy')->name('destroy');
	
	//White Label Config
	Route::get('/white_labels', 'WhiteLabelsController@index')->name('white_labels');
	Route::post('/white_labels/store', 'WhiteLabelsController@store')->name('store_white_labels');
});

Route::group(['middleware' => 'role:editor'], function() {
    Route::get('/admin', function() {
        return 'Welcome editor';
    });
});

Route::group(['middleware' => 'role:writer'], function() {
    Route::get('/admin', function() {
        return 'Welcome writer';
    });	
});
