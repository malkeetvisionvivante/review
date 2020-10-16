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
use Illuminate\Support\Facades\Hash;
use File;
use Carbon\Carbon;
use App\review_questions;
use App\ReviewCategory;
use App\UserAgent;
use App\Registermailchamp;
use App\AdminNotification;
use App\AdminNotificationModel;
use Mail;
use Cookie;
use Session;
use URL;
use App\Setting;
class ManagerController extends Controller {
  	public function __construct() {}

    public function redirect_google(Request $request) {
      Cookie::queue('loginPreviusUrl', URL::previous(), 30); 
      Session::put('socailSignUpAccountOrigin', 'Unlock feedback view');
      return redirect('/auth/google');
    }
    public function redirect_facebook(Request $request) {
      Cookie::queue('loginPreviusUrl', URL::previous(), 30); 
      Session::put('socailSignUpAccountOrigin', 'Unlock feedback view');
      return redirect('/auth/facebook');
    }
    public function redirect_linkedin(Request $request) {
      Cookie::queue('loginPreviusUrl', URL::previous(), 30); 
      Session::put('socailSignUpAccountOrigin', 'Unlock feedback view');
      return redirect('/auth/linkedin');
    }

    public function mission_end(Request $request) {
      $data = User::find(Auth::user()->id);
      $data->mission_popup = 'yes';
      $data->save();
      return response()->json(['status'=>true]);
    }
    public function mission_step(Request $request, $step) {
      $data = User::find(Auth::user()->id);
      $data->mission_popup_step = $step;
      $data->save();
      return response()->json(['status'=>true]);
    }
    public function mission_update_company(Request $request) {
      $compnay = Company::where('company_name',$request->data)->first();
      if(Auth::user()->company_id){
        $compnay = Company::where('company_name',$request->data)->first();
        if($compnay){
          if($compnay->id != Auth::user()->company_id){
            $UsersLog = new UsersLog;
            $UsersLog->action_type = 'changeCompany';
            $UsersLog->from = Auth::user()->companyName(Auth::user()->company_id);
            $UsersLog->to = $compnay->company_name;
            $UsersLog->user_id = Auth::user()->id;
            $UsersLog->save();
            AdminNotification::userChangeCompany(Auth::user()->id, $UsersLog->from, $UsersLog->to);
          }
        } else {
          $UsersLog = new UsersLog;
          $UsersLog->action_type = 'changeCompany';
          $UsersLog->from = Auth::user()->companyName(Auth::user()->company_id);
          $UsersLog->to = $request->data; ///its a name here
          $UsersLog->user_id = Auth::user()->id;
          $UsersLog->save();
          AdminNotification::userChangeCompany(Auth::user()->id, $UsersLog->from, $UsersLog->to);
        }
      }
      if($compnay){
        $data = User::find(Auth::user()->id);
        $data->company_id = $compnay->id;
        $data->save();
      } else {
        $company = new Company;
        $company->company_name = $request->data;
        $company->save();
        $data = User::find(Auth::user()->id);
        $data->company_id = $company->id;
        $data->save();

        $AdminNotificationModel = new AdminNotificationModel;
        $AdminNotificationModel->type="newCompanyAdded";
        $AdminNotificationModel->status="open";
        $AdminNotificationModel->user_id = Auth::user()->id;
        $AdminNotificationModel->company_id =  $data->company_id;
        $AdminNotificationModel->save();
        
        AdminNotification::addCompany($company->company_name, $data->fullName(), $data->email, "Onboard Tour");
      }
      return response()->json(['status'=>true]);
    }
  	public function manager_detail(Request $request,$id) {
      	$data = User::find($id);
        // if($data->companyIsdisable()){
        //   return abort(404);
        // }
      	$ReviewCategorys = ReviewCategory::get();
        $questions = review_questions::where('status', 0)->get();
        $reviews = Reviews::where('user_id', $id)->where('comment','!=', null)->where('hidden_review','!=', 1)->where('hold','!=', 1)->orderBy('id','DESC')->paginate(10);
        $number = Reviews::where('user_id', $id)->where('recommend_working_with', 1)->where('hidden_review','!=', 1)->count();
        $total = Reviews::where('user_id', $id)->where('recommend_working_with','!=', null)->where('hidden_review','!=', 1)->count();
        $percentage = 0;
        if($total > 0){
          $pr = ($number / ($total / 100));
          $percentage = $pr <100 ? number_format((float)$pr, 1, '.', '') : 100;
        } 
        
      	if(!empty($data)) {
          if ($request->ajax()) {
           return $res = [
              "view" => view('frontend.manager.managers_comments_ajax', compact('data', 'reviews'))->render(),
              'url' => $reviews->nextPageUrl()
            ];
          }
         	return view('frontend.manager.manager_detail',compact('data','ReviewCategorys','questions','reviews','percentage'));	
      	} else {
      		toastr()->error('Manager Not Found!!'); 
      		return abort(404);
    	}
  	}
    public function manager_graph(Request $request,$id) {
        $data = User::find($id);
        $ReviewCategorys = ReviewCategory::get();
        $questions = review_questions::where('status', 0)->get();
        if(!empty($data)) {
          return view('frontend.manager.manager_graph',compact('data','ReviewCategorys','questions')); 
        } else {
          toastr()->error('Manager Not Found!!'); 
          return abort(404);
      }
    }


