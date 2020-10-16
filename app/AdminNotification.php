<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use App\User;
use Mail;
use App\Setting;
use App\Company;
use App\AddedProfiles;
use App\UsersLog;
use App\AdminNotificationModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminNotification extends Model {

  static function isProfileMatch($firstName, $lastName, $email, $user){
    $users = User::where('name', 'like', '%' . $firstName . '%')
                  ->where('last_name', 'like', '%' . $lastName . '%')
                  //->whereIn('type', ['Imported','CreatedByUser','ProfileCreatedByAdmin'])
                  ->where('id', '!=' , Auth::user()->id )
                  ->get();
    if(!$users->isEmpty()){

      $email_data = array(
          'user_email' => $email,
          'first_name'     => $firstName,
          'last_name' => $lastName,
          'users' =>$users,
          'created_at' =>Carbon::now(),
          'subject' => "Social user profile match",
      );
      $userIds = [];
      foreach ($users as $key => $user) {
        $userIds[] = $user->id;
      }

      $AdminNotificationModel = new AdminNotificationModel;
      $AdminNotificationModel->type="similarNamesMatch";
      $AdminNotificationModel->status="open";
      $AdminNotificationModel->user_id = $user->id;
      $AdminNotificationModel->match_users = json_encode($userIds);
      $AdminNotificationModel->save();

      $customer_email = $email;
      $admin_mail = Setting::value('email');
      //$admin_mail = 'malkeetvisionvivante@gmail.com';
      $admin_name = 'Blossom Team';
      $subjact = "Sign up user duplication alert: user sign up potential identity conflict"; 
      try {
          Mail::send(['html' => 'email/profile_match'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                      $message->from('preformly@gmail.com');
                      $message->to($admin_mail,'Blossom Team')->subject($subjact);

          });
      } catch(\Exception $ex) { 

      }
    }
  }

  static function isUserMatch($firstName, $lastName, $email){
    //For user match
    $users = User::where('name', 'like', '%' . $firstName . '%')
                  ->where('last_name', 'like', '%' . $lastName . '%')
                  ->where('id', '!=' , Auth::user()->id )
                  ->whereIn('type', ['Registerd','Invited','UserCreatedByAdmin','Referral'])
                  ->get();
    if(!$users->isEmpty()){
      $email_data = array(
          'user_email' => $email,
          'first_name'     => $firstName,
          'last_name' => $lastName,
          'subject' => "Sign up user duplication alert",
          'created_at' => Carbon::now(),
          'users' =>$users,
      );

      $userIds = [];
      foreach ($users as $key => $user) {
        $userIds[] = $user->id;
      }

      $AdminNotificationModel = new AdminNotificationModel;
      $AdminNotificationModel->type="similarNamesMatch";
      $AdminNotificationModel->status="open";
      $AdminNotificationModel->user_id = $user->id;
      $AdminNotificationModel->match_users = json_encode($userIds);
      $AdminNotificationModel->save();

      $customer_email = $email;
      $admin_mail = Setting::value('email');
      //$admin_mail = 'malkeetvisionvivante@gmail.com';
      $admin_name = 'Blossom Team';
      $subjact = "Sign up user duplication alert: user sign up potential identity conflict";
      $created_at = Carbon::now(); 
      //try {
          Mail::send(['html' => 'email/user_match'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name,$users, $created_at){
                      $message->from('preformly@gmail.com');
                      $message->to($admin_mail,'Blossom Team')->subject($subjact);

          });
      // } catch(\Exception $ex) { 
      //   die('dasdasd');
      // }
    }
  }

  static function isUserMatchWithAddNewCollegue($firstName, $lastName, $email, $id){
    //For user match
    $users = User::where('name', 'like', '%' . $firstName . '%')
                  ->where('last_name', 'like', '%' . $lastName . '%')
                  ->where('id', '!=' , $id )
                  //->whereIn('type', ['Registerd','Invited','UserCreatedByAdmin','Referral'])
                  //->where('id', '!=' , Auth::user()->id )
                  ->get();
    if(!$users->isEmpty()){
      $email_data = array(
          'user_email' => $email,
          'first_name'     => $firstName,
          'last_name' => $lastName,
          'subject' => "Sign up user duplication alert",
          'created_at' => Carbon::now(),
          'users' =>$users,
      );

      $userIds = [];
      foreach ($users as $key => $user) {
        $userIds[] = $user->id;
      }

      $AdminNotificationModel = new AdminNotificationModel;
      $AdminNotificationModel->type="similarNamesMatch";
      $AdminNotificationModel->status="open";
      $AdminNotificationModel->user_id = $user->id;
      $AdminNotificationModel->match_users = json_encode($userIds);
      $AdminNotificationModel->save();

      $customer_email = $email;
      $admin_mail = Setting::value('email');
      //$admin_mail = 'malkeetvisionvivante@gmail.com';
      $admin_name = 'Blossom Team';
      $subjact = "Sign up user duplication alert: user sign up potential identity conflict";
      $created_at = Carbon::now(); 
      //try {
          Mail::send(['html' => 'email/user_match_add_collegue'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name,$users, $created_at){
                      $message->from('preformly@gmail.com');
                      $message->to($admin_mail,'Blossom Team')->subject($subjact);

          });
      // } catch(\Exception $ex) { 
      //   die('dasdasd');
      // }
    }
  }

  static function isProfileMatchSocial($firstName, $lastName, $email){
    $users = User::where('name', 'like', '%' . $firstName . '%')
                  ->where('last_name', 'like', '%' . $lastName . '%')
                  //->whereIn('type', ['Imported','CreatedByUser','ProfileCreatedByAdmin'])
                  ->where('id', '!=' , Auth::user()->id )
                  ->get();
    if(!$users->isEmpty()){
      $email_data = array(
          'user_email' => $email,
          'first_name'     => $firstName,
          'last_name' => $lastName,
          'users' =>$users,
          'created_at' => Carbon::now(),
          'subject' => "Social user profile match",
      );

      $userIds = [];
      foreach ($users as $key => $user) {
        $userIds[] = $user->id;
      }

      $AdminNotificationModel = new AdminNotificationModel;
      $AdminNotificationModel->type="similarNamesMatch";
      $AdminNotificationModel->status="open";
      $AdminNotificationModel->user_id = $user->id;
      $AdminNotificationModel->match_users = json_encode($userIds);
      $AdminNotificationModel->save();

      $customer_email = $email;
      $admin_mail = Setting::value('email');
      //$admin_mail = 'malkeetvisionvivante@gmail.com';
      $admin_name = 'Blossom Team';
      $subjact = "Sign up user duplication alert: user sign up potential identity conflict"; 
      try {
          Mail::send(['html' => 'email/profile_match_social'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                      $message->from('preformly@gmail.com');
                      $message->to($admin_mail,'Blossom Team')->subject($subjact);

          });
      } catch(\Exception $ex) {

      }
    }
  }

  static function isDepartmentCreated($name, $email, $companyId, $departmentName){
    
      $company = Company::find($companyId);
      $email_data = array(
          'name'     => $name,
          'email'     => $email,
          'companyName' => $company->company_name,
          'departmentName' => $departmentName,
          'subject' => "New company registration alert: Request for new department",
      );

      $customer_email = 'preformly@gmail.com';
      $admin_mail = Setting::value('email');
      $admin_name = 'Blossom Team';
      $subjact = "New company registration alert: Request for new department"; 
      try {
          Mail::send(['html' => 'email/department_create'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                      $message->from('preformly@gmail.com');
                      $message->to($admin_mail,'Blossom Team')->subject($subjact);

          });
      } catch(\Exception $ex) { 

      }

  }

  static function reviewReport($reportedBy, $reporteTo, $count, $reviewData, $comment){
      if($count <= 1){
        $title = "Review has been reported by ".$count." user.";
      } else {
        $title = "Review has been reported by ".$count." users.";
      }
      $email_data = array(
          'from_name'     => $reportedBy->name." ".$reportedBy->last_name,
          'from_email'     => $reportedBy->email,
          'to_name' => $reporteTo->name." ".$reporteTo->last_name,
          'to_email' => $reporteTo->email,
          'comment' => $comment,
          'count' => $count,
          'reviewData' => $reviewData,
          'subject' => "Review has been reported",
      );

      $customer_email = 'preformly@gmail.com';
      $admin_mail = Setting::value('email');
      $admin_name = 'Blossom Team';
      $subjact = $title; 
      Mail::send(['html' => 'email/review_report'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
          $message->from('preformly@gmail.com');
          $message->to($admin_mail,'Blossom Team')->subject($subjact);

      });

  }

  static function lowScoreNotification($from, $to, $score, $manager_id){
      $title = $from." has left a ".$score." score on ".$to;
      $email_data = array(
          'title' =>$title,
          'from_name'=> $from,
          'to_name' => $to,
          'score' => $score,
          'url' => url('/manager-detail/'.$manager_id),
          'subject' => "Review has been reported",
      );

      $customer_email = 'preformly@gmail.com';
      $admin_mail = Setting::value('email');
      $admin_name = 'Blossom Team';
      $subjact = $title; 
      Mail::send(['html' => 'email/low_score'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
          $message->from('preformly@gmail.com');
          $message->to($admin_mail,'Blossom Team')->subject($subjact);

      });

  }

  static function spamBehavior($name, $lastName, $email, $userId){

      $AddedProfilesCount = AddedProfiles::where(['created_by' => $userId, 'match' => 'yes'])->count();
      if($AddedProfilesCount >=2){
        $email_data = array(
            'name'     => $name,
            'lastName'     => $lastName,
            'email' => $email,
            'subject' => "Spam Behavior",
        );

        $AdminNotificationModel = new AdminNotificationModel;
        $AdminNotificationModel->type="spamBehavior";
        $AdminNotificationModel->status="open";
        $AdminNotificationModel->user_id = $userId;
        $AdminNotificationModel->save();

        $customer_email = 'preformly@gmail.com';
        $admin_mail = Setting::value('email');
        $admin_name = 'Blossom Team';
        $subjact = "Spam Behavior"; 
        Mail::send(['html' => 'email/spam_behavior'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
            $message->from('preformly@gmail.com');
            $message->to($admin_mail,'Blossom Team')->subject($subjact);
        });
      }

  }

  static function reviewsByRevieweeLimit($from, $to, $from_email, $to_email ){
    $title = "Potential duplication / spam: ".$from." has attempted to review ".$to." more than 2 times in the last 2 weeks. ";
    $email_data = array(
        'title'     => $title,
        'from'     => $from,
        'from_email'     => $from_email,
        'to' => $to,
        'to_email' => $to_email,
    );

    $customer_email = 'preformly@gmail.com';
    $admin_mail = Setting::value('email');
    $admin_name = 'Blossom Team';
    $subjact = $title; 
    Mail::send(['html' => 'email/review_spam_behavior'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
        $message->from('preformly@gmail.com');
        $message->to($admin_mail,'Blossom Team')->subject($subjact);
    });
  }

  static function addCompany($companyName, $managerName, $managerEmail , $from){
    $title = "New Company:".$managerName." has joined the platform. Their company ".$companyName." is not yet in the system.";
    $email_data = array(
      'title' => $title,
      'company_name' => $companyName,
      'managerName' => $managerName,
      'managerEmail' => $managerEmail,
      'from' => $from,
    );

    $customer_email = 'preformly@gmail.com';
    $admin_mail = Setting::value('email');
    $admin_name = 'Blossom Team';
    $subjact = $title; 
    Mail::send(['html' => 'email/add_company_my_profile'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
        $message->from('preformly@gmail.com');
        $message->to($admin_mail,'Blossom Team')->subject($subjact);
    });
  }

  static function userChangeCompany($userId, $from, $to){
      $date = Carbon::now();
      $date1 =  Carbon::now()->subDays(60);
      $UsersLogCount = UsersLog::where(['user_id' => $userId, 'action_type' => 'changeCompany'])->whereBetween('created_at', [(string)$date1->startOfDay(), (string)$date->endOfDay()])->count();
      if($UsersLogCount >= 3){

        if($notification = AdminNotificationModel::where(['type' => 'userCompanyChange','status' => 'open','user_id' => $userId])->first()){
          $AdminNotificationModel = AdminNotificationModel::find($notification->id);
          $AdminNotificationModel->status="open";
          $AdminNotificationModel->updateTimestamps();
          $AdminNotificationModel->save();
        } else {
          $AdminNotificationModel = new AdminNotificationModel;
          $AdminNotificationModel->type="userCompanyChange";
          $AdminNotificationModel->status="open";
          $AdminNotificationModel->user_id = $userId;
          $AdminNotificationModel->save();
        }

        $title = "Potential identity resolution: ".Auth::user()->name." ".Auth::user()->last_name." has changed their company field ".$UsersLogCount." times in the last 14 days.";
        $email_data = array(
          'title'     => $title,
          'user_name'     => Auth::user()->name." ".Auth::user()->last_name,
          'email'     => Auth::user()->email,
          'current_company' => $to,
          'last_company' => $from,
          'subject' => "user change their company more than 3 times",
        );

        $customer_email = 'preformly@gmail.com';
        $admin_mail = Setting::value('email');
        $admin_name = 'Blossom Team';
        $subjact = $title; 
        try {
            Mail::send(['html' => 'email/change_company'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                        $message->from('preformly@gmail.com');
                        $message->to($admin_mail,'Blossom Team')->subject($subjact);

            });
        } catch(\Exception $ex) { 

        }

      } else {
        return false;
      }
  }

}
