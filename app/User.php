<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Company;
use App\Reviews;
use App\Departments;
use App\company_types;
use App\ReferalUser;
use App\Invitations;
use App\Bookmarks;
use App\AddedProfiles;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    const SUPER_USER = 1;
    const COMPANY = 2;
    const USER_DEFAULT = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','last_name','profile','role','description','status','phone','google_id', 'facebook_id' ,'linkedin_id','type','created_by','mail_champ_id','referal_uid','linkedin_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function isAdmin()    {
        return (int)$this->role === self::SUPER_USER;
    }

    public function fullName(){
      return $this->name." ".$this->last_name;
    }
    public function company()
    {
          return $this->hasOne('App\Company','company_id');
    }
     

    public function Manager()
    {
         return $this->hasMany('App\Managers','company_id')->orderBy('id','DESC');
    }
    public function companyIsdisable() {
      $company = Company::find($this->company_id);
      if($company){
        if($company->status == 1){
          return true;
        }
      }
      return false;
    }
    public function companyType($companyId) {
      if($companyId){
        $com = Company::find($companyId);
        $data = company_types::find($com->company_type);
        if($data){
            return $data->name;
        } else {
            return '';
        }
      } else {
        return '';
      }
    }
    public function companyName($companyId) {
        $com = Company::find($companyId);
        if($com){
            return $com->company_name;
        } else {
            return '';
        }
    }
    public function review($id) {
        $manager_ids = Managers::where('company_id',$id)->pluck('id')->toArray();
         array_push($manager_ids, $id);
         $data = Reviews::whereIn('user_id',$manager_ids)->avg('avg_review');
         return $data;
    }
    public function comp_type($id) {
        $data = company_types::where('id',$id)->first();
        return $data->name;
    }
    public function industry_avg($id) {
        $company = Company::find($id);
        if($company){
          $review = Reviews::where('ind_type', $company->company_type)->avg('avg_review');
          return number_format((float)$review, 2, '.', '');
        } else {
          return number_format((float)0, 2, '.', '');
        }
        
    }
    public function peerAvg() {
      //$data = self::where('company_id', $this->company_id)->pluck('id')->toArray();
      $review = Reviews::where(['user_id' => $this->id,'working_as' => 'Peer'])->avg('avg_review');
      if($review){
        return number_format((float)$review, 1, '.', '');
      }
      return number_format((float)0, 1, '.', '');
    }
    public function peerReviewCount() {
      return Reviews::where(['user_id' => $this->id,'working_as' => 'Peer'])->count();
    }

    public function managerAvg() {
      //$data = self::where('company_id', $this->company_id)->pluck('id')->toArray();
      $review = Reviews::where(['user_id' => $this->id,'working_as' => 'Manager'])->avg('avg_review');
      if($review){
        return number_format((float)$review, 1, '.', '');
      }
      return number_format((float)0, 1, '.', '');
    }

    public function ManagerReviewCount() {
      return Reviews::where(['user_id' => $this->id,'working_as' => 'Manager'])->count();
    }
        
    public function manager_review($id) {
        $review = Reviews::where('user_id',$id)->avg('avg_review');
        return number_format((float)$review, 1, '.', '');
    }

    public function manager_review1($id) {
        $review = Reviews::where('user_id',$id)->avg('avg_review');
        return number_format((float)$review, 1, '.', '');
    }
    
    public function type() {
      if($this->type == 'Imported'){
        return 'Imported User';
      }
      if($this->type == 'CreatedByUser' || $this->type == 'UserCreatedByAdmin' || $this->type == 'ProfileCreatedByAdmin'){
        return 'Added User ';
      }
      if($this->type == 'Registerd'){
        return 'Registerd ';
      }
      if($this->type == 'Referral'){
        $ReferalUser = new ReferalUser;
        return 'Referral, Referrer : '.$ReferalUser::refralUserName($this->referal_uid);
      }
      if($this->type == 'Invited'){
        $Invitations = new ReferalUser;
        return 'Invitee, Inviter : '.$Invitations::inviterUserName($this->invitation_id);
      }
      return '';
    }

    public function people_count($id) {
       return $people = Reviews::where('user_id',$id)->count();
    }

    public function userCompanyImage($companyId){
        $Company = Company::find($companyId);
        if($Company == '' || ($Company != '' && $Company->logo == '')){
          return 'silmarilli.svg';
        } else {
          return $Company->logo;
        }
    }
    
    public function departmentName(){
        if($this->department_id){
          $department = Departments::find($this->department_id);
          return $department->name;
        } else {
          return '';
        }
    }

    public function isDepartment(){
      if($this->department_id){
        return true;
      } 
      return false;
    }

    public function departmentIsVisible(){
      if($this->department_id){
        $department = Departments::find($this->department_id);
        if($department->status == 0){
          return true;
        }
        return false;
      } 
      return false;
    }

    public function getTitle(){
        if($this->job_title && $this->departmentName()){
          $title = $this->job_title." / ".$this->departmentName();
          if(strlen($title) > 20){
            return '<h6 class="text-muted mb-2"> <span id="half_title">'. substr($title,0,20) .'</span> <a id="show_full_title" href="javascript:void(0)">...</a> <span id="full_title">'. $title .'</span> </h6>';
          } else {
            return '<h6 class="text-muted mb-2">'.$title.'</h6>';
          }
        } else if($this->job_title){
          $title = $this->job_title;
          if(strlen($title) > 20){
            return '<h6 class="text-muted mb-2"> <span id="half_title">'. substr($title,0, 20) .'</span> <a id="show_full_title" href="javascript:void(0)">...</a> <span id="full_title">'. $title .'</span> </h6>';
          } else {
            return '<h6 class="text-muted mb-2">'.$title.'</h6>';
          }
        } else {
          return '<h6 class="text-muted mb-2">'.$this->departmentName() .'</h6> ';
        }
    }
    public function getTitle1(){
        // if($this->job_title && $this->departmentName()){
        //   $title = $this->job_title." / ".$this->departmentName();
        //   if(strlen($title) > 20){
        //     return '<h6 class="text-muted mb-2"> <span id="half_title">'. substr($title,0,20) .'</span> <a id="show_full_title" href="javascript:void(0)">...</a> <span id="full_title">'. $title .'</span> </h6>';
        //   } else {
        //     return '<h6 class="text-muted mb-2">'.$title.'</h6>';
        //   }
        // } else 
        if($this->job_title){
          $title = $this->job_title;
          if(strlen($title) > 27){
            return '<h6 class="text-muted mb-2"> <span id="half_title">'. substr($title,0, 27) .'</span> <a id="show_full_title" href="javascript:void(0)">...</a> <span id="full_title">'. $title .'</span> </h6>';
          } else {
            return '<h6 class="text-muted mb-2">'.$title.'</h6>';
          }
        } 
        return '';
    }
    public function isBookmark(){
      if(Auth::check()){
        $bookmark = Bookmarks::where([ 'user_id' => Auth::user()->id,'manager_id' => $this->id ])->first();
        if($bookmark){
          return true;
        }
        return false;
      } else {
        return false;
      }
    }

    public function isAbleToAdd(){
      $AddedProfilesCount = AddedProfiles::where(['created_by' => Auth::user()->id, 'match' => 'yes'])->count();
      if($AddedProfilesCount >=2){
        return false;
      } 
      return true;
    }
    public function inCompleteProfileCount(){
      $count = 0;
      if(!Auth::user()->company_id){
        $count = $count + 1;
      }
      if(!Auth::user()->department_id){
        $count = $count + 1;
      }
      if(!Auth::user()->job_title){
        $count = $count + 1;
      }
      return $count;
    }
}