    public function manager_list(Request $request, $companyId, $departmantId) {
      $data = User::where(['status' => 0,'company_id' => $companyId, 'department_id' => $departmantId]);
      $managers = $data->orderBy('id','DESC')->paginate(20);
      $company = Company::where('company.id',$companyId)->first();
      $department = Departments::find($departmantId); 
      return view('frontend.manager.managers_list',compact('managers', 'company', 'department'));
  }

  public function find_existing_users(Request $request){
    $postData = $request->all();
    $find = User::where('email', '=', $request->email)->first();
    if ($find === null) {
      $users = User::where('name', 'like', '%' . $request->name . '%')
                    ->where('last_name', 'like', '%' . $request->last_name . '%')
                    ->whereIn('type', ['Imported','CreatedByUser','ProfileCreatedByAdmin'])
                    ->get();
      if($users->isEmpty()){
        return response()->json(array('empty' => true));
      }
      $returnHTML = view('frontend.homepage.find_existing_users_list')->with(['users' => $users, 'postData' => $postData])->render();
      return response()->json(array('success' => true, 'html'=>$returnHTML));
    }else{
      return response()->json(array('error' => true));
    }
  }

  public function save_existing_users(Request $request){
      $postData = $request->all();
      if($request->selected == 0){
        $data = new User;
        $data->status = 1;
      }else{
        $data = User::find($request->selected);
        $data->claimed = 'yes';
      }
      
      //AdminNotification::isUserMatch($request->firstname, $request->last_name, $request->email);
      $data->name = $request->firstname;
      $data->last_name = $request->last_name;
      $data->email = $request->email;
      $data->password = Hash::make($request->password);
      $data->role = 3;
      $data->type = 'Registerd';
      $ip_address = UserAgent::IPADDRESS();
      $data->ip_address = $ip_address;
      $data->location = UserAgent::LOCATION($ip_address);
      $data->device_type = UserAgent::DEVICETYPE();
      $data->last_login_at = Carbon::now();
      $data->created_at = Carbon::now();
      $data->login_count = 1;
      $data->save();
      
      Registermailchamp::register($data->id);
      if(Auth::loginUsingId($data->id)){
        Cookie::queue(Cookie::forget('referal_uid'));
        Cookie::queue(Cookie::forget('invitation_id')); 
      }
      AdminNotification::isProfileMatch($request->firstname, $request->last_name, $request->email, Auth::user());
      if(Cookie::get('loginPreviusUrl')){
        $path = Cookie::get('loginPreviusUrl');
        Cookie::queue(Cookie::forget('loginPreviusUrl'));
        return response()->json(array('success' => true, 'url' => url($path)));
      } else {
        return response()->json(array('success' => true, 'url' => url('reviews')));
      }
  }

  public function signup_user_exist(Request $request){
    $user = User::where('email',$request->email)->first();
    if($user){
      return response()->json(array('status' => true));
    }
    return response()->json(array('status' => false));
  }

