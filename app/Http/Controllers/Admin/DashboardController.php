<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Company;
use App\Managers;
use App\Departments;
use App\Reviews;
use App\Visitors;
use App\review_questions;
use App\ReviewCategory;
use App\Invitations;
use App\InvitationBy;
use Illuminate\Support\Facades\Hash;
use File;
use DB;
use Storage;
use Response;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    public function admin_dashboard(Request $request) {

        //Visitor
        $visitorsArray[] = ['Date', 'Day', 'Week', 'Month'];
        for ($i=29; $i >=0 ; $i--) { 
            $value =  Carbon::now()->subDays($i);
            $day =  Carbon::parse($value)->format('l');
            if($day == 'Monday'){
                $visitorsArray[] = [
                    date_format(date_create($value),"M d"), 
                    $this->visiterDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                    $this->visiterWeekTotal($value),
                    $this->visiterMonthTotal((int)$value->year, (int)$value->month, (int)$value->day)
                ];
            } else {
                $visitorsArray[] = [
                    null, 
                    $this->visiterDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                    $this->visiterWeekTotal($value),
                    $this->visiterMonthTotal((int)$value->year, (int)$value->month, (int)$value->day)
                ];
            }
        }

        //Reviews
        $reviewArray[] = ['Date', 'Day', 'Week', 'Month'];
        for ($i=29; $i >=0 ; $i--) { 
            $value =  Carbon::now()->subDays($i);
            $day =  Carbon::parse($value)->format('l');
            if($day == 'Monday'){
                $reviewArray[] = [
                    date_format(date_create($value),"M d"), 
                    $this->reviewDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                    $this->reviewWeekTotal($value),
                    $this->reviewMonthTotal((int)$value->year, (int)$value->month, (int)$value->day)
                ];
            } else {
                $reviewArray[] = [
                    null, 
                    $this->reviewDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                    $this->reviewWeekTotal($value),
                    $this->reviewMonthTotal((int)$value->year, (int)$value->month, (int)$value->day)
                ];
            }
        }

        //SignUp Users
        $userArray[] = ['Date', 'Day', 'Week', 'Month'];
        for ($i=29; $i >=0 ; $i--) { 
            $value =  Carbon::now()->subDays($i);
            $day =  Carbon::parse($value)->format('l');
            if($day == 'Monday'){
               $userArray[] = [
                    date_format(date_create($value),"M d"), 
                    $this->signUpDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                    $this->signUpWeekTotal($value),
                    $this->signUpMonthTotal((int)$value->year, (int)$value->month, (int)$value->day)
                ];
            } else {
                $userArray[] = [
                    null, 
                    $this->signUpDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                    $this->signUpWeekTotal($value),
                    $this->signUpMonthTotal((int)$value->year, (int)$value->month, (int)$value->day)
                ];
            }
        }

        //Average Reviews Per User
        $avgUserReviewsArray[] = ['UID', 'Review Avg'];
        for ($i=29; $i >=0 ; $i--) { 
            $value =  Carbon::now()->subDays($i);
            $day =  Carbon::parse($value)->format('l');
            if($day == 'Monday'){
               $avgUserReviewsArray[] = [
                    date_format(date_create($value),"M d"), 
                    $this->avgDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                ];
            } else {
                $avgUserReviewsArray[] = [
                    null, 
                    $this->avgDayTotal((int)$value->year, (int)$value->month, (int)$value->day), 
                ];
            }
        }
        $sidebar = 'dashboard';
        return view('admin.dashboard',compact('sidebar','reviewArray','userArray','avgUserReviewsArray','visitorsArray'));
    }

    public function admin_logout(Request $request){
        Auth::guard('admin')->logout();
        toastr()->success('Logout Successfully!'); 
        return redirect('/admin');
    }

    public function admin_login(Request $request) {
        if(isset(Auth::guard('admin')->role) && Auth::guard('admin')->role == 1){
            return redirect('admin/dashboard');
        }
        if($request->isMethod('post')) {
            $postData = $request->all();
            $validatedData = $request->validate([
                'email' => 'required',
                'password' => 'required|min:6',
            ]);
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 1])) {
                return redirect('admin/dashboard');
            } else {
                return back()->withInput()->with('flash_message_error','Invalid login.');
            }
        } else {
            return view('admin.admin_login');
        }
    }

    public function show_review_model(Request $requestm,$id) {
        if($id){
            $review_data = Reviews::where('id',$id)->first();
            if($review_data->user_role == 2){
                $company = User::find($review_data->user_id);
                $review_data['name'] = $company->name;
            }

            if($review_data->user_role == 4){
               $manager = Managers::find($review_data->user_id);
               $review_data['name'] = $manager->first_name.' '.$manager->last_name;
               if(!empty($manager->department_id))
               {
                  $dep = Departments::find($manager->department_id);
                  $review_data['department_name'] = $dep->name;
               }
            }
            return view('users.user_review_model',compact('review_data'));
        }
    }

    public function download_visitor_report(Request $request){

        $fileName = 'visitor_report_'.time().'.csv';
        $baseUrl =  public_path('admin_data/reports/visitors/');
        $fullpath = $baseUrl.$fileName;
        $columns = array(
            'Date/Time', 
            'Ip Address', 
            'City', 
            'State', 
            'Country', 
            'Account Type', 
            'User Id',
            'Invitee ID',
            'Guest ID',
            'Profile ID',
            'Device Type' 
        );
        $file = fopen($fullpath, 'w');
        fputcsv($file, $columns);

        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);
        $visitors = Visitors::whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->get();
        if(count($visitors) > 0){
            foreach ($visitors as $visitor) {
                $row['date']  = $visitor->created_at;
                $row['ip_address'] = $visitor->ip_address;
                $row['city'] = null;
                $row['state'] = null;
                $row['country'] = null;
                if($visitor->location){
                    $locationData = json_decode($visitor->location);
                    $row['city'] = $locationData->city;
                    $row['state'] = $locationData->subdivision;
                    $row['country'] = $locationData->country;
                }

                $row['account_type'] = 'Visitor';
                if($visitor->invitation_id){
                    $row['account_type'] = 'Invitee';
                } else if($visitor->user_id){
                    $row['account_type'] = 'User';
                }

                $row['guest_id'] = null;
                $row['user_id'] = $visitor->user_id;
                $row['invitee_id'] = $visitor->invitation_id;
                if($visitor->invitation_id){
                    $invitations = Invitations::find($visitor->invitation_id);
                    if($invitations){
                        if($invitations->senByGuest()){
                            $row['guest_id'] = $invitations->invitation_by;
                        } else {
                            $row['invitee_id'] = $invitations->invitation_by;
                        }
                    }
                }

                
                $row['profile_id'] = null;

                $row['device_type'] = $visitor->device_type;
                

                fputcsv( $file, array(
                    $row['date'], 
                    $row['ip_address'], 
                    $row['city'], 
                    $row['state'], 
                    $row['country'], 
                    $row['account_type'], 
                    $row['user_id'], 
                    $row['invitee_id'], 
                    $row['guest_id'], 
                    $row['profile_id'], 
                    $row['device_type']) 
                );
            }
        }
        toastr()->success('File Generated Successfully!'); 
        return back()->with('visitor_fileName', $fileName);
    }

    public function download_review_report(Request $request){
        $questions = review_questions::where('status',0)->get();
        $ReviewCategory = ReviewCategory::get();
        $fileName = 'review_report_'.time().'.csv';
        $baseUrl =  public_path('admin_data/reports/review/');
        $fullpath = $baseUrl.$fileName;
        $columns = array(
            'Date / timestamp of review initiation', 
            'Date / timestamp of review submission ', 
            'Review ID', 
            'Reviewer User ID' , ///jisna diya ha
            'Reviewer First Name', 
            'Reviewer Last Name',
            'Review origination source',
            'User ID (Reviewee)',
            'Profile ID (Reviewee)',
            'Account Type (Reviewee)',
            'Reviewee First Name',
            'Reviewee Last Name',
            'Reviewee company name',
            'Currently working with reviewee?',
            'selected as?',
            'Reviewee Score Total'
        );
        $index = [];
        foreach($ReviewCategory as $category){
            if($category->question_count($category->id) > 0){
                foreach($questions as $question){
                    if($question->category_id == $category->id){
                        $index[] = $question->id;
                        $columns[$question->id] = "Reviewee ".$category->name.":-".$question->question;
                    }
                }
            }
        }
        $columns[] = 'Comment';
        $columns[] = 'Would you recommend working with Reviewee to a friend';

        $file = fopen($fullpath, 'w');
        fputcsv($file, $columns);

        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);
        $reviews = Reviews::where('fake','no')->whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->get();
        if(count($reviews) > 0){
            foreach ($reviews as $review) {
                $row['initiation_time']  = $review->initiate_time;
                $row['submission_time']  = $review->created_at;
                $row['review_id'] = $review->id;

                $reviewer_user = $review->customer($review->customer_id);
                if(!$reviewer_user) continue;
                $row['reviewer_user_id'] = $review->customer_id;
                $row['reviewer_first_name'] = $reviewer_user->name;
                $row['reviewer_last_name'] = $reviewer_user->last_name;

                $row['origination_source'] = $review->origination_source;


                $reviewee_user = $review->customer($review->user_id);
                if(!$reviewee_user) continue;     
                if(in_array($reviewee_user->type, ['Registerd','Invited'])){
                    $row['reviewee_account_type'] = 'User';
                    $row['reviewee_user_id'] = $review->user_id;
                    $row['reviewee_profile_id'] = null;
                } else {
                    $row['reviewee_account_type'] = 'Profile';
                    $row['reviewee_user_id'] = null;
                    $row['reviewee_profile_id'] = $review->user_id;
                }
                $row['reviewee_first_name'] = $reviewee_user->name;
                $row['reviewee_last_name'] = $reviewee_user->last_name;
                $row['reviewee_company'] = $reviewee_user->companyName($reviewee_user->company_id);


                if($review->currently_working_in_company){
                    $row['currently_working_in_company'] = 'Yes';
                } else {
                    $row['currently_working_in_company'] = 'No';
                }
                    
                $row['selected_as'] = $review->working_as;

                $row['score_Total'] = $review->avg_review;
                $row['comment'] = $review->comment;

                if($review->recommend_working_with){
                    $row['recommend_working_with'] = 'Yes';
                } else {
                    $row['recommend_working_with'] = 'No';
                }

                $review_value = get_object_vars(json_decode($review->review_value));
                $insertData = array(
                    $row['initiation_time'], 
                    $row['submission_time'], 
                    $row['review_id'], 
                    $row['reviewer_user_id'], 
                    $row['reviewer_first_name'], 
                    $row['reviewer_last_name'],
                    $row['origination_source'],
                    $row['reviewee_user_id'],
                    $row['reviewee_profile_id'],
                    $row['reviewee_account_type'],
                    $row['reviewee_first_name'],
                    $row['reviewee_last_name'],
                    $row['reviewee_company'],
                    $row['currently_working_in_company'],
                    $row['selected_as'],
                    $row['score_Total'],
                );
                foreach ($index as $key => $value) {
                    if (array_key_exists($value, $review_value)){
                        $insertData[] = $review_value[$value];
                    } else {
                        $insertData[] = null;
                    }
                }
                $insertData[] = $row['comment'];
                $insertData[] = $row['recommend_working_with'];
                fputcsv( $file, $insertData  );
            }
        }
        toastr()->success('File Generated Successfully!'); 
        return back()->with('review_fileName', $fileName);
    }

    public function download_signup_user_report(Request $request){

        $fileName = 'signup_user_report_'.time().'.csv';
        $baseUrl =  public_path('admin_data/reports/signup_user/');
        $fullpath = $baseUrl.$fileName;
        $columns = array(
            'Date / timestamp', 
            'IP Address', 
            'City', 
            'State', 
            'Country', 
            'User ID' ,
            'Invitee ID' ,
            'Profile ID' ,
            'Guest ID' ,
            'Inviter ID' ,
            'Account Type', 
            'Account Origin', 
            'Device type'
        );

        $file = fopen($fullpath, 'w');
        fputcsv($file, $columns);

        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);
        $account_type = $request->account_type;
        $type = [];
        if(in_array('user', $account_type)){
            $type[] = 'Registerd';
            $type[] = 'Invited';
        }
        if(in_array('profile', $account_type)){
            $type[] = 'Imported';
            $type[] = 'CreatedByUser';
            $type[] = 'ProfileCreatedByAdmin';
        }
        $users = User::WhereIn('type', $type)->whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->skip($request->from)->take($request->to)->get();
        if(count($users) > 0){
            foreach ($users as $user) {
                $row['created_at']  = $user->created_at;
                $row['ip_address'] = $user->ip_address;
                $row['city'] = null;
                $row['state'] = null;
                $row['country'] = null;
                if($user->location){
                    $locationData = json_decode($user->location);
                    $row['city'] = $locationData->city;
                    $row['state'] = $locationData->subdivision;
                    $row['country'] = $locationData->country;
                }
                $row['user_id'] = null;
                $row['invitee_id'] = null;
                $row['inviter_id'] = null;
                $row['guest_id'] = null;
                $row['profile_id'] = null;

                if(in_array($user->type, ['Invited', 'Registerd']) ){
                    $row['account_type'] = 'User';
                } else {
                    $row['account_type'] = 'Profile';
                }
                
                if($user->type == 'Invited'){
                    $row['account_origin'] = 'Referral';                    
                    $inviData = Invitations::find($user->invitation_id);
                    if($inviData){
                        $row['user_id'] = $user->id;
                        $row['invitee_id'] = $inviData->id;
                        if($inviData->send_by){
                            $row['inviter_id'] = $inviData->send_by;
                        } else {
                            $row['guest_id'] = $inviData->invitation_by;
                        }
                        
                    }
                } else if($user->type == 'Registerd'){
                    $row['account_origin'] = 'Sign up';
                    $row['user_id'] = $user->id;
                } else if($user->type == 'CreatedByUser'){
                    $row['account_origin'] = 'User entry';
                    $row['profile_id'] = $user->id;
                } else {
                    $row['account_origin'] = 'Admin entry';
                    $row['profile_id'] = $user->id;
                }

                if($user->account_origin){
                    $row['account_origin'] = $user->account_origin;
                }

                $row['device_type'] = $user->device_type;
                
                fputcsv( $file, array(
                    $row['created_at'], 
                    $row['ip_address'], 
                    $row['city'], 
                    $row['state'], 
                    $row['country'],
                    $row['user_id'], 
                    $row['invitee_id'], 
                    $row['profile_id'], 
                    $row['guest_id'], 
                    $row['inviter_id'], 
                    $row['account_type'], 
                    $row['account_origin'], 
                    $row['device_type']
                ));
            }
        }
        toastr()->success('File Generated Successfully!'); 
        return back()->with('signup_user_fileName', $fileName);
    }

    public function download_referrals_report(Request $request){

        $fileName = 'referral_report_'.time().'.csv';
        $baseUrl =  public_path('admin_data/reports/referrals/');
        $fullpath = $baseUrl.$fileName;
        $columns = array(
            'User ID (Referrer)', 
            'Invitee ID (Referrer)', 
            'Guest ID (Referrer)', 
            'Account Type (Referrer)', 
            'First Name (Referrer)', 
            'Last Name (Referrer)', 
            'Company (Referrer)', 
            'Invitee ID (Invitee)', 
            'User ID (Invitee)', 
            'Account Type (Invitee)', 
            'First Name (Invitee)', 
            'Last Name (Invitee)' ,
            'Company (Invitee)', 
            'Email (Invitee)',
            'Referral sent date',
            'Activation',
            'Referral Activation date',
        );

        $file = fopen($fullpath, 'w');
        fputcsv($file, $columns);

        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);
        $invitations = Invitations::where('account_origin', 'Invite friend')->whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->get();
        if(count($invitations) > 0){
            foreach ($invitations as $invitation) {

                $row['user_id']  = null;
                $row['invitee_id_refrel']  = null;
                $row['guest_id']  = null;

                $referralData = User::find($invitation->send_by);
                if($referralData){
                    if(in_array($referralData->type, ['Registerd'])){
                        $row['refrer_account_type']  = 'User';
                        $row['user_id'] = $referralData->id;
                    }
                    if(in_array($referralData->type, ['CreatedByUser','ProfileCreatedByAdmin','Imported','UserCreatedByAdmin'])){
                        $row['refrer_account_type']  = 'Profile';
                    }

                    if(in_array($referralData->type, ['Invited'])){
                        $row['refrer_account_type']  = 'User';
                        $row['user_id'] = $referralData->id;
                        //$row['invitee_id_refrel'] = $referralData->id;
                    }

                    $row['referral_f_n'] = $referralData->name;
                    $row['referral_l_n'] = $referralData->last_name;
                    if($comanyData = Company::find($referralData->company_id)){
                        $row['referral_company'] = $comanyData->company_name;
                    } else {
                        $row['referral_company'] = null;
                    }
                } else {
                    $row['refrer_account_type']  = 'Guest';
                    $row['referral_f_n'] = $invitation->sender_name;
                    $row['referral_l_n'] = null;
                    $row['referral_company'] = null;
                    $row['guest_id']  = $invitation->id;
                }
                $inviteeData = User::where('invitation_id', $invitation->id)->orderBy('id','DESC')->first();
                if($inviteeData){
                    $row['invitee_id'] = $invitation->id;
                    $row['invitee_user_id'] = $inviteeData->id;
                    $row['account_type'] = 'User';
                    $row['invitee_f_n'] = $inviteeData->name;
                    $row['invitee_l_n'] = $inviteeData->last_name;
                    if($comanyData = Company::find($inviteeData->company_id)){
                        $row['invitee_company'] = $comanyData->company_name;
                    } else {
                        $row['invitee_company'] = null;
                    }
                    $row['invitee_email'] = $inviteeData->email;
                    $row['activation'] = 'Yes';
                    $row['activation_time'] = $inviteeData->created_at;
                } else {
                    $row['invitee_id'] = $invitation->id;
                    $row['invitee_user_id'] = null;
                    $row['account_type'] = 'Invitee';
                    $row['invitee_f_n'] = $invitation->receiver_name;
                    $row['invitee_l_n'] = $invitation->receiver_last_name;;
                    $row['invitee_company'] = null;
                    $row['invitee_email'] = $invitation->receiver_email;
                    $row['activation'] = 'No';
                    $row['activation_time'] = null;
                }
                
                
                $row['created_at'] = $invitation->created_at;
                  
                fputcsv( $file, array(
                    $row['user_id'], 
                    $row['invitee_id_refrel'], 
                    $row['guest_id'], 
                    $row['refrer_account_type'], 
                    $row['referral_f_n'], 
                    $row['referral_l_n'], 
                    $row['referral_company'], 
                    $row['invitee_id'], 
                    $row['invitee_user_id'], 
                    $row['account_type'], 
                    $row['invitee_f_n'],
                    $row['invitee_l_n'],
                    $row['invitee_company'],
                    $row['invitee_email'],
                    $row['created_at'],
                    $row['activation'],
                    $row['activation_time'],
                ));
            }
        }
        toastr()->success('File Generated Successfully!'); 
        return back()->with('referrals_fileName', $fileName);
    }

    public function download_review_per_user_report(Request $request){

        $fileName = 'summary_report_'.time().'.csv';
        $baseUrl =  public_path('admin_data/reports/review_per_user/');
        $fullpath = $baseUrl.$fileName;
        $columns = array(
            'Account Type', 
            'User ID', 
            'Invitee ID', 
            'Guest ID', 
            'Profile ID', 
            'Inviter ID', 
            'Account Origin', 
            'Referrer ID', 
            'First Name', 
            'Last Name', 
            'Email', 
            'Phone' ,
            'Company', 
            'Industry',
            'Department',
            'Job Title',
            'Sign-up date / timestamp',
            'Most recent "session" date / timestamp',
            '# Sessions?',
            '# Reviews submitted',
            '# of Reviews submitted on profiles same company, different department',
            '# of Reviews submitted on profiles in different company (any department)',
            '# Reviews received',
            '# unique profiles reviewed',
            'Avg. submitted review Score',
            '# New Profiles Added',
            '# New Companies Added', //Not able to add
            '# Referrals sent',
            '# Activated Referrals',
        );

        $file = fopen($fullpath, 'w');
        fputcsv($file, $columns);

        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);

        $account_type = $request->account_type;
        $type = [];
        if(in_array('user', $account_type)){
            $type[] = 'Registerd';
            $type[] = 'Invited';
            $type[] = 'UserCreatedByAdmin';
        }

        if(in_array('profile', $account_type)){
            $type[] = 'Imported';
            $type[] = 'CreatedByUser';
            $type[] = 'ProfileCreatedByAdmin';
            
        }

        $insertCsvData = [];
        $totalInsertCount = $request->to - $request->from;
        

        if(in_array('user', $account_type) || in_array('profile', $account_type)){
            $fetchCount = $totalInsertCount - count($insertCsvData);
            $users = User::WhereIn('type', $type)->whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->skip($request->from)->take($fetchCount)->get();
            if(count($users) > 0){
                foreach ($users as $user) {

                    $row['account_type']  = 'User';

                    $row['user_id']  = null;
                    $row['invitee_id']  = null;
                    $row['guest_id']  = null;
                    $row['profile_id']  = null;
                    $row['inviter_id']  = null;

                    if(in_array($user->type, ['Registerd','UserCreatedByAdmin'])){
                        $row['account_type']  = 'User';
                        $row['user_id']  = $user->id;
                    }
                    if(in_array($user->type, ['CreatedByUser','ProfileCreatedByAdmin','Imported'])){
                        $row['account_type']  = 'Profile';
                        $row['profile_id']  = $user->id;
                    }
                    if(in_array($user->type, ['Invited'])){
                        $row['account_type']  = 'User';
                        $row['user_id']  = $user->id;
                        $row['invitee_id']  = $user->invitation_id;
                        $invityData = Invitations::find($user->invitation_id);
                        if($invityData){
                            $row['invitee_id']  = $invityData->id;
                            if($invityData->senByGuest()){
                                $row['guest_id'] = $invityData->invitation_by;
                            } else {
                                $row['inviter_id']  = $invityData->send_by;
                            }
                            
                        }
                    }

                    if($user->type == 'Registerd'){
                        $row['account_origin'] = 'Sign up';
                    } else if($user->type == 'Invited'){
                        $row['account_origin'] = 'Referral';
                    } else if($user->type == 'CreatedByUser'){
                        $row['account_origin'] = 'User entry';
                    } else {
                        $row['account_origin'] = 'Admin entry';
                    }
                    if($user->account_origin){
                        $row['account_origin'] = $user->account_origin;
                    }

                    $row['referrer_id']  = null;

                    $row['user_f_n']  = $user->name;
                    $row['user_l_n']  = $user->last_name;
                    $row['email']  = $user->email;
                    $row['phone']  = $user->phone;
                    $row['company']  = null;
                    $row['industry']  = null;
                    if($comanyData = Company::find($user->company_id)){
                        $row['company'] = $comanyData->company_name;
                        $row['industry'] = $comanyData->comp_type($comanyData->company_type);
                    }
                    $row['department']  = $user->departmentName();
                    $row['job_title']  = $user->job_title;
                    $row['signup_date']  = $user->created_at;
                    $row['recent_session']  = $user->last_login_at;
                    $row['session_count']  = $user->login_count;
                    $row['number_of_review_submited']  = Reviews::where('customer_id', $user->id)->count();
                    $row['number_of_review_recieved']  = Reviews::where('user_id', $user->id)->count();
                    $row['number_of_review_same_company_different_department']  = Reviews::where('customer_id', $user->id)->where('company_id', $user->company_id)->where('department_id', '!=', $user->department_id)->count();
                    $row['number_of_review_different_company']  = Reviews::where('customer_id', $user->id)->where('company_id', '!=', $user->company_id)->count();
                    $row['unique_profiles_reviewed']  = Reviews::where('customer_id', $user->id)->distinct('user_id')->count();

                    $review = Reviews::where('customer_id', $user->id)->avg('avg_review');
                    $row['Avg_submitted_review_Score']  = number_format((float)$review, 2, '.', '');
                    $row['New_Profiles_Added']  = User::where('created_by', $user->id)->count();
                    $row['New_company_Added']  = Invitations::where(['send_by' => $user->id, 'account_origin' =>'Add your company'])->count();;
                    $row['Referrals_sent']  = Invitations::where(['send_by' => $user->id, 'account_origin' => 'Invite friend'])->count();
                    $refIds  = Invitations::where(['send_by' => $user->id, 'account_origin' => 'Invite friend'])->pluck('id');
                    $row['Activated_Referrals']  = User::whereIn('invitation_id', $refIds)->count();;
           
                    $insertCsvData[] = array(
                        $row['account_type'], 
                        $row['user_id'], 
                        $row['invitee_id'], 
                        $row['guest_id'], 
                        $row['profile_id'], 
                        $row['inviter_id'], 
                        $row['account_origin'], 
                        $row['referrer_id'], 
                        $row['user_f_n'], 
                        $row['user_l_n'], 
                        $row['email'],
                        $row['phone'],
                        $row['company'],
                        $row['industry'],
                        $row['department'],
                        $row['job_title'],
                        $row['signup_date'],
                        $row['recent_session'],
                        $row['session_count'],
                        $row['number_of_review_submited'],
                        $row['number_of_review_same_company_different_department'],
                        $row['number_of_review_different_company'],
                        $row['number_of_review_recieved'],
                        $row['unique_profiles_reviewed'],
                        $row['Avg_submitted_review_Score'],
                        $row['New_Profiles_Added'],
                        $row['New_company_Added'],
                        $row['Referrals_sent'],
                        $row['Activated_Referrals'],
                    );
                }
            }
        }

        if(in_array('invitee', $account_type) && count($insertCsvData) < $totalInsertCount){
            $fetchCount = $totalInsertCount - count($insertCsvData);
            $invitations = Invitations::where('account_origin', 'Invite friend')->whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->skip($request->from)->take($fetchCount)->get();
            if(count($invitations) > 0){
                foreach ($invitations as $invitation) {
                     $user = User::where('invitation_id', $invitation->id)->orderBy('id', 'DESC')->first();
                     if(!$user){
                        if($invitation->send_by){
                            $inviteBy = $invitation->send_by;
                        } else {
                            $inviteBy = $invitation->invitation_by;
                        }
                        $insertCsvData[] = array(
                            'Invitee', 
                            null, 
                            $invitation->id, 
                            null, 
                            null, 
                            $inviteBy, 
                            'Referral', 
                            $inviteBy, 
                            $invitation->receiver_name, 
                            $invitation->receiver_last_name,
                            $invitation->receiver_email,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            $invitation->created_at,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                        );
                    }
                }
            }
        }

        if(in_array('visitor', $account_type) && count($insertCsvData) < $totalInsertCount){
            $fetchCount = $totalInsertCount - count($insertCsvData);
            $visitors = Visitors::whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->skip($request->from)->take($fetchCount)->get();
            if(count($visitors) > 0){
                foreach ($visitors as $visitor) {
                    $insertCsvData[] = array(
                        'Visitor', 
                        null, 
                        null, 
                        null, 
                        null, 
                        null, 
                        null, 
                        null, 
                        null, 
                        null, 
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $visitor->created_at,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                    );
                }
            }
        }
        if(in_array('guest', $account_type) && count($insertCsvData) < $totalInsertCount){
            $fetchCount = $totalInsertCount - count($insertCsvData);
            $guests = InvitationBy::whereIn('type',['Guest'])->whereBetween('created_at', [(string)$startDate->startOfDay(), (string)$endDate->endOfDay()])->orderBy('created_at', 'DESC')->skip($request->from)->take($fetchCount)->get();
            if(count($guests) > 0){
                foreach ($guests as $guest) {

                    $insertCsvData[] = array(
                        'Guest', 
                        null, 
                        null, 
                        $guest->id, 
                        null, 
                        null, 
                        $guest->accountOrigin(), 
                        null, 
                        null,  
                       	null, 
                        $guest->senderEmail(),
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $guest->created_at,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                    );
                }
            }
        }
        $countData = 0;
        foreach ($insertCsvData as $key => $value) {
            //if($countData >= $request->from && $countData < $request->to){
                fputcsv( $file, $value);
            //} 
            //if($countData > $request->to) break;
            $countData++;
        }
        toastr()->success('File Generated Successfully!'); 
        return back()->with('review_per_user_fileName', $fileName);
    }

    public function visiterMonthTotal($year, $month, $day){
        return  Visitors::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '<=', $day)->count();
    }

    public function visiterDayTotal($year, $month, $day){
        return  Visitors::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->count();
    }

    public function visiterWeekTotal($created_at){
        $date = new Carbon($created_at);
        $date1 = new Carbon($created_at);
        return  Visitors::whereBetween('created_at', [(string)$date->startOfWeek()->startOfDay(), (string)$date1->endOfDay()])->count();
    }



    public function reviewMonthTotal($year, $month, $day){
        return  Reviews::where('fake','no')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '<=', $day)->count();
    }

    public function reviewDayTotal($year, $month, $day){
        return  Reviews::where('fake','no')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->count();
    }

    public function reviewWeekTotal($created_at){
        $date = new Carbon($created_at);
        $date1 = new Carbon($created_at);
        return  Reviews::where('fake','no')->whereBetween('created_at', [(string)$date->startOfWeek(), (string)$date1->endOfDay()])->count();
    }


    public function signUpMonthTotal($year, $month, $day){
        return  User::where("type",'Registerd')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '<=', $day)->count();
    }

    public function signUpDayTotal($year, $month, $day){
        return  User::where("type",'Registerd')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->count();
    }
    public function signUpWeekTotal($created_at){
        $date = new Carbon($created_at);
        $date1 = new Carbon($created_at);
        return  User::where("type",'Registerd')->whereBetween('created_at', [(string)$date->startOfWeek(), (string)$date1->endOfDay()])->count();
    }

    public function avgDayTotal($year, $month, $day){
        $todayTotalCount =   Reviews::where('fake','no')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '<=', $day)->count();
        if($todayTotalCount) {
            $userCount =   User::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '<=', $day)->whereIn('type',['Registerd', 'Invited', 'UserCreatedByAdmin'])->count();
            $data = $todayTotalCount / $userCount;
            return $data;
        }
        return 0;
    }
}
