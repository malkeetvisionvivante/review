<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\User;
use App\Reviews;
use App\Departments;
use App\company_types;

class Registermailchamp extends Authenticatable
{
    static function register($userId){
      /*$userData = User::find($userId);
      if(!$userData){
        return false;
      }
      $data = [
          'email'     => $userData->email,
          'status'    => 'subscribed',
          'firstname' => $userData->name,
          'lastname'  => $userData->last_name
      ];

      $apiKey = 'aef6e2d7b12b29234f6c18872f897e73-us17';
      $listId = 'd39e1b2771';

      $memberId = md5(strtolower($data['email']));
      $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
      $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

      $json = json_encode([
          'email_address' => $data['email'],
          'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
          'merge_fields'  => [
              'FNAME'     => $data['firstname'],
              'LNAME'     => $data['lastname']
          ]
      ]);

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

      $result = curl_exec($ch);
      curl_close($ch);
      $returnData = json_decode($result, true);
      if(isset($returnData['id'])){
          $userData->mail_champ_id = $returnData['id'];
          $userData->save();
      }

      //////////////////////////////////////////
      $data = [
          'email'     => $userData->email,
          'status'    => 'subscribed',
          'firstname' => $userData->name,
          'lastname'  => $userData->last_name
      ];
      $apiKey = 'e7b22bee998eac41d457e415ec0c507b-us17';
      $listId = 'b7809d3caa';

      $memberId = md5(strtolower($data['email']));
      $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
      $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

      $json = json_encode([
          'email_address' => $data['email'],
          'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
          'merge_fields'  => [
              'FNAME'     => $data['firstname'],
              'LNAME'     => $data['lastname']
          ]
      ]);

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

      $result = curl_exec($ch);
      curl_close($ch);*/

    }
}
