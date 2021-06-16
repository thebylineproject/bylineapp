<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class MainsiteController extends Controller{
    public function __construct(){
        //$this->middleware('auth');
    }
    public function homepage(){
		return view('front_site.homepage');
    }
    public function legal(){
		return view('front_site.legal');
    }
    public function faq(){
		return view('front_site.faq');
    }
    public function terms(){
		return view('front_site.terms');
    }
    public function policy(){
		return view('front_site.policy');
    }
}
