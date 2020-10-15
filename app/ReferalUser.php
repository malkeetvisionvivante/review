<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Invitations;

class ReferalUser extends Model {

  static function refralUserName($referal_uid){
    $user = User::find($referal_uid);
    if($user){
      return $user->name." ".$user->last_name;
    }
    return false;
  }
  static function inviterUserName($invitation_id){
    $data = Invitations::find($invitation_id);
    if($data){
      $user = User::find($data->send_by);
	    if($user){
	      return $user->name." ".$user->last_name;
	    }
	    return false;
    }
    return false;
  }
}
