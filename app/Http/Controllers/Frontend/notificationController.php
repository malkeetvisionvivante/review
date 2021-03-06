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
use App\review_questions;
use App\ReviewCategory;
use App\UserAgent;
use App\Registermailchamp;
use Cookie;
class notificationController extends Controller {
      public function __construct() {}
      
      public function notifications(Request $request) {
        return view('frontend.notification.index');
    }

}