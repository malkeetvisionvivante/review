<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Managers;
use App\Review;

class Departments extends Model
{
   protected $table = 'departments';
    protected  $fillable = [
        'name', 'company_id','description','logo','status'
    ];

    public function review($id) {
    	 $managers_ids = User::where('department_id',$id)->where('status',0)->pluck('id')->toArray();
    	 $review = Reviews::whereIn('user_id',$managers_ids)->avg('avg_review');
    	 return $review;
    }
    public function people_count($id) {
         $review = Reviews::where('department_id',$id)->count();
         return $review;
    }

    public function company_image($id) {
        $data = User::where('id',$id)->first();
        if(!empty($data))
        {
            return $data->profile;
        }
        else{
            return '';
        }
    }

    public function companyDepartmentScore($companyId, $departmenyId) {
        $review = Reviews::where(['company_id'=> $companyId, 'department_id' => $departmenyId ])->avg('avg_review');
        return number_format((float)$review, 2, '.', '');
    } 

    public function companyIndScore($indType , $departmenyId) {
        $review = Reviews::where(['ind_type'=> $indType, 'department_id' => $departmenyId ])->avg('avg_review');
        return number_format((float)$review, 2, '.', '');
    }

    public function companyDepartmentManagerScore($companyId, $departmenyId) {
        $review = Reviews::where(['company_id'=> $companyId, 'department_id' => $departmenyId ,'working_as' => 'Manager'])->avg('avg_review');
        return number_format((float)$review, 1, '.', '');
    }

    public function companyDepartmentManagerPeerScore($companyId, $departmenyId) {
        $review = Reviews::where(['company_id'=> $companyId, 'department_id' => $departmenyId ,'working_as' => 'Peer'])->avg('avg_review');
        return number_format((float)$review, 1, '.', '');
    }
}

