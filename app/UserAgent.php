<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class UserAgent extends Model {

    static function IPADDRESS(){
    	return self::get_client_ip();
    }

    static function DEVICETYPE(){
    	$deviceType = 'Desktop';
    	$agent = new Agent();
          //$device = $agent->isDesktop();
      	if($agent->isMobile()){
        	$deviceType = 'Mobile';
      	}
      	if($agent->isTablet()){
        	$deviceType = 'Tablet';
      	}
      	// if($platform = $agent->platform()){
       //  	$deviceType = $platform.", ".$deviceType;
      	// }
      	return $deviceType;
    }

    static function LOCATION($ip_address){
    	$addressData = (file_get_contents('https://www.iplocate.io/api/lookup/'.$ip_address));
    	return $addressData;
    }
   	
   	static function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
         $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  	}
}
