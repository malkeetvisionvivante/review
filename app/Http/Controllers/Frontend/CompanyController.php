<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Company;
use App\Managers;
use App\Departments;
use App\Visitors;
use App\Reviews;
use Illuminate\Support\Facades\Hash;
use File;
use Carbon\Carbon;

class CompanyController extends Controller {
  public function __construct() {}

  public function company_detail(Request $request,$id) {
    $data = Company::where('company.id',$id)->first();
     $departmentspre = Departments::where('status',0)->where('name','!=' ,"Consulting, Research & Solutions");
     $departments = Departments::where('status',0)->where('name', "Consulting, Research & Solutions")
     ->union($departmentspre)
     ->get();
    if(!empty($data)) {
      return view('frontend.company.company_detail',compact('data','departments'));
    } else {
      toastr()->error('Company Not Found!!'); 
      return abort(404);
    }
  }

  // public function company_detail(Request $request,$id) {
  //   $data = Company::select('company.*','countries.name as country_name','states.name as state_name','company_types.name as company_type_name')
  //    //->join('company','company.company_id','=','users.id')
  //    ->join('countries','countries.id','=','company.country_code')
  //    ->join('company_types','company_types.id','=','company.company_type')
  //    ->join('states','states.id','=','company.state_code')
  //    //->where('users.role',2)
  //    ->where('company.id',$id)->where('company.status',0)->first();
  //    $departmentspre = Departments::where('status',0)->where('name','!=' ,"Consulting, research, and solutions");
  //    $departments = Departments::where('status',0)->where('name', "Consulting, research, and solutions")
  //    ->union($departmentspre)
  //    ->get();
  //   if(!empty($data)) {
  //     return view('frontend.company.company_detail',compact('data','departments'));
  //   } else {
  //     toastr()->error('Company Not Found!!'); 
  //     return abort(404);
  //   }
  // }
  
}
