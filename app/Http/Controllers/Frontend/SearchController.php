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
use Cookie;
use Session;
use Mail;
use App\Invitations;
use App\Setting;
use App\AddedProfiles;
use App\AdminNotification;
use App\AdminNotificationModel;
class SearchController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}


    public function search_results(Request $request) {
    if(isset($request->type) && !empty($request->type)) {
       $type = $request->type;
    } else {
      $type = '';
    }
    if(isset($request->sort) && !empty($request->sort)) {
      $sort = $request->sort;
    } else {
      $sort = 'name';
    }
    $regex = explode(" ", $request->name, 2);
    
    if($sort == 'name' && $type == ''){
      // $regex = implode("|", $regex); 
      // print_r($regex);die;
      $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->where('company.status',0)
                    ->where('users.name',"like", $regex[0].'%');
                    // ->orWhere('users.last_name',"like", $regex[0].'%');
      if(count($regex)>1)            
      $managers = $managers->where('users.last_name',"like", $regex[1].'%');
       else 
       $managers = $managers->orWhere('users.last_name',"like", $regex[0].'%');

      $managers = $managers->where('users.role',3)
                    ->where('users.status',0)
                    ->where('company.status',0)
                    ->orderBy('users.name', 'ASC')
                    ->paginate(10, ['*'], 'm_page');
      if(!count($managers)){
        $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->where('company.status',0)
                    ->where('users.name',"like", $regex[0].'%');
        if(count($regex)>1)            
        $managers = $managers->where('users.last_name',"like", $regex[1].'%');
        else
        $managers = $managers->orWhere('users.last_name',"like", $regex[0].'%');
        $managers = $managers->where('users.role',3)
                    ->where('users.status',0)
                    ->where('company.status',0)
                    ->orderBy('users.name', 'ASC')
                    ->paginate(10, ['*'], 'm_page');
      }
      
      $companys = Company::where('company_name','like','%'.$request->name.'%')
                    ->where('company.status',0)
                    ->orderBy('company_name', 'ASC')
                    ->paginate(10, ['*'], 'c_page');
    }
    if($sort == 'name' && $type != ''){
      //$bindArr = explode(" ", $request->name);
      //$regex = ".*(".implode("|", $bindArr).").*"; 
      $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->where('company.company_type',$type)
                    ->where('company.status',0)
                    ->where('users.name',"like", $regex[0].'%');
      if(count($regex)>1)            
      $managers = $managers->where('users.last_name',"like", $regex[1].'%');
      else
      $managers = $managers->where('users.last_name',"like", $regex[0].'%');
      $managers = $managers->where('users.role',3)
                    ->where('users.status',0)
                    ->where('company.status',0)
                    ->orderBy('users.name', 'ASC')
                    ->paginate(10, ['*'], 'm_page');
      
      $companys = Company::where('company_name','like','%'.$request->name.'%')
                    ->where('company_type',$type)
                    ->where('company.status',0)
                    ->orderBy('company_name', 'ASC')
                    ->paginate(10, ['*'], 'c_page');

    }
    if($sort == 'rate_desc' && $type == ''){
      //$bindArr = explode(" ", $request->name);
      //$regex = ".*(".implode("|", $bindArr).").*"; 
      $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->leftJoin('reviews','reviews.user_id','=','users.id')
                    //->where('company.company_type',$type)
                    ->where('company.status',0)
                    ->where('users.status',0)
                    ->where('users.name',"like", $regex[0].'%');
                    if(count($regex)>1)
                     $managers = $managers->where('users.last_name',"like", $regex[1].'%');
                   else
                     $managers = $managers->orWhere('users.last_name',"like", $regex[0].'%');


    $managers = $managers->orderBy('reviews.avg_review', 'DESC')
                    ->distinct()
                    ->paginate(10, ['*'], 'm_page');
      
      $companys = Company::select('company.*')
                    ->join('reviews','reviews.company_id','=','company.id')
                    ->where('company_name','like','%'.$request->name.'%')
                    ->where('company.status',0)
                    ->orderBy('reviews.avg_review', 'DESC')
                    ->distinct()
                    ->paginate(10, ['*'], 'c_page');

    }
    if($sort == 'rate_desc' && $type != ''){
      //$bindArr = explode(" ", $request->name);
//$regex = ".*(".implode("|", $bindArr).").*"; 
      $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->leftJoin('reviews','reviews.user_id','=','users.id')
                    ->where('company.company_type',$type)
                    ->where('users.status',0)
                    ->where('company.status',0)
                    ->where('users.name',"like", $regex[0].'%');
                    if(count($regex)>1)
        $managers = $managers->where('users.last_name',"like", $regex[1].'%');
                else
         $managers = $managers->orWhere('users.last_name',"like", $regex[0].'%');
        $managers = $managers->orderBy('reviews.avg_review', 'DESC')
                    ->distinct()
                    ->paginate(10, ['*'], 'm_page');
      
      $companys = Company::select('company.*')
                    ->join('reviews','reviews.company_id','=','company.id')
                    ->where('company.company_name','like','%'.$request->name.'%')
                    ->where('company.company_type',$type)
                    ->where('company.status',0)
                    ->orderBy('reviews.avg_review', 'DESC')
                    ->distinct()
                    ->paginate(10, ['*'], 'c_page');

    }
    if($sort == 'rate_asc' && $type == ''){
      //$bindArr = explode(" ", $request->name);
      //$regex = ".*(".implode("|", $bindArr).").*"; 
      $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->leftJoin('reviews','reviews.user_id','=','users.id')
                    ->where('company.status',0)
                    ->where('users.name',"like", $regex[0].'%');
                    if(count($regex)>1)
      $managers = $managers->where('users.last_name',"like", $regex[1].'%');
    else
                     $managers = $managers->orWhere('users.last_name',"like", $regex[0].'%');
      $managers = $managers->where('users.status',0)
                    ->where('company.status',0)
                    ->orderBy('reviews.avg_review', 'ASC')
                    ->distinct()
                    ->paginate(10, ['*'], 'm_page');
      
      $companys = Company::select('company.*')
                    ->join('reviews','reviews.company_id','=','company.id')
                    ->where('company_name','like','%'.$request->name.'%')
                    ->where('company.status',0)
                    ->orderBy('reviews.avg_review', 'ASC')
                    ->distinct()
                    ->paginate(10, ['*'], 'c_page');

    }
    if($sort == 'rate_asc' && $type != ''){
      //$regex = explode(" ", $request->name,2);
      //$regex = ".*(".implode("|", $bindArr).").*"; 
      $managers = User::select('users.*','company.company_name as company_name')
                    ->join('company','company.id','=','users.company_id')
                    ->join('departments','departments.id','=','users.department_id')
                    //->join('company_types','company_types.id','=','company.company_type')
                    ->leftJoin('reviews','reviews.user_id','=','users.id')
                    ->where('company.company_type',$type)
                    ->where('company.status',0)
                    ->where('users.name',"like", $regex[0].'%');
               if(count($regex)>1)
      $managers = $managers->where('users.last_name',"like", $regex[1].'%');
    else
       $managers = $managers->orWhere('users.last_name',"like", $regex[0].'%');
      $managers = $managers->where('users.status',0)
                    ->where('company.status',0)
                    ->orderBy('reviews.avg_review', 'ASC')
                    ->distinct()
                    ->paginate(10, ['*'], 'm_page');
      
      $companys = Company::select('company.*')
                    ->join('reviews','reviews.company_id','=','company.id')
                    ->where('company_name','like','%'.$request->name.'%')
                    ->where('company_type',$type)
                    ->where('company.status',0)
                    ->orderBy('reviews.avg_review', 'ASC')
                    ->distinct()
                    ->paginate(10, ['*'], 'c_page');

    }
    if($managers->count() == 0 && $companys->count() > 0){
      $companyIds = [];
      foreach ($companys as $key => $company) {
         $companyIds[] = $company->id;
      }
      $managers = User::select('users.*','company.company_name as company_name')
          ->join('company','company.id','=','users.company_id')
          ->join('departments','departments.id','=','users.department_id')
          //->join('company_types','company_types.id','=','company.company_type')
          ->whereIn('users.company_id',$companyIds)
          ->where('users.status',0)
          ->where('company.status',0)
          ->orderBy('users.name', 'ASC')
          ->paginate(10, ['*'], 'm_page');
    }
    $mcount = $companys->count();
    $ccount = $managers->count();
    $companyTypes = company_types::orderBy('name','ASC')->get();
    $departments = Departments::where('status',0)->orderBy('name','ASC')->get();
    return view('users.serach_page',compact('companys','managers','ccount','mcount','companyTypes','type','sort','departments'));
  } 

  //   public function add_manager_from_search_page(Request $request){
  //     try {
  //       parse_str( $request->data, $postData);
  //       $compnay = Company::where('company_name',$postData['company_name'])->first();
  //       if($compnay){
  //         $companyId = $compnay->id;
  //       } else {
  //         $companyObject = new Company;
  //         $companyObject->company_name = $postData['company_name'];
  //         $companyObject->status = 0;
  //         $companyObject->save();
  //         $companyId = $companyObject->id;

  //         $email_data = array(
  //             'company_name' => $companyObject->company_name,
  //             'manager'     => $postData['first_name']." ".$postData['last_name'],
  //         );
  //         $admin_mail = array("vikrampurivision@gmail.com", "jyotivisionvivante@gmail.com", Setting::value('email'));
  //         $admin_name = 'Review System';
  //         $subjact = "New company registration alert: New company from ‘Add a new colleague’ form"; 
  //         try {
  //           Mail::send(['html' => 'email/add_company_new_colleague'],$email_data, function ($message) use ($email_data,$admin_mail,$subjact,$admin_name){
  //                       $message->from("preformly@gmail.com");
  //                       $message->to($admin_mail,'Review System')->subject($subjact);

  //               });
  //           } 
  //           catch(\Exception $ex)
  //           {
  //               // toastr()->warning('Mail Not Send !!!');
  //               // return back();    
  //           }
  //       }

  //       $email = time()."_".time()."@blossom.team";
  //       $data = new User;
  //       $data->name = $postData['first_name'];
  //       $data->last_name = $postData['last_name'];
  //       $data->email = $email;
  //       $data->job_title = $postData['job_title'];
  //       $data->company_id = $companyId;
  //       $data->department_id = $postData['department_id'];
  //       $data->linkedin_url = $postData['linkedin_url'];
  //       $data->password = Hash::make('123456789');
  //       $data->role = 3;
  //       $data->type = 'CreatedByUser';
  //       $ip_address = UserAgent::IPADDRESS();
  //       $data->ip_address = $ip_address;
  //       $data->location = UserAgent::LOCATION($ip_address);
  //       $data->device_type = UserAgent::DEVICETYPE();
  //       $data->created_by = Auth::user()->id;
  //       $data->save();
  //       if($request->add_another == true){
  //         return json_encode(['status' => true,'message'=>'New profile addition successful!','user_id' => $data->id,'add_another' => true]);
  //       }
  //       return json_encode(['status' => true,'message'=>'New profile addition successful!','user_id' => $data->id, 'add_another' => false]);
  //     } catch (Exception $e) {
  //       return json_encode(['status' => false,'message'=>'Something Went Wrong!']);
  //     }
  // }

  public function add_colleague_from_search_match(Request $request, $id){

    $postData = Session::get('searchAddColleagueMatchUserData');
    $compnay = Company::where('company_name',$postData['company_name'])->first();
    if($compnay){
      $companyId = $compnay->id;
    } else {
      $companyObject = new Company;
      $companyObject->company_name = $postData['company_name'];
      $companyObject->status = 0;
      $companyObject->save();
      $companyId = $companyObject->id;

      $AdminNotificationModel = new AdminNotificationModel;
      $AdminNotificationModel->type="newCompanyAdded";
      $AdminNotificationModel->status="open";
      $AdminNotificationModel->user_id = Auth::user()->id;
      $AdminNotificationModel->company_id =  $companyId;
      $AdminNotificationModel->save();

      AdminNotification::addCompany($companyObject->company_name, $postData['first_name']." ".$postData['last_name'], Auth::user()->email, 'Add a new colleague');
    }


    if($id == 0){
      $email = time()."_".time()."@blossom.team";
      $data = new User;
      $data->name = $postData['first_name'];
      $data->last_name = $postData['last_name'];
      $data->email = $email;
      $data->job_title = $postData['job_title'];
      $data->company_id = $companyId;
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

      $AddedProfiles = new AddedProfiles;
      $AddedProfiles->created_by = Auth::user()->id;
      $AddedProfiles->profile_id = $data->id;
      $AddedProfiles->match = 'yes';
      $AddedProfiles->save();

      AdminNotification::spamBehavior(Auth::user()->name, Auth::user()->last_name, Auth::user()->email, Auth::user()->id);
      //AdminNotification::isProfileMatch($data->name, $data->last_name, $data->email, Auth::user());
      AdminNotification::isUserMatchWithAddNewCollegue($data->name, $data->last_name, $data->email, $data->id);
      Session::forget('searchAddColleagueMatchUserData');
      return json_encode(['status' => true, 'id' => $data->id,'message' => "New profile addition successful!"]);
    } else {
      $user = User::find($id);
      if( $user->company_id == $companyId ){
          $user->status = 0;
          $user->save();
      }
      Session::forget('searchAddColleagueMatchUserData');
      return json_encode(['status' => true, 'id' => $user->id,'message' => ""]);
    }
  }
  public function add_manager_from_search_page(Request $request){
      try {
        parse_str( $request->data, $postData);
        $users = User::where('name', 'like', '%' . $postData['first_name'] . '%')
                    ->where('last_name', 'like', '%' . $postData['last_name'] . '%')
                    ->where('id',  '!=', Auth::user()->id)
                    ->whereIn('type', ['Registerd','Imported','CreatedByUser','UserCreatedByAdmin','ProfileCreatedByAdmin','Invited','Referral'])
                    ->get();
        if($users->isEmpty()){  

          $compnay = Company::where('company_name',$postData['company_name'])->first();
          if($compnay){
            $companyId = $compnay->id;
          } else {
            $companyObject = new Company;
            $companyObject->company_name = $postData['company_name'];
            $companyObject->status = 0;
            $companyObject->save();
            $companyId = $companyObject->id;

            $AdminNotificationModel = new AdminNotificationModel;
            $AdminNotificationModel->type="newCompanyAdded";
            $AdminNotificationModel->status="open";
            $AdminNotificationModel->user_id = Auth::user()->id;
            $AdminNotificationModel->company_id =  $companyId;
            $AdminNotificationModel->save();

             AdminNotification::addCompany($companyObject->company_name, $postData['first_name']." ".$postData['last_name'], Auth::user()->email, "Add a new colleague");
            $email_data = array(
                'company_name' => $companyObject->company_name,
                'manager'     => $postData['first_name']." ".$postData['last_name'],
            );
            $admin_mail = array("vikrampurivision@gmail.com", "jyotivisionvivante@gmail.com", Setting::value('email'));
            $admin_name = 'Review System';
            $subjact = "New company registration alert: New company from ‘Add a new colleague’ form"; 
            try {
              Mail::send(['html' => 'email/add_company_new_colleague'],$email_data, function ($message) use ($email_data,$admin_mail,$subjact,$admin_name){
                  $message->from("preformly@gmail.com");
                  $message->to($admin_mail,'Review System')->subject($subjact);

                  });
            } catch(\Exception $ex){}
          }

          $email = time()."_".time()."@blossom.team";
          $data = new User;
          $data->name = $postData['first_name'];
          $data->last_name = $postData['last_name'];
          $data->email = $email;
          $data->job_title = $postData['job_title'];
          $data->company_id = $companyId;
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

          $AddedProfiles = new AddedProfiles;
          $AddedProfiles->created_by = Auth::user()->id;
          $AddedProfiles->profile_id = $data->id;
          $AddedProfiles->match = 'no';
          $AddedProfiles->save();
          AdminNotification::spamBehavior($data->name, $data->last_name, $data->email, $data->id);


          if($request->add_another == true){
            return json_encode([
              'status' => true,
              'message'=>'New profile addition successful!',
              'user_id' => $data->id,
              'add_another' => true,
              'match' => false
            ]);
          }
          return json_encode([
            'status' => true,
            'message'=>'New profile addition successful!',
            'user_id' => $data->id, 
            'add_another' => false,
            'match' => false
          ]);
        } else {
          Session::put('searchAddColleagueMatchUserData', $postData);
          if($request->add_another == 'true'){
            $add_another = true;
            return json_encode([
              'status' => true,
              'message'=>'profile matched!',
              'html' => view('users.add_colleague_existing_user_match',compact('users','add_another'))->render(),
              'add_another' => true,
              'match' => true
            ]);
          } 
          $add_another = false;
          return json_encode([
            'status' => true,
            'message'=>'profile matched!',
            'html' => view('users.add_colleague_existing_user_match',compact('users','add_another'))->render(),
            'add_another' => false,
            'match' => true
          ]);
        }

        
      } catch (Exception $e) {
        return json_encode(['status' => false,'message'=>'Something Went Wrong!']);
      }
  }

}
