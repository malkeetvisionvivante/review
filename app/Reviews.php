<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\review_questions;
use App\Company;
use App\Departments;
use App\Managers;
use App\ReviewLikes;
use Auth;
use App\ReviewFlagReport;
class Reviews extends Model
{
    protected $table = 'reviews';
    protected  $fillable = [
        'user_id', 'customer_id','review_value','status','comment_hidden','description','question_id','user_role','company_id'
    ];

    public function customer($customer_id)
    {
    	 $data = User::find($customer_id);
        return $data;
    }
    public function customer1($customer_id)
    {
        $data = User::find($customer_id);
        return $data;
    }
     public function company($id)
    {
         $data = Company::select('company.*','countries.name as country_name','states.name as state_name')
               //->join('company','company.company_id','=','users.id')
               ->join('countries','countries.id','=','company.country_code')
               ->join('states','states.id','=','company.state_code')
               //->where('users.role',2)
               ->where('company.id',$id)->first();
         return $data;
    }
     public function manager($id)
    {
         $data = User::select('users.*','departments.name as dep_name')->leftjoin('departments','departments.id','=','users.department_id')->where('users.id',$id)->first();
         return $data;
    }

    
    public function Question($id)
    {
        $data = review_questions::find($id);
        if($data){
            return $data->question;
        } else {
            return "Question Not Found.";
        }
        
    }
    public function customer_name($id)
    {
         $data = User::find($id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }

    public function customerName()
    {
         $data = User::find($this->customer_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }

     public function customer_Email()
    {
         $data = User::find($this->customer_id); 
         if(empty($data))
         {
            return '';
         }
         return $data->email;
    }
    
    public function getAvgReview()
    {
        $data  = $this->avg_review;
        return number_format((float)$data, 1, '.', '');
    }

    public function userName() 
    {
         $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }

    public function userEmail()
    {
         $data = User::find($this->user_id);
         if(empty($data))
         {
            return '';
         }
         return $data->email;
    }


    public function customer_image()
    {
        $data = User::find($this->user_id);
        if(empty($data)) {
            return '';
        } else {
            return $data->profile;
        }
    }
    public function compnay_name() 
    {
        $data = Company::find($this->company_id);
        if(empty($data)) {
            return 'Not Found';
        } else {
            return $data->company_name;
        }
    }
    public function department_name() 
    {
        $data = Departments::find($this->department_id);
        if(empty($data)) {
            return '';
        } else {
            return $data->name;
        }
    }
    public function compnay_image()
    {
        $data = Company::find($this->company_id);
        if(empty($data)) {
            return '';
        } else {
            return $data->logo;
        }
    }

    public function commentLikeCount()
    {
        return ReviewLikes::where(['review_id' => $this->id, 'action' => 'Like'])->count();
    }

    public function isLike()
    {
        $data =  ReviewLikes::where(['review_id' => $this->id, 'action' => 'Like','like_by' => Auth::user()->id ])->count();
        if($data){
            return true;
        }
        return false;
    }

    public function commentDislikeCount()
    {
        return ReviewLikes::where(['review_id'=> $this->id, 'action' => 'Dislike'])->count();
    }

    public function createdAt()
    {
        return date('F d, Y', strtotime( $this->created_at ));  
    }

    public function isDisLike()
    {
        $data =  ReviewLikes::where(['review_id'=> $this->id, 'action' => 'Dislike', 'like_by' => Auth::user()->id])->count();
        if($data){
            return true;
        }
        return false;
    }
    public function _flagCount(){
        return ReviewFlagReport::where(['review_id' => $this->id, 'manager_id' => $this->user_id,'flagger_id' => $this->flagger_id])->count();
    }
    public function isFlagged()
    {
        // print_r(["hello",Auth::user()]);die;
        if(Auth::user()){
            $data =  ReviewFlagReport::where(['review_id' => $this->id, 'manager_id' => $this->user_id,'flagger_id' => Auth::user()->id ])->first();
        }elseif(Auth::guard('admin')->user()){
            $data =  ReviewFlagReport::where(['review_id' => $this->id, 'manager_id' => $this->user_id,'flagger_id' => Auth::guard('admin')->user()->id ])->first();
        }else{
            return true;
        }
        if($data){
            return true;
        }
        return false;
    }
}
