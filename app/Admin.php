<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Company;
use App\Reviews;
use App\Departments;
use App\company_types;

class Admin extends Authenticatable 
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
        'name', 'email', 'password','last_name','profile','role','description','status','phone','google_id', 'facebook_id' ,'linkedin_id'
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

    protected $table = "admins";

    public function isAdmin()    {
        return (int)$this->role === self::SUPER_USER;
    }

    public function company()
    {
          return $this->hasOne('App\Company','company_id');
    }
     

    public function Manager()
    {
         return $this->hasMany('App\Managers','company_id')->orderBy('id','DESC');
    }
    public function companyType($companyId) {
        $com = Company::find($companyId);
        $data = company_types::find($com->company_type);
        if($data){
            return $data->name;
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
    public function manager_review($id) {
        $review = Reviews::where('user_id',$id)->avg('avg_review');
        return number_format((float)$review, 2, '.', '');
    }
    
    public function people_count($id) {
       return $people = Reviews::where('user_id',$id)->count();
    }

    public function userCompanyImage($companyId){
        $Company = Company::find($companyId);
        if($Company == ''){
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
}
