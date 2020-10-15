<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\company_types;
use App\States;
use App\Countries;
class Company extends Model
{
     protected $table = 'company';
    protected  $fillable = [
        'country_code','state_code','city','address','no_of_employee','company_type','zipcode','about'
    ];

    public function company_review($id)
    {
        $review = Reviews::where('company_id',$id)->avg('avg_review');
        return number_format((float)$review, 2, '.', '');
    }
     public function industry_avg($type){
        $review = Reviews::where(['ind_type'=>$type, 'company_id' => $this->id])->avg('avg_review');
        return number_format((float)$review, 2, '.', '');
    }
    public function comp_type($id)
    {
        $data = company_types::where('id',$id)->first();
        if($data) { return $data->name; }
        return '';
    }
    public function people_count()
    {
       return $people = Reviews::where('company_id',$this->id)->count();
    }

    public function overallManagerReview()
    {
        $review = Reviews::where(['company_id' => $this->id, 'working_as' => 'Manager'])->avg('avg_review');
        return number_format((float)$review, 1, '.', '');
    }

    public function overallPeerReview()
    {
        $review = Reviews::where(['company_id' => $this->id, 'working_as' => 'Peer'])->avg('avg_review');
        return number_format((float)$review, 1, '.', '');
    }

    public function fullAddress()
    {
        $address = '';
        if($this->address){
            $address .= $this->address.", ";
        }
        if($this->city){
            $address .= $this->city.", ";
        }
        if($this->state_code){
            $data =  States::find($this->state_code);
            if($data){
                $address .= $data->code.", ";
            }
        }
        if($this->country_code){
            $data =  Countries::find($this->country_code);
            if($data){
                $address .= $data->name." ";
            }
        }
        if($this->zipcode){
            $address .= $this->zipcode;
        }
       return $address;
    }
    //{{ $data->address}}, {{ $data->city}}, {{ $data->state_name}}, {{ $data->country_name}} {{ $data->zipcode}}
}
