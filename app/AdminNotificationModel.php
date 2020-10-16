<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use App\User;
use Mail;
use App\Setting;
use App\Company;
use App\UsersLog;
use App\ReviewFlagReport;
use App\Reviews;
use App\AddedProfiles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminNotificationModel extends Model {

  	protected $table = 'admin_notifications';
    public $timestamps = true;

   	public function similarMatchUsersList(){
      $usersArray = json_decode($this->match_users);
      if(count($usersArray) > 0){
        if($users = User::whereIn('id',$usersArray)->get()){
          return $users;
        }
      }
      return [];
    }
    public function numberOfReportCount(){
      return $ReviewFlagReport = ReviewFlagReport::where('review_id' , $this->review_id )->count();
    }
    public function reportBy(){
   		return $ReviewFlagReport = ReviewFlagReport::where('review_id' , $this->review_id )->orderBy('created_at', 'DESC')->get();
   	}
	public function reviwBy(){
   		return $Reviews = Reviews::where(['customer_id'=> $this->review_by, 'user_id' =>$this->review_to ])->orderBy('created_at', 'DESC')->get();
   	}
 	
 	public function spamProfileList(){
    return $AddedProfilesCount = AddedProfiles::where(['created_by' => $this->user_id, 'match' => 'yes'])->orderBy('created_at', 'DESC')->get();
  }
  public function changeCompanyList(){
    return $UsersLogt = UsersLog::where(['user_id' => $this->user_id, 'action_type' => 'changeCompany'])->orderBy('created_at', 'DESC')->get();
  }
  public function changeCompanyCount(){
    return $UsersLogt = UsersLog::where(['user_id' => $this->user_id, 'action_type' => 'changeCompany'])->count();
  }
  public function title(){
    //'commentReportLimit','reviewsByRevieweeLimit','newCompanyAdded','userCompanyChange','spamBehavior','lowScore','similarNamesMatch'

    if($this->type == 'lowScore'){
      return $this->lowScoreCustomerName()." has left a ".$this->reviewScore()." score on ".$this->lowScoreUserName();
    }

    if($this->type == 'commentReportLimit'){   
      return "Review has been reported by ".$this->numberOfReportCount()." users."; 
    }

    if($this->type == 'similarNamesMatch'){
      return "users exist with identical or highly similar name with: ".$this->similarMatchUserName();
    }

    if($this->type == 'reviewsByRevieweeLimit'){
      return "Potential duplication / spam: ".$this->reviewCustomerName()." has attempted to review ".$this->reviewUserName()." more than 2 times in the last 2 weeks.";
    }

    if($this->type == 'userCompanyChange'){
      return "Potential identity resolution: ".$this->changeCompanyUserName()." has changed their company field ".$this->changeCompanyCount()." times in the last 14 days.";
    }

    if($this->type == 'newCompanyAdded'){ // create new user
      return "New Company: ".$this->companyUserName()." has joined the platform. Their company ".$this->companyName()." is not yet in the system.";
    }

    if($this->type == 'spamBehavior'){
      return "Add new profiles spam behavior";
    } 

    if($this->type == 'newCompanyAddedThroughFooter'){
      if($this->user_id){
        return "New Company: ".$this->company_name." company has been requested for addition by `user` ".$this->companyUserName();
      } else {
        return "New Company: ".$this->company_name." company has been requested for addition by `guest`";
      }
    }    
   
    return "Not Found";
  }
  public function companyName(){
    $Company = Company::find($this->company_id);
    return $Company->company_name;
  }
  public function newCompanyAddedThroughFooterType(){
    if($this->user_id){
      return 'User';
    }
    return 'Guest';
  }
  public function reportOnUserName(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->userName();
  }
  public function lowScoreCustomerName(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->customer_name($Reviews->customer_id);
  } 
  public function lowScoreCustomerEmail(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->customer_Email();
  } 
  public function lowScoreUserId(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->user_id;
  }
  public function reviewUserId(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->user_id;
  }
  public function lowScoreUserName(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->userName();
  } 
  public function lowScoreUserEmail(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->userEmail();
  }
  public function reportOnUserEmail(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->userEmail();
  }

  public function reviewComment(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->comment;
  }
  public function reviewScore(){
    $Reviews = Reviews::find($this->review_id);
    return $Reviews->avg_review;
  }

  public function similarMatchUserName(){
    $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
  }
  public function companyUserName(){
     $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
  }

  public function similarNamesMatchUserName(){
     $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
  }

  public function newCompanyAddedThroughFooterUserName(){
     $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
  }

  public function changeCompanyUserName(){
     $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
  }

  public function spamUserName(){
     $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
  }

  public function reviewUserName(){
      $data = User::find($this->review_to);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }
  public function reviewCustomerName(){
      $data = User::find($this->review_by);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }
  public function companyUserEmail(){
    $data = User::find($this->user_id); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  } 
  public function similarMatchUserEmail(){
    $data = User::find($this->user_id); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
  public function newCompanyAddedThroughFooterUserEmail(){
    $data = User::find($this->user_id); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
  public function spamUserEmail(){
    $data = User::find($this->user_id); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
  public function changeCompanyUserEmail(){
    $data = User::find($this->user_id); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
  public function reviewUserEmail(){
     $data = User::find($this->review_to); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
  public function reviewCustomerEmail(){
     $data = User::find($this->review_by); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
}
