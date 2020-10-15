<?php

namespace App\Http\Controllers\Frontend;
include "/home/sftpuser/public_html/php72/review_system_import/SimpleXLS.php";
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Company;
use App\company_types;
use App\Managers;
use App\Departments;
use App\Visitors;
use App\Reviews;
use Illuminate\Support\Facades\Hash;
use File;
use SimpleXLS;
use Carbon\Carbon;

class ImportController extends Controller {
  public function __construct() {}

  public function grab_image($url,$saveto){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
  }

  public function company(Request $request) {

    ////Insert states
    // $lines =fopen('/home/sftpuser/public_html/php72/review_system_import/flexc_zone.csv', 'r');
    // echo "<pre>";
    // while (($line = fgetcsv($lines)) !== FALSE) {
    //   //print_r($line);
    //   $Countries = new States;
    //   $Countries->name = $line[2];
    //   $Countries->country_id = $line[1];
    //   $Countries->code = $line[3];
    //   $Countries->save();
    // }
    // fclose($lines);
    
    ////Insert company Types 
    // if ( $xlsx = SimpleXLS::parse('/home/sftpuser/public_html/php72/review_system_import/copmany.xls') ) {
    //   $i = 0;
    //   foreach ($xlsx->rows() as $elt) {
    //     if ($i != 0) {
    //       if(!company_types::where('name',$elt[5])->first()){
    //         $company_types = new company_types;
    //         $company_types->name = $elt[5];
    //         $company_types->save();
    //         echo $i."==".$elt[5]."<br>";
    //       }
    //     }
    //     $i++;
    //   }
    // }

    ////Insert company 
    // if ( $xlsx = SimpleXLS::parse('/home/sftpuser/public_html/php72/review_system_import/copmany.xls') ) {
    //   $i = 0;
    //   foreach ($xlsx->rows() as $elt) {
    //     if ($i != 0) {
    //         $companyType = company_types::where('name',$elt[5])->first();

    //         if($elt[4] == 'UK') $elt[4] = 'GBR'; 
    //         if($elt[4] == 'Czechia') $elt[4] = 'CZE'; 
    //         if($elt[4] == 'Maryland') $elt[4] = 'USA'; 
    //         $country = Countries::where('iso_code_3',$elt[4])->orWhere('name', $elt[4])->orWhere('name', 'like', '%' .$elt[4]. '%')->first();

    //         if($elt[3]){
    //             if($elt[3] == 'NS') $country->id = 38; 
    //             $States = States::where(['code' => $elt[3], 'country_id' => $country->id])->first();
    //             $stateId = $States->id;
    //         } else {
    //             $stateId = null;
    //         }

    //         $Company = new Company;
    //         $Company->company_name = $elt[0];
    //         $Company->city = $elt[2];
    //         $Company->state_code = $States->id;
    //         $Company->country_code = $country->id;
    //         $Company->company_type = $companyType->id;
    //         $Company->no_of_employee = $elt[6];

    //         $path = getcwd()."/images/company/";
    //         $name = time()."_".$i.'.png';
    //         $this->grab_image($elt[8], $path.$name);
    //         $Company->logo = $name;
    //         $Company->save();
    //     }
    //     $i++;    
    //   }
    // }

    //Insert department
    // $lines =fopen('/home/sftpuser/public_html/php72/review_system_import/emp.csv', 'r');
    // $i = 0;
    // while (($line = fgetcsv($lines)) !== FALSE) {
    //     if ($i != 0) {
    //         if($line[0] == 'Yes' && $line[5] == 'Yes' && $line[11] != ''){
    //            if(!Departments::where('name',$line[11])->first()){
    //                 print_r($line[11]);
    //                 echo "---".$i."<br>";
    //                 $Departments = new Departments;
    //                 $Departments->name = $line[11];
    //                 $Departments->status = 0;
    //                 $Departments->save();
    //                 echo $i."==".$line[11]."<br>";
    //             }
    //         }
    //     }
    // $i++;
    // }


    //Insert Users
    $lines =fopen('/home/sftpuser/public_html/php72/review_system_import/Book1.csv', 'r');
    $i = 0;
    while (($line = fgetcsv($lines)) !== FALSE) {
        if ($i != 0) {
            if($line[0] == 'Yes' && $line[5] == 'Yes' && $line[11] != ''){
                $department = Departments::where('name',$line[11])->first();
                if($line[1] == 'Rothy?s') $line[1] = 'Rothy’s';

                $company = Company::where('company_name',$line[1])->first();
                $User = new User;
                $User->name = $line[8];
                $User->last_name = $line[9];
                $User->job_title = $line[10];
                $User->linkedin_url = $line[12];
                $User->company_id = $company->id;
                $User->department_id = $department->id;
                $User->role = 3;
                $User->type = 'Imported';
                $User->status = 0;
                $User->email = time()."_".$i."@blossom.team";
                $User->save();
            }
        }
    $i++;
    }



    /////////////////////////////////////////////////////////////

    //Insert department
    // $lines =fopen('/home/sftpuser/public_html/php72/review_system_import/employ.csv', 'r');
    // echo "<pre>";
    // $i = 0;
    // while (($line = fgetcsv($lines)) !== FALSE) {
    //   if($i != 0){
    //     $d = Departments::where('name',$line[10])->first();
    //     $c = Company::where('company_name',$line[2])->first();
    //     $User = new User;
    //     $User->name = $line[7];
    //     $User->last_name = $line[8];
    //     $User->job_title = $line[9];
    //     $User->company_id = $c->id;
    //     $User->department_id = $d->id;
    //     $User->role = 3;
    //     $User->status = 0;
    //     $User->email = time()."_".$i."@preformly.com";
    //     $User->save();
    //   }
    //   $i++;
    // }
    // fclose($lines);
  }
  
}
