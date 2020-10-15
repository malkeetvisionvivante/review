<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Company;
use App\Managers;
use App\Departments;
use App\Visitors;
use App\Reviews;
use App\UserAgent;
use Illuminate\Support\Facades\Hash;
use File;
use DB;
use Cookie;
use Carbon\Carbon;

class HomeController extends Controller {
    public function __construct() {}
    
    public function home_view() {
        if(Auth::check())  return redirect('/reviews'); 
        $ip_address = UserAgent::IPADDRESS(); 
        $data = Visitors::whereDate('created_at', Carbon::today())->where('ip_address', $ip_address)->get();
        if(count($data) > 0){
        } else {
          $VisitorsObj = new Visitors;
          $VisitorsObj->ip_address = $ip_address;
          $VisitorsObj->location = UserAgent::LOCATION($ip_address);
          $VisitorsObj->device_type = UserAgent::DEVICETYPE();

          if(Cookie::get('referal_uid')){
            $VisitorsObj->referal_uid = Cookie::get('referal_uid');
          }
          if(Cookie::get('invitation_id')){
            $VisitorsObj->invitation_id = Cookie::get('invitation_id');
          }
          if(Auth::user()){
            $VisitorsObj->user_id = Auth::user()->id;
          }
          $VisitorsObj->save();
        }
        return view('frontend.homepage.home');
    }
    
}
