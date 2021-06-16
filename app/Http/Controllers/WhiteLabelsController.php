<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Submissions;
use App\White_labels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class WhiteLabelsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user_id = Auth::user()->id;
        $labels = White_labels::where('wid', '1')
                ->orderBy('wid', 'desc')
                ->get();
        
        return view('white_labels.create_white_labels', ['labels' => $labels]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'publisher_name' => 'required|string',
                    'contact_email' => 'required|string',
                    'description' => 'required|string',
                    'publisher_website' => 'required|string',
                    'address_1' => 'required|string',
                    'google_email' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/white_labels')
                            ->withErrors($validator)
                            ->withInput();
        }
        $user_id = Auth::user()->id;
        $input = request()->except(['_token']);
        $input['created_by'] = $user_id;
        $input['created_at'] = date("Y-m-d H:i:s");

        $logo_filename = '';
        if ($logo_sheet = $request->file('logo')) {
            $file_ext = $logo_sheet->getClientOriginalExtension();

            $logo_filename = 'logo.png';
            $logo_sheet->move('imgs', $logo_filename);
            $input['logo'] = $logo_filename;
        } else {
            $input['logo'] = $request->logo_old;
        }

        if ($request->wid) {
            unset($input['logo_old']);
            White_labels::where('wid', $request->wid)->update($input);
        } else {
            White_labels::create($input);
        }

        Session::flash('message', 'Settings has been saved Successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/white_labels');
    }


}
