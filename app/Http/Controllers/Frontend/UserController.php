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
use App\UserAgent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use File;
use Redirect;
use URL;
use Mail;
use App\Setting;
use Cookie;
use App\Invitations;
use App\AdminNotification;
use App\AdminNotificationModel;
use App\UsersLog;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function login_view() {
        if(Auth::check()) return redirect('/reviews');
        Cookie::queue('loginPreviusUrl', URL::previous(), 30); 
        return view('frontend.login.index');
    }
    public function sign_up() {
        if(Auth::check()) return redirect('/reviews');
        Cookie::queue('loginPreviusUrl', URL::previous(), 30);
        return redirect('/');
    }

    public function login_user(Request $request) {
        $postData = $request->all();
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 3])){

            if(Auth::user()->banned == 'yes'){
                $banned_from =Auth::user()->banned_from;
                $banned_to = Auth::user()->banned_to;
                if(Carbon::now()->between($banned_from, $banned_to)){
                  Auth::logout();
                  toastr()->error('Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'); 
                  return back();
                }
            }
            if( Auth::user()->deleted == 'yes'){
              Auth::logout();
              toastr()->error('Your account has been temporarily suspended due to reports of violated community guidelines. If you think you’re receiving this message in error, please email support@blossom.team'); 
              return back();
            }

            $user = User::find(Auth::user()->id);
            $user->last_login_at = Carbon::now();
            $user->login_count = $user->login_count + 1;
            $user->save();
            toastr()->success('Login successful!'); 
            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('/reviews');
            }
            
        } else{
            toastr()->error("Invalid login."); 
            return back()->withInput()->with('flash_message_error',"Credentials doesn't match try again!!");
        }
    }

    public function logout_user(){
        if (Auth::check()) {
            Auth::logout();
            toastr()->success('logout successfully!');
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function signup_user(Request $request) {
            $postData = $request->all();
            $validatedData = $request->validate([
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
            ]);
            $data = new User;
            $data->name = $request->name;
            $data->last_name = $request->last_name;
            $data->status = 1;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->role = 3;
            if(Cookie::get('referal_uid')){
              $data->type = 'Referral';
              $data->referal_uid = Cookie::get('referal_uid');
            } else if(Cookie::get('invitation_id')){
              $data->type = 'Invited';
              $data->invitation_id = Cookie::get('invitation_id');
              $invitationData = Invitations::find($data->invitation_id);
              if($invitationData){
                if($invitationData->send_by){
                  $invityData = User::find($invitationData->send_by);
                  $data->company_id = $invityData->company_id;
                }
              }
            } else {
              $data->type = 'Registerd';
            }
            $ip_address = UserAgent::IPADDRESS();
            $data->ip_address = $ip_address;
            $data->location = UserAgent::LOCATION($ip_address);
            $data->device_type = UserAgent::DEVICETYPE();
            $data->last_login_at = Carbon::now();
            $data->login_count = 1;
            $data->save();
            Auth::loginUsingId($data->id);
            AdminNotification::isUserMatch($data->name, $data->last_name, $data->email);
            Registermailchamp::register($data->id);
            toastr()->success('User Created successfully!'); 
            Cookie::queue(Cookie::forget('referal_uid'));
            Cookie::queue(Cookie::forget('invitation_id'));
            if(Cookie::get('loginPreviusUrl')){
              $path = Cookie::get('loginPreviusUrl');
              Cookie::queue(Cookie::forget('loginPreviusUrl'));
              return redirect()->away($path);
            } else {
              return redirect('reviews');
            }
    }
  public function my_profile(Request $request)
  {
    if (Auth::check()){
        $departments = Departments::all();
        $companys = Company::all();
        $companyName = null;
        if(Auth::user()->company_id){
          $company = Company::find( Auth::user()->company_id );
          $companyName = $company->company_name;
        }
        
        return view('users.my_profile',compact('departments','companys','companyName'));

    } else {
      toastr()->error('Please login first.');
      return redirect('/login-user');
    }
  }
  public function update_password(Request $request){
    $validatedData = $request->validate([
        //'old_password' => 'required',
        'password' => 'required',
        'cpassword' => 'required|same:password',
    ]);
    $user = User::find(Auth::user()->id);
    //
    if($user->password) {
      if(Hash::check($request->old_password, $user->password)) {
        $user->password = Hash::make($request->password);
        $user->save();
        toastr()->success('Password Updated Successfully.');
        return back();
      } else {
        toastr()->error('Old password doest Match!!');
        return back();
      }
    } else {
      $user->password = Hash::make($request->password);
      $user->save();
      toastr()->success('Password Updated Successfully.');
      return back();
    }
    
  }
  public function update_profile(Request $request)
  {
      if($request->isMethod('post'))
      {
      $postData = $request->all();
      $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
            'department_id' => 'required',
            'job_title' => 'required',
            //'phone' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id,
        ]);

      if(Auth::user()->company_id){
        $compnay = Company::where('company_name',$request->company_id)->first();
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
          $UsersLog->to = $request->company_id; ///its a name here
          $UsersLog->user_id = Auth::user()->id;
          $UsersLog->save();
          AdminNotification::userChangeCompany(Auth::user()->id, $UsersLog->from, $UsersLog->to);
        }
      }

      $compnay = Company::where('company_name',$request->company_id)->first();
      if($compnay){
        $data = User::find(Auth::user()->id);
        $data->company_id = $compnay->id;
        $data->save();

      } else {
        $company = new Company;
        $company->company_name = $request->company_id;
        $company->save();
        $data = User::find(Auth::user()->id);
        $data->company_id = $company->id;
        $data->save();

        $AdminNotificationModel = new AdminNotificationModel;
        $AdminNotificationModel->type="newCompanyAdded";
        $AdminNotificationModel->status="open";
        $AdminNotificationModel->user_id = Auth::user()->id;
        $AdminNotificationModel->company_id = $company->id;
        $AdminNotificationModel->save();
        
        AdminNotification::addCompany($company->company_name, $request->first_name." ".$request->last_name, $request->email, "Profile Page");
      }
      $user = User::find(Auth::user()->id);
       $user->name = $request->first_name;
       $user->last_name = $request->last_name;
       $user->phone = $request->phone;
       $user->job_title = $request->job_title;
       $user->linkedin_url = $request->linkedin_url;
       //$user->company_id = $request->company_id;
       $user->department_id = $request->department_id;
       $user->email = $request->email;

           if($request->hasFile('profile'))
           {
              $validate_profile = $request->validate([
                'profile' => 'required|mimes:jpg,jpeg,png,svg,giff,tiff',
              ]);
               if(!empty($user->profile))
              {
                try
                {
                  if(file_exists(public_path().'/images/users/'.$user->profile))
                  {
                     unlink(public_path().'/images/users/'.$user->profile);
                  }
                }
                catch(\Exceptions $e)
                {
                   //error
                }  
              }    
                
                    $files = $request->file('profile');
                    $file_name = uniqid().'.'.$files->getClientOriginalExtension();
                    $destinationPath = public_path()."/images/users";
                    $files->move($destinationPath,$file_name);
                    $target_file = $file_name;
                    $user->profile = $target_file;
           }
        $user->save();
        toastr()->success('Profile Updated Successfully');
        return back();
      }
  }

  public function my_reviews(Request $request)
  {

     $data = Reviews::where('customer_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
      return view('users.my_reviews',compact('data'));
  }

  public function change_password_view(Request $request) {
      return view('users.change_password');
  }

  public function show_review_model(Request $requestm,$id) {
    $review_data = Reviews::find($id);
    return view('users.user_review_model',compact('review_data'));
  }

  public function edit_review_model(Request $requestm,$id) {

    $review_data = Reviews::find($id);
    $manager = User::find($review_data->user_id);
    $questions = review_questions::where(['status'=>0, 'question_for'=> $review_data->working_as ])->get();
    $ReviewCategory = ReviewCategory::get();
    return view('users.edit_user_review_model',compact('review_data','questions','ReviewCategory','manager'));
  }

  public function company_list(Request $request)
  {
      $company_name = '';
       $data = User::select('users.*','countries.name as country_name','states.name as state_name','company_types.name as company_type_name')
       ->join('company','company.company_id','=','users.id')
       ->join('countries','countries.id','=','company.country_code')
       ->join('company_types','company_types.id','=','company.company_type')
       ->join('states','states.id','=','company.state_code')
       ->where('users.role',2)->where('users.status',0);
       if(isset($request->company_name) && !empty($request->company_name))
       {
          $company_name = $request->company_name;
          $data = $data->where('users.name','like','%'.$request->company_name.'%');
       }
        $data = $data->orderBy('users.id','DESC')->paginate(10);
       return view('frontend.company.company_list',compact('data','company_name'));
  }
  public function company_detail(Request $request,$id)
  {
      if($id)
      {
          $data = User::select('users.*','countries.name as country_name','states.name as state_name','company_types.name as company_type_name')
           ->join('company','company.company_id','=','users.id')
           ->join('countries','countries.id','=','company.country_code')
           ->join('company_types','company_types.id','=','company.company_type')
           ->join('states','states.id','=','company.state_code')
           ->where('users.role',2)->where('users.id',$id)->where('users.status',0)->first();
           $departments = Departments::where('company_id',$data['id'])->get();
          if(!empty($data))
          {
            return view('frontend.company.company_detail',compact('data','departments'));

          } 
           
      }
  }

  public function manager_list(Request $request)
  {
     $data = Managers::where('status',0);
       $name = '';
       if(isset($request->name) && !empty($request->name))
       {
           $name = $request->name;
          $data = $data->where('first_name','like','%'.$request->name.'%')->orWhere('last_name','like','%'.$request->name.'%');
       }
      $data = $data->orderBy('id','DESC')->paginate(6);
    return view('frontend.manager.managers_list',compact('data','name'));
  }


  public function manager_detail(Request $request,$id)
  {
      if($id)
      {
          $data = Managers::where('id',$id)->where('status',0)->first();
          $questions = review_questions::where('status',0)->get();
          if(!empty($data))
          {
             return view('frontend.manager.manager_detail',compact('data','questions'));
          }
      }
  }


  public function department_list(Request $request)
  {
      $data = Departments::where('status',0);
       $name = '';
      if(isset($request->name) && !empty($request->name))
      {
         $name = $request->name;
         $data = $data->where('name','like','%'.$request->name.'%');
      }
       $data = $data->where('status',0)->orderBy('id','DESC')->paginate(10);
       return view('frontend.department.department_list',compact('data','name'));

  }


  public function department_detail(Request $request,$id)
  {
        if($id)
        {
            $data = Departments::where('status',0)->where('status',0)->first();
            if(!empty($data))
            {
               return view('frontend.department.department_detail',compact('data'));
            }
        }
  }

   public function add_review(Request $request,$id, $manager_id = null) {

    $previousUrl = URL::previous();
    if(strpos($previousUrl, 'thank-you') !== false){
      $origination_source = "Thank You Page";
    } else if(strpos($previousUrl, 'manager-list') !== false){
      $origination_source = "Department Page";
    } else if(strpos($previousUrl, 'manager-detail') !== false){
      $origination_source = "Manager Page";
    } else {
      $origination_source = "Company Page";
    }

    $manager = null;
    $alreadyReview = null;
    if(Auth::check()) {
      if(Auth::user()->id != $manager_id) {
        if($manager_id){
          $manager = User::find($manager_id);
          $today = Carbon::now()->format('Y-m-d').'%';
          $reviewaData = Reviews::where(['user_id' => $manager_id , 'customer_id' => Auth::user()->id ] )->where('created_at', 'like', $today)->first();
          if($reviewaData){
            $alreadyReview = 1;
          }
        }
        $company = Company::where('company.id',$id)->first();
           $departments = Departments::where('status',0)->orderBy('name','ASC')->get();
           $questions = review_questions::where(['status'=>0, 'question_for'=>'Manager'])->get();
           $ReviewCategory = ReviewCategory::get();
          if(!empty($company))
          {
            $initiateTime = Carbon::now();
            return view('frontend.review.submit_review',compact('manager','company','departments','ReviewCategory','questions','company_type','alreadyReview','initiateTime', 'origination_source')); 
          }
      } else   {
        toastr()->warning('You cannot rate yourself!');
        return back();
      }
    } else   {
        toastr()->error('Please login first.');
        return redirect('/login-user');
    }
  }
  public function edit_review(Request $request, $id){
    $insert_data = Reviews::find($id);
    $data = [];
    $avgArray = [];
    foreach ($request->question as $key => $dataValue){
      $sum = 0;
      foreach ($dataValue as $key => $value) {
        $data[$key] = $value;
        $sum = $sum + $value;
      }
      $avgArray[] = $sum / count($dataValue);
    }

    $sum_point = array_sum($avgArray) / count($avgArray);
    if($sum_point <= 1.5 ){
      $insert_data->hold = 1;
    } else {
      $insert_data->hold = 0;
    }
    $insert_data->avg_review = $sum_point;
    $insert_data->comment = $request->comment;
    $insert_data->review_value = json_encode($data);
    $insert_data->save();
    toastr()->success('Review updated successfully.');
    return back();
  }


  /* ===================================================================== */
  public function submit_review(Request $request){
    $alreadyReview = null;
    $reviewLast14Days = null;
    $manager_id = $request->manager_id; 
    $company_id = $request->company_id; 
    if($manager_id){
      $manager = User::find($manager_id);
      $today = Carbon::now()->format('Y-m-d').'%';
      $todayDate = Carbon::now();
      $data14DayBack =  Carbon::now()->subDays(14);
      $reviewaData = Reviews::where(['user_id' => $manager_id , 'customer_id' => Auth::user()->id ] )->where('created_at', 'like', $today)->first();
      $reviewaData14days = Reviews::where(['user_id' => $manager_id , 'customer_id' => Auth::user()->id ] )->whereBetween('created_at', [(string)$data14DayBack->startOfDay(), (string)$todayDate->endOfDay()])->count();
      if($reviewaData){
        $alreadyReview = 1;
      }
      if($reviewaData14days >= 2 ){
        $reviewLast14Days = 1;
      }
    }
    if($alreadyReview){
      toastr()->error('You already review this user today!');
      return back();
    }
    $data = [];
    $avgArray = [];
    foreach ($request->question as $key => $dataValue){
      $sum = 0;
      foreach ($dataValue as $key => $value) {
        $data[$key] = $value;
        $sum = $sum + $value;
      }
      $avgArray[] = $sum / count($dataValue);
    }
    $sum_point = array_sum($avgArray) / count($avgArray);
    $insert_data = new Reviews;
    $insert_data->user_id = $request->manager_id;
    $insert_data->department_id = $request->department_id;
    $insert_data->currently_working_in_company = $request->currently_working_in_company;
    $insert_data->working_as = $request->working_as;
    $insert_data->recommend_working_with = $request->recommend_working_with;
    $insert_data->comment = $request->comment;
    $insert_data->currently_working_with = $request->currently_working_with;
    $insert_data->company_id = $request->company_id;
    $insert_data->customer_id = Auth::user()->id;
    $insert_data->user_role = 3;
    if($sum_point <= 1.5 ){
      $insert_data->hold = 1;
    }
    $insert_data->avg_review = $sum_point;
    $insert_data->initiate_time = $request->initiate_time;
    $insert_data->origination_source = $request->origination_source;
    $insert_data->review_value = json_encode($data);
    $company_data = Company::where('id', $request->company_id)->first();  
    $insert_data->ind_type = $company_data->company_type;
    $insert_data->save();

    if($sum_point <= 1.5 ){
      $AdminNotificationModel = new AdminNotificationModel;
      $AdminNotificationModel->type="lowScore";
      $AdminNotificationModel->status="open";
      $AdminNotificationModel->review_id = $insert_data->id;
      $AdminNotificationModel->save();

      $Reviews = Reviews::find($insert_data->id);
      $sc = number_format((float)$sum_point, 1, '.', '');
      AdminNotification::lowScoreNotification((string)$Reviews->customerName(), (string)$Reviews->userName(), (string)$sc, (string)$Reviews->user_id);   
    }

    toastr()->success('Review submitted successfully.');

    //update user Company and department
    if($request->currently_working_with){

      $user = User::find(Auth::user()->id);
      if(Auth::user()->company_id && Auth::user()->department_id){
        if(Auth::user()->company_id == $request->company_id){

        } else {
          $lastCompany = Auth::user()->companyName(Auth::user()->company_id);

          $user->company_id = $request->company_id;
          $user->department_id = $request->department_id;
          $user->save();
          
          $currentCompany = Auth::user()->companyName($request->company_id);


          $UsersLog = new UsersLog;
          $UsersLog->action_type = 'changeCompany';
          $UsersLog->from = $lastCompany;
          $UsersLog->to = $currentCompany;
          $UsersLog->user_id = Auth::user()->id;
          $UsersLog->save();
          AdminNotification::userChangeCompany(Auth::user()->id, $lastCompany, $currentCompany);
        }
      } else {
        if(Auth::user()->company_id && Auth::user()->company_id != $request->company_id){
          $lastCompany = Auth::user()->companyName(Auth::user()->company_id);
          $currentCompany = Auth::user()->companyName($request->company_id);

          $UsersLog = new UsersLog;
          $UsersLog->action_type = 'changeCompany';
          $UsersLog->from = $lastCompany;
          $UsersLog->to = $currentCompany;
          $UsersLog->user_id = Auth::user()->id;
          $UsersLog->save();
          AdminNotification::userChangeCompany(Auth::user()->id, $lastCompany, $currentCompany);
        }

        $user->company_id = $request->company_id;
        $user->department_id = $request->department_id;
        $user->save();
      }

    }
    if($reviewLast14Days == 1){
      $by = Auth::user()->fullName();
      $manager = User::find($request->manager_id);
      $managerFillName = $manager->fullName();
      AdminNotification::reviewsByRevieweeLimit($by, $managerFillName,Auth::user()->email,$manager->email);
      $AdminNotificationModel = AdminNotificationModel::where(['review_by' => Auth::user()->id,'review_to' => $request->manager_id,'type' => 'reviewsByRevieweeLimit'])->first();
        if($AdminNotificationModel){
          $AdminNotificationModel = AdminNotificationModel::find($AdminNotificationModel->id);
          $AdminNotificationModel->number_of_reviews = $AdminNotificationModel->number_of_reviews + 1;
          $AdminNotificationModel->status="open";
          $AdminNotificationModel->updateTimestamps();
          $AdminNotificationModel->save();
        } else {
        $AdminNotificationModel = new AdminNotificationModel;
        $AdminNotificationModel->type="reviewsByRevieweeLimit";
        $AdminNotificationModel->status="open";
        $AdminNotificationModel->review_by = Auth::user()->id;
        $AdminNotificationModel->review_to =  $request->manager_id;
        $AdminNotificationModel->number_of_reviews=$reviewaData14days + 1;
        $AdminNotificationModel->save();
      }
    }


    return Redirect::to('thank-you/' . $company_id . '/' . $manager_id);
  }


  public function review_manager_list(Request $request,$id, $company_id)
  {
      $todayReviwedUser = [];
      $data = User::where(['department_id'=>$id,'company_id'=>$company_id])->where('id', '!=', Auth::user()->id)->get();
      $today = Carbon::now()->format('Y-m-d').'%';
      $reviewaData = Reviews::select('user_id')->where(['customer_id' => Auth::user()->id ] )->where('created_at', 'like', $today)->get();
      if( $reviewaData ){
        foreach ($reviewaData as $key => $value) {
          $todayReviwedUser[] = $value->user_id;
        }
      }
      $dep = Departments::find($id);
      $data->department_name = $dep->name;
      $view = view('frontend.review.manger_list',compact('data', 'todayReviwedUser'))->render();
      return $view;
  }
  public function review_question_list(Request $request)
  {
    $for = $request->working_as;
    $alreadyReview = 0;
    $departments = Departments::where('status',0)->get();
    $questions = review_questions::where(['status'=>0, 'question_for'=>$for])->get();
    $ReviewCategory = ReviewCategory::get();
    $managerName = $request->manager_name;
   
    $view = view('frontend.review.question_list',compact('alreadyReview', 'departments','questions','ReviewCategory','managerName', 'for'))->render();
      return $view;
  }

  public function review_get_user_detail(Request $request) {
    $manager = User::find($request->manager_id);
    $view = view('frontend.review.manager_detail',compact('manager'))->render();
    return json_encode(['status' => true,'html'=>$view]);
  }

  public function loadCompanies(Request $request)
  {
    if($request->ajax())
    {
        $limit = 3;
        $offset = $request->input('offset');
        $url = url('/');
        
        $name = '';
       
        $companys = User::select('users.*','company_types.name as company_type_name')
                          ->join('company','company.company_id','=','users.id')
                          ->join('company_types','company_types.id','=','company.company_type')
                          ->where('users.name','like','%'.$name.'%')
                          ->where('users.role',2)
                          ->where('users.status',0)
                          ->offset($offset)
                          ->limit($limit)
                          ->get();

      $count = $companys->count();

        if($count > 0)
        {
          $output ='';
          foreach($companys as $key => $company)
          {
                  $fname = $company['name'];
                  $lname = $company['last_name'];
                  $image = $company['profile'];
                  $id = $company['id'];
                  $cTypeName = $company['company_type_name'];

                  $output .= '<div class="col-6 col-md-2"><div class="bg-white px-2 py-4"><img src="'.$url.'/images/company/'.$image.'" class="img-size" alt="google"><a href="'.$url.'/company-detail-user/'.$id.'"><h6 class="mb-0 pt-3">'.$fname.'</h6></a><h6 class="my-2 small text-muted">'.$cTypeName.'</h6><span class="text-dark"><i class="fas fa-thumbs-up thumb"></i>'.round($company->review($id),1).'</span></div></div>';
            
            $offset++;
          }

            return Response()->json(array(
              'status' => true,
              'message' => $output,
              'offset' => $offset,
            ));
        }
        else
        {
            return Response()->json(array(
                'status' => false,
            ));

        }
    }
  }



  public function loadManagers(Request $request)
  {
    if($request->ajax())
    {
        $limit = 3;
        $offset = $request->input('offset');
        $url = url('/');
        
        $name = '';

        $managers = Managers::where('first_name','like','%'.$request->name.'%')->orWhere('last_name','like','%'.$request->name.'%')->where('status',0)->offset($offset)->limit($limit)->get();

      $count = $managers->count();

        if($count > 0)
        {
          $output ='';
          foreach($managers as $key => $manager)
          {
            $fname = $manager['first_name'];
            $lname = $manager['last_name'];
            $image = $manager['profile'];

            $output .= '<div class="col-6 col-md-2 mt-5"><div class="bg-white card-two px-2 py-4"><div class="circle-img">
                            <img src="'.$url.'/images/manager/'.$image.'" class="img-fluid rounded-circle" alt="'.$fname." ".$lname.'"></div><a href="'.$url.'/manager-detail-user/'.$manager->id.'"><h6 class="py-3 text-center my-1">'.$fname.'<br>'.$lname.'</h6></a><img src="'.$url.'/images/company/'.$manager->companyImage($manager->company_id).'" class=" img-fluid human" alt="approach" style="height:70px"><h6 class="my-2 small text-muted">Rated by 400 people</h6><span class="thumb"><i class="fas fa-thumbs-up"></i></span> <span class="font-weight-bold">'.round($manager->manager_review($manager->id),1).'</span></div></div>';
            $offset++;
          }

            return Response()->json(array(
              'status' => true,
              'message' => $output,
              'offset' => $offset,
            ));
        }
        else
        {
            return Response()->json(array(
                'status' => false,
            ));

        }
    }
  }


  public function loadDepartments(Request $request)
  {
    if($request->ajax())
    {
        $limit = 3;
        $offset = $request->input('offset');
        $url = url('/');
        
        $name = '';
        
        $departments = Departments::where('name','like','%'.$request->name.'%')->where('status',0)->offset($offset)->limit($limit)->get();

      $count = $departments->count();

        if($count > 0)
        {
          $output ='';
          foreach($departments as $key => $department)
          {
                 
            $output .= '<div class="col-6 col-md-2" style="margin-top: 9px;"><div class="bg-white card-two px-2 py-4"><div class="h5-height"><a href="'.$url.'/department-detail-user/'.$department->id.'"><h5>'.$department->name.'</h5></a></div><h6 class="my-2 small text-muted">Rated by 400 people</h6><span class="thumb"><i class="fas fa-thumbs-up"></i></span> <span class="font-weight-bold"> 5.0</span></div></div>';
            
            $offset++;
          }

            return Response()->json(array(
              'status' => true,
              'message' => $output,
              'offset' => $offset,
            ));
        }
        else
        {
            return Response()->json(array(
                'status' => false,
            ));

        }
    }
  }



  public function manager_review_view(Request $request,$id) {
    if(Auth::check()) {  
      $data = User::where('id',$id)->where('status',0)->first();
      $questions = review_questions::where('status',0)->get();
      $check = Reviews::where('user_id',$id)->where('customer_id',Auth::user()->id)->first();
      if(!empty($check)) {
        $check = 1;
      } else{
        $check = 0;
      }
      return view('frontend.review.manager_review',compact('data','questions','check'));
    } else {
       toastr()->warning('Please Login or signup');
       return redirect('/home');
    }
  }


  public function submit_review_manager(Request $request,$id)
  {
      if($request->isMethod('post'))
      {
         $postData = $request->all();
          if($id == $request->manager_id)
          {
            $check = Reviews::where('user_id',$id)->where('customer_id',Auth::user()->id)->first();
            if(!empty($check))
            {
               toastr()->error('You already have been submitted review for this manager');
               return back();
            }
          $avg_points = array();
          $format = array();
          $questions = $postData['question_ids'];
          $total_question = count($questions);
          $mng_data = Managers::where('id',$postData['manager_id'])->first();
          $company_data = Company::where('company_id',$mng_data['company_id'])->first();
           try{
               foreach ($questions as $key => $question)
               {
                    if(isset($postData['rating'.$question]) && !empty($postData['rating'.$question]))
                    {
                       $reating_name = $postData['rating'.$question];
                    }
                    else
                    {
                       $reating_name = 0;
                    } 
                      if($reating_name > 5)
                      {
                         toastr()->warning('Something Went Wrong!!');
                         return back();
                      }
                        $format[$question] = $reating_name;
                        $avg_points[] = $reating_name; 
                        $question_rate = new question_rate;
                        $question_rate->user_id = $request->manager_id;
                        $question_rate->customer_id = Auth::user()->id;
                        $question_rate->rate = $reating_name;
                        $question_rate->question_id = $question;
                        $question_rate->save();
               }
              
                  $sum_point = array_sum($avg_points) / $total_question;
                  $decode_data_review = json_encode($format);
                  $insert_data = new Reviews;
                  $insert_data->user_id = $request->manager_id;
                  $insert_data->customer_id = Auth::user()->id;
                  $insert_data->user_role = 4;
                  $insert_data->avg_review = $sum_point;
                  $insert_data->review_value = $decode_data_review;
                   if(!empty($company_data))
                  {
                     $insert_data->ind_type = $company_data->company_type;

                  }
                  $insert_data->save();
                  toastr()->success('Review Successfully');
                  return back();
            }
            catch(\Exceptions $e)
            {   
               toastr()->error('Something went wrong!!');
               return back();
            }      
          }
      }
  }
  
  public function check_review_user(Request $request,$id) {
    if($id) {
      $check = Reviews::where('user_id',$id)->where('customer_id',Auth::user()->id)->first();
      if(!empty($check)) {
        return response()->json(['data'=>'','status'=>false]);
      }
      return response()->json(['data'=>'','status'=>true]);
    }
  }

  public function add_manager_for_review(Request $request){
      try {
        parse_str( $request->data, $postData);
        //$email = $postData['email'];
        //if(!$email){
          $email = time()."_".time()."@blossom.team";
        //}
            if(!User::where('email',$email)->first()){
            $data = new User;
            $data->name = $postData['first_name'];
            $data->last_name = $postData['last_name'];
            $data->email = $email;
            //$data->phone = $postData['phone'];
            $data->job_title = $postData['job_title'];
            $data->company_id = $postData['company_id'];
            $data->department_id = $postData['department_id'];
            $data->linkedin_url = $postData['linkedin_url'];
            $data->password = Hash::make('123456789');
            $data->role = 3;
            $data->type = 'CreatedByUser';
            $ip_address = UserAgent::IPADDRESS();
            $data->ip_address = $ip_address;
            $data->location = UserAgent::LOCATION($ip_address);
            $data->device_type = UserAgent::DEVICETYPE();
            $data->created_by = Auth::user()->id;
            $data->save();
            $title  = (strlen($data->job_title) > 30)? substr($data->job_title,0, 30)." ..." : $data->job_title;
            $html = view('frontend.review.add_manager_through_popup', compact('data'))->render();
            $manager = User::find($data->id);
            $manager_detail = view('frontend.review.manager_detail',compact('manager'))->render();
            return json_encode(['status' => true,'html'=>$html, 'manager_detail'=> $manager_detail,'manager_id'=>$data->id, 'manager_name' => $data->name." ".$data->last_name ]);
          } else {
            return json_encode(['status' => false,'html'=>'']);
          }
      } catch (Exception $e) {
        return "Email Id already Exist";
      }
  }
    public function add_manager_for_manager_list(Request $request){
      try {
        parse_str( $request->data, $postData);
        //$email = $postData['email'];
        //if(!$email){
          $email = time()."_".time()."@blossom.team";
        //}
          if(!User::where('email',$email)->first()){
          $data = new User;
          $data->name = $postData['first_name'];
          $data->last_name = $postData['last_name'];
          $data->email = $email;
          //$data->phone = $postData['phone'];
          $data->job_title = $postData['job_title'];
          $data->company_id = $postData['company_id'];
          $data->department_id = $postData['department_id'];
          $data->linkedin_url = $postData['linkedin_url'];
          $data->password = Hash::make('123456789');
          $data->role = 3;
          $data->type = 'CreatedByUser';
          $ip_address = UserAgent::IPADDRESS();
          $data->ip_address = $ip_address;
          $data->location = UserAgent::LOCATION($ip_address);
          $data->device_type = UserAgent::DEVICETYPE();
          $data->created_by = Auth::user()->id;
          $data->save();
          $title  = (strlen($data->job_title) > 30)? substr($data->job_title,0, 30)." ..." : $data->job_title;
          $html = view('frontend.manager.add_manager_through_popup', compact('data'))->render();
            return json_encode(['status' => true,'html'=>$html]);
          } else {
            return json_encode(['status' => false,'html'=>'']);
          }
      } catch (Exception $e) {
        return "Email Id already Exist";
      }
  }

  public function add_department_for_review(Request $request){
      parse_str( $request->data, $postData);
      $data = new Departments;
      $data->name = $postData['name'];
      $data->description = $postData['description'];
      $data->status = 1;
      $data->save();
      $html = '<li><a class="choose_dep active" data-id="'.$data->id.'">'.$data->name.' <sup><i class="department-detail fas fa-info-circle text-muted" data-id="#model_id_'.$data->id.'"></i></sup></a></li>';
      $option = '<option value="'.$data->id.'">'.$data->name.'</option>';
      AdminNotification::isDepartmentCreated(Auth::user()->name." ".Auth::user()->last_name, Auth::user()->email,$request->company_id, $data->name);
      $departments = Departments::where('id',$data->id)->get();
      $popup_models = view('frontend.review.department_detail_popup', compact('departments'))->render();
      return json_encode(['status' => true,'html'=>$html,'option' => $option, 'popup_models' => $popup_models, 'id' => $data->id]);
  }

  public function thank_you_view(Request $request, $company_id, $manager_id){
    if(Auth::check() && $company_id && $manager_id){
      $companyUser = $users = null;
      $reviewee = User::find($manager_id);
      $usersIds = User::where(['company_id' => $reviewee->company_id, 'department_id' => $reviewee->department_id])->where([['id','!=',$manager_id],['id','!=', Auth::user()->id]])->take(20)->pluck('id');
      if( !$usersIds || (count($usersIds) < 20) ){
        $count = 20-count($usersIds);
        $users = User::where(['company_id' => $reviewee->company_id, 'department_id' => $reviewee->department_id])->where([['id','!=',$manager_id],['id','!=', Auth::user()->id]])->take(20)->get();
        $companyUser = User::whereNotIn('id',$usersIds)->where(['company_id' => $reviewee->company_id])->where([['department_id','!=',null], ['id','!=',$manager_id],['id','!=', Auth::user()->id]])->take($count)->get();
      } else {
        $users = User::where(['company_id' => $reviewee->company_id, 'department_id' => $reviewee->department_id])->where([['id','!=',$manager_id],['id','!=', Auth::user()->id]])->take(20)->get();
      }

      $currentUserId = Auth::user()->id;
      return view('frontend.thank_you.index', compact('users', 'reviewee','currentUserId','companyUser'));
    } else {
      return abort(404);
    }
  }

  public function loadTitles(Request $request){
    $html = '';
    $users = User::select('job_title')->groupBy('job_title')->orderByRaw("IF(job_title = '{$request->data}',2,IF(job_title LIKE '{$request->data}%',1,0)) DESC")->where('job_title','like',$request->data.'%')->get()->take(10);
    if($users){
      foreach ($users as $key => $user) {
       $html .="<option value='".$user->job_title."'>".$user->job_title."</option>";
      }
    }
    echo $html;die;
  }

  public function loadCompanyList(Request $request){ 
    $html = '';
    $Companys = Company::where('company_name','like',$request->data.'%')->where('status',0)->get()->take(10);
    if(count($Companys) > 0){
      foreach ($Companys as $key => $Company) {
        if(strtolower(trim($Company->company_name)) != strtolower($request->data)){
          $html .="<option value='".$Company->company_name."'>".$Company->company_name."</option>";
        }
      }
    } else {
      $Companys = Company::whereRaw('company_name REGEXP "'.$request->data.'"')->where('status',0)->orderBy('company_name', 'ASC')->get()->take(10);
      if(count($Companys) > 0){
        foreach ($Companys as $key => $Company) {
          if(strtolower(trim($Company->company_name)) != strtolower($request->data)){
            $html .="<option value='".$Company->company_name."'>".$Company->company_name."</option>";
          }
        }
      }
    }
    echo $html;die;
  }

  public function reviews(Request $request){
    if( Auth::check() ){
      $everyOneReviws = Reviews::select('reviews.*')
                        ->join('company','company.id','=','reviews.company_id')
                        ->where('company.status',0)
                        ->where('reviews.hidden_review',0)
                        ->where('reviews.fake','no')
                        ->orderBy('reviews.id','DESC')
                        ->paginate(10, ['*'], 'pu_page');
      $myOrganizationReviws = Reviews::select('reviews.*')
                        ->join('company','company.id','=','reviews.company_id')
                        ->where('company.status',0)
                        ->where('reviews.hidden_review',0)
                        ->where('reviews.fake','no')
                        ->where(['reviews.company_id' => Auth::user()->company_id])
                        ->orderBy('reviews.id','DESC')
                        ->paginate(10, ['*'], 'mo_page');
      $myReviws = Reviews::select('reviews.*')
                        ->join('company','company.id','=','reviews.company_id')
                        ->where('company.status',0)
                        ->where('reviews.hidden_review',0)
                        ->where('reviews.fake','no')
                        ->where('reviews.customer_id', Auth::user()->id )
                        ->orderBy('reviews.id','DESC')
                        ->paginate(10, ['*'], 'my_page');
      
      return view('frontend.homepage.after_login', compact('myReviws','myOrganizationReviws','everyOneReviws'));
    } else {
      toastr()->error("Please Login First!"); 
      return redirect('/login-user');
    }
  }
}
