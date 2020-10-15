<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Reviews;
use App\User;
class ReviewFlagReport extends Model {
    protected $table = 'review_flag_report';
    protected  $fillable = [
        'review_id', 'manager_id','flagger_id'
    ];



    public function customer_name() {
         $data = User::find($this->flagger_id);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }
    public function customer_Email() {
         $data = User::find($this->flagger_id);
         if(empty($data))
         {
            return '';
         } 
         return $data->email;
    }
}