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
use App\Reviews;
use App\review_questions;
use App\question_rate;
use App\company_types;
use App\ReviewCategory;
use App\Registermailchamp;
use App\Visitors;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use File;
use Redirect;
use URL;
use Cookie;
use App\Invitations;

class ReferalController extends Controller {

  public function __construct() {}

  public function my_referal(Request $request) {
    if (Auth::check()){

      $referalUser = User::where('referal_uid', Auth::user()->id)->paginate(10);
      $numberOfRegisterUser = User::where('referal_uid', Auth::user()->id)->count();
      
      $numberOfVisitors = Visitors::where('referal_uid', Auth::user()->id)->count();

      $invitations = Invitations::where('send_by', Auth::user()->id)->paginate(10);
      $numberOfInvitations = Invitations::where('send_by', Auth::user()->id)->count();

      $url = url('/referal-by/'.Auth::user()->id);
      return view('users.referal_detail',compact('url','numberOfVisitors','numberOfRegisterUser','referalUser','numberOfInvitations','invitations'));
    }
  } 

  public function referal_by(Request $request, $id) {
    if (!Auth::check()){
      $minuts = 7 * 24 * 60;
      Cookie::queue(Cookie::forget('invitation_id'));
      Cookie::queue('referal_uid', $id, $minuts);
    }
      return redirect('/');
  }
  public function invite_link(Request $request, $id) {
      $minuts = 7 * 24 * 60;
      $Invitations = Invitations::where('receiver_email', $id)->orderBy('id', 'asc')->first();
      // $Invitations = Invitations::find($id);
      if($Invitations){
        $Invitations->visit = '1';
        $Invitations->save();
      } else {
        return abort(404);
      }
      Cookie::queue(Cookie::forget('referal_uid'));
      Cookie::queue('invitation_id', $Invitations->id, $minuts);
      return redirect('/');
  }
  
}