  public function login_user(Request $request){
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 3])){
        if(Auth::user()->banned == 'yes'){
            $banned_from =Auth::user()->banned_from;
            $banned_to = Auth::user()->banned_to;
            if(Carbon::now()->between($banned_from, $banned_to)){
              Auth::logout();
              return response()->json(array('status' => false,'message' => 'Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'));
            }
        }
        if(Auth::user()->deleted == 'yes'){
          Auth::logout();
          return response()->json(array('status' => false,'message' => 'Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'));
        }

        $user = User::find(Auth::user()->id);
        $user->last_login_at = Carbon::now();
        $user->login_count = $user->login_count + 1;
        $user->save();
        return response()->json(array('status' => true,'message' => 'Login successful!'));
    }
    return response()->json(array('status' => false,'message' => "Credentials doesn't match try again!!"));
  }

  public function signup_user(Request $request){
    $user = User::where('email',$request->email)->first();
    if(!$user){
      $users = User::where('name', 'like', '%' . $request->name . '%')
            ->where('last_name', 'like', '%' . $request->last_name . '%')
            ->whereIn('type', ['Imported','CreatedByUser','ProfileCreatedByAdmin'])
            ->get();
      if($users->isEmpty()){ 
        $createUser = new User;
        $createUser->name = $request->name;
        $createUser->last_name = $request->last_name;
        $createUser->email = $request->email;
        $createUser->status = 1;
        $createUser->password = Hash::make($request->password);
        if(Cookie::get('invitation_id')){
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
        $ip_address = UserAgent::IPADDRESS();
        $createUser->ip_address = $ip_address;
        $createUser->location = UserAgent::LOCATION($ip_address);
        $createUser->device_type = UserAgent::DEVICETYPE();
        $createUser->last_login_at = Carbon::now();
        $createUser->account_origin = 'Unlock feedback view';
        $createUser->login_count = 1;
        $createUser->save();
        Auth::loginUsingId($createUser->id);
        Cookie::queue(Cookie::forget('invitation_id'));
        AdminNotification::isUserMatch($createUser->name, $createUser->last_name, $createUser->email);
        return response()->json(array('status' => true,'message' => "Login successful!"));
      } else {
        Session::put('signUpMatchUserData', $request->all());
        $html = view('frontend.manager.signup_existing_user',compact('users'))->render();
        return response()->json(array('status' => false,'message' => "", 'html' => $html));
      }
    } else {
      return response()->json(array('status' => false,'message' => "Email already exist!"));
    }
  }

  public function signup_user_create(Request $request, $id){
    try {
      if($id == 0){
        $userData = Session::get('signUpMatchUserData');
        $user = new User;
        $user->name = $userData['name'];
        $user->last_name = $userData['last_name'];
        $user->email = $userData['email'];
        $user->status = 1;
        $user->password = Hash::make($userData['password']);
        if(Cookie::get('invitation_id')){
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
        $ip_address = UserAgent::IPADDRESS();
        $user->ip_address = $ip_address;
        $user->location = UserAgent::LOCATION($ip_address);
        $user->device_type = UserAgent::DEVICETYPE();
        $user->last_login_at = Carbon::now();
        $user->account_origin = 'Unlock feedback view';
        $user->login_count = 1;
        $user->save();
        Registermailchamp::register($user->id);
        Auth::loginUsingId($user->id);
        AdminNotification::isProfileMatch($user->name, $user->last_name, $user->email, $user);
        Cookie::queue(Cookie::forget('invitation_id'));
        Session::forget('signUpMatchUserData');

        toastr()->success('Login successful!'); 
        return back();
      } else {
        $userData = Session::get('signUpMatchUserData');
        
        $user = User::find($id);
        $user->name = $userData['name'];
        $user->last_name = $userData['last_name'];
        $user->email = $userData['email'];
        $user->password = Hash::make($userData['password']);

        $user->created_at = Carbon::now();
        $user->type = 'Registerd';
        $user->claimed = 'yes';

        $ip_address = UserAgent::IPADDRESS();
        $user->ip_address = $ip_address;
        $user->location = UserAgent::LOCATION($ip_address);
        $user->device_type = UserAgent::DEVICETYPE();
        $user->last_login_at = Carbon::now();
        $user->account_origin = 'Unlock feedback view';
        $user->login_count = 1;
        $user->save();
        Registermailchamp::register($user->id);
        Auth::loginUsingId($user->id);
        AdminNotification::isProfileMatch($user->name, $user->last_name, $user->email, $user);
        Cookie::queue(Cookie::forget('invitation_id'));
        Session::forget('signUpMatchUserData');

        toastr()->success('Login successful!'); 
        return back();
      }
    } catch (Exception $e) {
      return redirect('/');
    }
  }
}
