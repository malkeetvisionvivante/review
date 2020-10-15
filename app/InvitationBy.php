<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\review_questions;
use App\Company;
use App\Managers;
use App\Invitations;

class InvitationBy extends Model {
    protected $table = 'invitation_by';

    public function firstName(){
    	$data = Invitations::where('invitation_by', $this->id)->first();
    	if($data){
    		return $data->receiver_name;
    	}
    	return null;
    }

    public function lastName(){
        $data = Invitations::where('invitation_by', $this->id)->first();
        if($data){
            return $data->receiver_last_name;
        }
        return null;
    }

    public function senderEmail(){
    	$data = Invitations::where('invitation_by', $this->id)->first();
    	if($data){
    		return $data->sender_email;
    	}
    	return null;
    } 
    public function accountOrigin(){
        $data = Invitations::where('invitation_by', $this->id)->first();
        if($data){
            return $data->account_origin;
        }
        return null;
    }
}
