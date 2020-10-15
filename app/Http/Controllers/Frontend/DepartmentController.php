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

class DepartmentController extends Controller {
  public function __construct() {}

  public function department_detail(Request $request,$id) {
    $data = Departments::find($id);
    return view('frontend.department.department_detail',compact('data')); 
  }

}
