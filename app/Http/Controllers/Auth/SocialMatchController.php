<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
use App\User;
use App\Registermailchamp;
use URL;
use Cookie;
use Session;
use App\UserAgent;
use Carbon\Carbon;
use App\Invitations;
use App\AdminNotification;

class SocialMatchController extends Controller {

    public function linkedinMatchUser($id) {
      try {
        if($id == 0){
          $linkdinUser = Session::get('socialMatchUserDAta');
          $imageName = null;
          $firstName = $linkdinUser->name;
          $lastName = null;
          $name = explode(' ', $linkdinUser->name);
          if(isset($name[0])){
              $firstName = $name[0];
          }
          if(isset($name[1])){
              $lastName = $name[1];
          }
          if($linkdinUser->avatar_original){
              $imageName = uniqid().".jpg";
              file_put_contents(public_path().'/images/users/'.$imageName, file_get_contents($linkdinUser->avatar_original));
          }
          $user = new User;
          $user->status = 1;
          $user->name = $firstName;
          $user->last_name = $lastName;
          $user->email = $linkdinUser->email;
          $user->linkedin_id = $linkdinUser->id;
          $user->profile = $imageName;
          if(Cookie::get('referal_uid')){
            $user->type = 'Referral';
            $user->referal_uid = Cookie::get('referal_uid');
          } else if(Cookie::get('invitation_id')){
            $user->type = 'Invited';
            $user->invitation_id = Cookie::get('invitation_id');

            $invitationData = Invitations::find($user->invitation_id);
            if($invitationData){
              if($invitationData->send_by){
                $invityData = User::find($invitationData->send_by);
                $user->company_id = $invityData->company_id;
              }
            }

          } else {
            $user->type = 'Registerd';
          }
          if(Session::get('socailSignUpAccountOrigin')){
            $user->account_origin = Session::get('socailSignUpAccountOrigin');
            Session::forget('socailSignUpAccountOrigin');
          }
          $ip_address = UserAgent::IPADDRESS();
          $user->ip_address = $ip_address;
          $user->location = UserAgent::LOCATION($ip_address);
          $user->device_type = UserAgent::DEVICETYPE();
          $user->last_login_at = Carbon::now();
          $user->login_count = 1;
          $user->save();
          Registermailchamp::register($user->id);
          Auth::loginUsingId($user->id);
          AdminNotification::isProfileMatchSocial($user->name, $user->last_name, $user->email);
          Cookie::queue(Cookie::forget('referal_uid'));
          Cookie::queue(Cookie::forget('invitation_id'));
          Session::forget('socialMatchUserDAta');

          toastr()->success('Login successful!'); 
          if(Cookie::get('loginPreviusUrl')){
            $path = Cookie::get('loginPreviusUrl');
            Cookie::queue(Cookie::forget('loginPreviusUrl'));
            return redirect()->away($path);
          } else {
            return redirect('/reviews');
          }
        } else {
          $linkdinUser = Session::get('socialMatchUserDAta');
          $imageName = null;
          $firstName = $linkdinUser->name;
          $lastName = null;
          $name = explode(' ', $linkdinUser->name);
          if(isset($name[0])){
              $firstName = $name[0];
          }
          if(isset($name[1])){
              $lastName = $name[1];
          }
          if($linkdinUser->avatar_original){
              $imageName = uniqid().".jpg";
              file_put_contents(public_path().'/images/users/'.$imageName, file_get_contents($linkdinUser->avatar_original));
          }
          $user = User::find($id);
          $user->name = $firstName;
          $user->last_name = $lastName;
          $user->email = $linkdinUser->email;
          $user->linkedin_id = $linkdinUser->id;
          $user->profile = $imageName;
          $user->created_at = Carbon::now();
          $user->type = 'Registerd';
          $user->claimed = 'yes';
          if(Session::get('socailSignUpAccountOrigin')){
            $user->account_origin = Session::get('socailSignUpAccountOrigin');
            Session::forget('socailSignUpAccountOrigin');
          }
          $ip_address = UserAgent::IPADDRESS();
          $user->ip_address = $ip_address;
          $user->location = UserAgent::LOCATION($ip_address);
          $user->device_type = UserAgent::DEVICETYPE();
          $user->last_login_at = Carbon::now();
          $user->login_count = 1;
          $user->save();
          Registermailchamp::register($user->id);
          
          Auth::loginUsingId($user->id);
          AdminNotification::isProfileMatchSocial($user->name, $user->last_name, $user->email);
          Cookie::queue(Cookie::forget('referal_uid'));
          Cookie::queue(Cookie::forget('invitation_id'));
          Session::forget('socialMatchUserDAta');

          toastr()->success('Login successful!'); 
          if(Cookie::get('loginPreviusUrl')){
            $path = Cookie::get('loginPreviusUrl');
            Cookie::queue(Cookie::forget('loginPreviusUrl'));
            return redirect()->away($path);
          } else {
            return redirect('/reviews');
          }
        }
      } catch (Exception $e) {
        return redirect('/');
      }
    }
    public function facebookMatchUser($id) {
      try {
          if($id == 0){
            $userSocial = Session::get('socialMatchUserDAta');
            $imageName = null;
            $firstName = $userSocial->name;
            $lastName = null;
            $name = explode(' ', $userSocial->name);
            if(isset($name[0])){
                $firstName = $name[0];
            }
            if(isset($name[1])){
                $lastName = $name[1];
            }
            if($userSocial->avatar_original){
                $imageName = uniqid().".jpg";
                file_put_contents(public_path().'/images/users/'.$imageName, file_get_contents($userSocial->avatar_original));
            }

            $createUser = new User;
            $createUser->status = 1;
            $createUser->name = $firstName;
            $createUser->last_name = $lastName;
            $createUser->email = $userSocial->email;
            $createUser->facebook_id = $userSocial->id;
            $createUser->profile = $imageName;
            if(Cookie::get('referal_uid')){
              $createUser->type = 'Referral';
              $createUser->referal_uid = Cookie::get('referal_uid');
            } else if(Cookie::get('invitation_id')){
              $createUser->type = 'Invited';
              $createUser->invitation_id = Cookie::get('invitation_id');

               $invitationData = Invitations::find($createUser->invitation_id);
                if($invitationData){
                  if($invitationData->send_by){
                    $invityData = User::find($invitationData->send_by);
                    $createUser->company_id = $invityData->company_id;
                  }
                }
            } else {
              $createUser->type = 'Registerd';
            }

            if(Session::get('socailSignUpAccountOrigin')){
              $createUser->account_origin = Session::get('socailSignUpAccountOrigin');
              Session::forget('socailSignUpAccountOrigin');
            }

            $ip_address = UserAgent::IPADDRESS();
            $createUser->ip_address = $ip_address;
            $createUser->location = UserAgent::LOCATION($ip_address);
            $createUser->device_type = UserAgent::DEVICETYPE();
            $createUser->last_login_at = Carbon::now();
            $createUser->login_count = 1;
            $createUser->save();
            Registermailchamp::register($createUser->id);
            
            Auth::loginUsingId($createUser->id);
            AdminNotification::isProfileMatchSocial($createUser->name, $createUser->last_name, $createUser->email);
            toastr()->success('Login successful!'); 
            Cookie::queue(Cookie::forget('referal_uid'));
            Cookie::queue(Cookie::forget('invitation_id'));
            Session::forget('socialMatchUserDAta');

            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('/reviews');
            }
          } else {
            $userSocial = Session::get('socialMatchUserDAta');
            $imageName = null;
            $firstName = $userSocial->name;
            $lastName = null;
            $name = explode(' ', $userSocial->name);
            if(isset($name[0])){
                $firstName = $name[0];
            }
            if(isset($name[1])){
                $lastName = $name[1];
            }
            if($userSocial->avatar_original){
                $imageName = uniqid().".jpg";
                file_put_contents(public_path().'/images/users/'.$imageName, file_get_contents($userSocial->avatar_original));
            }

            $createUser = User::find($id);
            $createUser->name = $firstName;
            $createUser->last_name = $lastName;
            $createUser->email = $userSocial->email;
            $createUser->facebook_id = $userSocial->id;
            $createUser->profile = $imageName;
            $createUser->created_at = Carbon::now();
            $createUser->type = 'Registerd';
            $createUser->claimed = 'yes';
            if(Session::get('socailSignUpAccountOrigin')){
              $createUser->account_origin = Session::get('socailSignUpAccountOrigin');
              Session::forget('socailSignUpAccountOrigin');
            }
            $ip_address = UserAgent::IPADDRESS();
            $createUser->ip_address = $ip_address;
            $createUser->location = UserAgent::LOCATION($ip_address);
            $createUser->device_type = UserAgent::DEVICETYPE();
            $createUser->last_login_at = Carbon::now();
            $createUser->login_count = 1;
            $createUser->save();
            Registermailchamp::register($createUser->id);
            
            Auth::loginUsingId($createUser->id);
            AdminNotification::isProfileMatchSocial($createUser->name, $createUser->last_name, $createUser->email);
            toastr()->success('Login successful!'); 
            Cookie::queue(Cookie::forget('referal_uid'));
            Cookie::queue(Cookie::forget('invitation_id'));
            Session::forget('socialMatchUserDAta');

            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('/reviews');
            }
          }
      } catch (Exception $e) {
        return redirect('/');
      }
    }
    public function googleMatchUser($id) {
        try {
          if($id == 0){
            $user = Session::get('socialMatchUserDAta');
            $imageName = null;
            $firstName = $user->name;
            $lastName = null;
            $name = explode(' ', $user->name);
            if(isset($name[0])){
                $firstName = $name[0];
            }
            if(isset($name[1])){
                $lastName = $name[1];
            }
              
            if($user->avatar){
                $imageName = uniqid().".jpg";
                file_put_contents(public_path().'/images/users/'.$imageName, file_get_contents($user->avatar));
            }
            $createUser = new User;
            $createUser->status = 1;
            $createUser->name = $firstName;
            $createUser->last_name = $lastName;
            $createUser->email = $user->email;
            $createUser->google_id = $user->id;
            $createUser->profile = $imageName;
            if(Cookie::get('referal_uid')){
              $createUser->type = 'Referral';
              $createUser->referal_uid = Cookie::get('referal_uid');
            } else if(Cookie::get('invitation_id')){
              $createUser->type = 'Invited';
              $createUser->invitation_id = Cookie::get('invitation_id');
              $invitationData = Invitations::find($createUser->invitation_id);
              if($invitationData){
                if($invitationData->send_by){
                  $invityData = User::find($invitationData->send_by);
                  $createUser->company_id = $invityData->company_id;
                }
              }
            } else {
              $createUser->type = 'Registerd';
            }

            if(Session::get('socailSignUpAccountOrigin')){
              $createUser->account_origin = Session::get('socailSignUpAccountOrigin');
              Session::forget('socailSignUpAccountOrigin');
            }

            $ip_address = UserAgent::IPADDRESS();
            $createUser->ip_address = $ip_address;
            $createUser->location = UserAgent::LOCATION($ip_address);
            $createUser->device_type = UserAgent::DEVICETYPE();
            $createUser->last_login_at = Carbon::now();
            $createUser->login_count = 1;
            $createUser->save();
            Registermailchamp::register($createUser->id);
            
            Auth::loginUsingId($createUser->id);
            AdminNotification::isProfileMatchSocial($createUser->name, $createUser->last_name, $createUser->email);
            toastr()->success('Login successful!'); 
            Cookie::queue(Cookie::forget('referal_uid'));
            Cookie::queue(Cookie::forget('invitation_id'));
            Session::forget('socialMatchUserDAta');

            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('/reviews');
            }
          } else {
            $user = Session::get('socialMatchUserDAta');
            $imageName = null;
            $firstName = $user->name;
            $lastName = null;
            $name = explode(' ', $user->name);
            if(isset($name[0])){
                $firstName = $name[0];
            }
            if(isset($name[1])){
                $lastName = $name[1];
            }
              
            if($user->avatar){
                $imageName = uniqid().".jpg";
                file_put_contents(public_path().'/images/users/'.$imageName, file_get_contents($user->avatar));
            }
            $createUser = User::find($id);
            $createUser->name = $firstName;
            $createUser->last_name = $lastName;
            $createUser->email = $user->email;
            $createUser->google_id = $user->id;
            $createUser->profile = $imageName;
            $createUser->claimed = 'yes';
            $createUser->type = 'Registerd';
            if(Session::get('socailSignUpAccountOrigin')){
              $createUser->account_origin = Session::get('socailSignUpAccountOrigin');
              Session::forget('socailSignUpAccountOrigin');
            }
            $createUser->created_at = Carbon::now();
            $ip_address = UserAgent::IPADDRESS();
            $createUser->ip_address = $ip_address;
            $createUser->location = UserAgent::LOCATION($ip_address);
            $createUser->device_type = UserAgent::DEVICETYPE();
            $createUser->last_login_at = Carbon::now();
            $createUser->login_count = 1;
            $createUser->save();
            Registermailchamp::register($createUser->id);
            
            Auth::loginUsingId($createUser->id);
            AdminNotification::isProfileMatchSocial($createUser->name, $createUser->last_name, $createUser->email);
            toastr()->success('Login successful!'); 
            Cookie::queue(Cookie::forget('referal_uid'));
            Cookie::queue(Cookie::forget('invitation_id'));
            Session::forget('socialMatchUserDAta');

            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('/reviews');
            }
          }
        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }
}   
