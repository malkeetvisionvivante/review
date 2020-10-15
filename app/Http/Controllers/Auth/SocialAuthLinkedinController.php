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
use Session;
use Cookie;
use App\UserAgent;
use Carbon\Carbon;
use App\Invitations;
use App\AdminNotification;

class SocialAuthLinkedinController extends Controller {

   public function redirect(){
        return Socialite::driver('linkedin')->redirect(); 
    }

    public function callback(){
        try {
            $linkdinUser = Socialite::driver('linkedin')->user();
            $existUser = User::where('email',$linkdinUser->email)->first();
            if($existUser) {
               if(!$existUser->linkedin_id){
                    $existUser->linkedin_id = $linkdinUser->id;
                    $existUser->save();
                }

                if($existUser->banned == 'yes'){
                    $banned_from = $existUser->banned_from;
                    $banned_to = $existUser->banned_to;
                    if(Carbon::now()->between($banned_from, $banned_to)){
                      toastr()->error('Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'); 
                      return redirect('/home');
                    }
                }

                if($existUser->deleted == 'yes'){
                  toastr()->error('Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'); 
                  return redirect('/home');
                }

                Auth::loginUsingId($existUser->id);

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
                $firstName = $linkdinUser->name;
                $lastName = null;
                $name = explode(' ', $linkdinUser->name);
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
                    Auth::loginUsingId($user->id);
                    Registermailchamp::register($user->id);
                    AdminNotification::isUserMatch($user->name, $user->last_name, $user->email);
                    //AdminNotification::isProfileMatch($user->name, $user->last_name, $user->email);
                    
                    Cookie::queue(Cookie::forget('referal_uid'));
                    Cookie::queue(Cookie::forget('invitation_id'));
                    toastr()->success('Login successful!'); 
                    if(Cookie::get('loginPreviusUrl')){
                        $path = Cookie::get('loginPreviusUrl');
                        Cookie::queue(Cookie::forget('loginPreviusUrl'));
                        return redirect()->away($path);
                    } else {
                        return redirect('/reviews');
                    }
                } else {
                    Session::put('socialMatchUserDAta', $linkdinUser);
                    return redirect('/home')->with(["isSocialMatch" => 1,"users" => $users, "login_from" => 'linkedin']);
                }
            } 
        } catch (Exception $e) {
            return redirect('/');
        }
    }
}
?>