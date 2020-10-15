<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\review_questions;
use App\Company;
use App\Departments;
use App\Managers;
use App\InvitationBy;

class Invitations extends Model {

    protected $table = 'invitations';

    public function visit(){
    	if($this->visit == '1'){
    		return 'Yes';
    	}
    	return 'No';
    }

    public function isRegister(){
    	$data = User::where('invitation_id', $this->id)->get();
    	if(count($data) > 0){
    		return 'Yes';
    	}
    	return 'No';
    }
    
    public function senByGuest(){
        $data = InvitationBy::find($this->invitation_by);
        if($data){
            return ($data->type == 'Guest')? true: false;
        }
        return false;
    }
}
