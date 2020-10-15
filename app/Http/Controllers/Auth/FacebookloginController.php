<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class FacebookloginController extends Controller {

  public function redirectToFacebook() {
    return Socialite::driver('facebook')->redirect();
  }

  public function handleFacebookCallback() {
    try {
      $userSocial = Socialite::driver('facebook')->user();

      $finduser = User::where('email', $userSocial->email)->first();
      if($finduser) {
          if(!$finduser->facebook_id){
              $finduser->facebook_id = $userSocial->id;
              $finduser->save();
          }

          if($finduser->banned == 'yes'){
              $banned_from = $finduser->banned_from;
              $banned_to = $finduser->banned_to;
              if(Carbon::now()->between($banned_from, $banned_to)){
                toastr()->error('Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'); 
                return redirect('/home');
              }
          }

          if($finduser->deleted == 'yes'){
            toastr()->error('Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'); 
            return redirect('/home');
          }
                
          Auth::login($finduser);

          $forLastLoginData = User::find(Auth::user()->id);
          $forLastLoginData->last_login_at = Carbon::now();
          $forLastLoginData->login_count = $forLastLoginData->login_count + 1;
          $forLastLoginData->save();

          toastr()->success('Login successful!'); 
          if(Cookie::get('loginPreviusUrl')){
            $path = Cookie::get('loginPreviusUrl');
            Cookie::queue(Cookie::forget('loginPreviusUrl'));
            return redirect()->away($path);
          } else {
            return redirect('/reviews');
          }
      } else {
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

        $users = User::where('name', 'like', '%' . $firstName . '%')
                    ->where('last_name', 'like', '%' . $lastName . '%')
                    ->whereIn('type', ['Imported','CreatedByUser','ProfileCreatedByAdmin'])
                    ->get();
        if($users->isEmpty()){
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
            Auth::loginUsingId($createUser->id);
            Registermailchamp::register($createUser->id);
            AdminNotification::isUserMatch($createUser->name, $createUser->last_name, $createUser->email);
            
            toastr()->success('Login successful!'); 
            Cookie::queue(Cookie::forget('referal_uid'));
            Cookie::queue(Cookie::forget('invitation_id'));
            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('/reviews');
            }
          } else {
            Session::put('socialMatchUserDAta', $userSocial);
            return redirect('/home')->with(["isSocialMatch" => 1,"users" => $users, "login_from" => 'facebook']); 
          }
      }
    }
    catch (Exception $e) { 
      return redirect('/');
    }
  }
}
?>