<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\User;
use App\Reviews;
use App\Departments;

class Managers extends Model
{
     protected $table = 'manager';
     protected  $fillable = [
        'first_name','last_name','email','phone','status','profile','department_id' ,'company_id','about'
    ];

    public function companyImage($companyId){
    	$data = user::find($companyId);
    	return $data->profile;
    }

    public function department($id)
    {
    	  $dep = Departments::find($id);
    	  if(!empty($dep))
    	  {
    	     return $dep->name;

    	  }
    	  return '';

    }
    public function manager_review($id)
    {
    	return $review = Reviews::where('user_id',$id)->avg('avg_review');
    }
    public function people_count($id)
    {
       return $people = Reviews::where('user_id',$id)->count();
    }
}
