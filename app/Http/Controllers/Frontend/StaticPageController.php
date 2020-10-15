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

class StaticPageController extends Controller {

    public function __construct() {}

    public function aboutus_view() {
        return view('frontend.aboutus.index');
    }

    public function careerss_view() {
        return view('frontend.careerss.index');
    }

    public function help_view() {
        return view('frontend.help.index');
    }
    public function let_us_know_view() {
        return view('frontend.let_us_know.index');
    }

    public function press_view() {
        return view('frontend.press.index');
    }

    public function register_your_company_view() {
        return view('frontend.register_company.index');
    }

    public function user_agreement_view() {
        return view('frontend.user_agreement.index');
    }

    public function other_policies_view() {
        return view('frontend.other_policies.index');
    }

    public function privacy_policy_view() {
        return view('frontend.privacy_policy.index');
    }

    public function cookie_policy_view() {
        return view('frontend.cookie_policy.index');
    }

    public function terms_conditions_view() {
        return view('frontend.terms_conditions.index');
    }
}
