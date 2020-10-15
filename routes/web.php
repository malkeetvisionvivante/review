<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Seprate;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('google', function () { return view('googleAuth'); });
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::get('/social-signup-match-google/{id}', 'Auth\SocialMatchController@googleMatchUser');
Route::get('/social-signup-match-facebook/{id}', 'Auth\SocialMatchController@facebookMatchUser');
Route::get('/social-signup-match-linkedin/{id}', 'Auth\SocialMatchController@linkedinMatchUser');

Route::get('facebookpage', function () { return view('facebookpage'); });
Route::get('auth/facebook', 'Auth\FacebookloginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\FacebookloginController@handleFacebookCallback');

Route::get('linkedin', function () { return view('loginlinkedin'); });
Route::get('/auth/linkedin', 'Auth\SocialAuthLinkedinController@redirect');
Route::get('/auth/linkedin/callback', 'Auth\SocialAuthLinkedinController@callback');

/* Home Page */
Route::get('/', function () { 
	if(Auth::check()){
		return redirect('/reviews'); 
	} else {
		return redirect('/home'); 
	}
});
// Route::get('/home', function () { 
// 	if(Auth::check()){
// 		return redirect('/reviews'); 
// 	} else {
// 		return redirect('/home'); 
// 	}
// });
Route::get('/home','Frontend\HomeController@home_view')->middleware('seprate');

/* frontend User */
Route::middleware(['seprate'])->group(function (){
	/* Login, Signup, Profile */
	Route::get('/sign-up','Frontend\UserController@sign_up');
	Route::get('/login-user','Frontend\UserController@login_view');
	Route::post('/login-user','Frontend\UserController@login_user');
	Route::get('/logout-user','Frontend\UserController@logout_user')->name('logout');
	Route::post('/signup-user','Frontend\UserController@signup_user');
	Route::post('/find-existing-users','Frontend\ManagerController@find_existing_users');
	Route::post('/save-existing-users','Frontend\ManagerController@save_existing_users');
	Route::get('/my-profile','Frontend\UserController@my_profile');
	Route::get('/referal-detail','Frontend\ReferalController@my_referal');
	Route::get('/referal-by/{id}','Frontend\ReferalController@referal_by');
	Route::get('/my-reviews','Frontend\UserController@my_reviews');
	Route::get('/invite-link/{id}','Frontend\ReferalController@invite_link');
	Route::get('/change-password','Frontend\UserController@change_password_view');
	Route::post('/user/update-password','Frontend\UserController@update_password');
	Route::post('/user/update-my-profile','Frontend\UserController@update_profile');

	Route::match(['get','post'],'/get-user-review-model/{id}','Frontend\UserController@show_review_model');
	Route::match(['get','post'],'/edit-user-review-model/{id}','Frontend\UserController@edit_review_model');
	Route::match(['get','post'],'/company-list-user','Frontend\UserController@company_list');
	Route::match(['get','post'],'/manager-list-user','Frontend\UserController@manager_list');
	Route::match(['get','post'],'/manager-list/{companyId}/{departmantId}','Frontend\ManagerController@manager_list')->name('Department Page');
	
	Route::match(['get','post'],'/department-list-user','Frontend\UserController@department_list');
	Route::match(['get','post'],'/department-detail-user/{id}','Frontend\UserController@department_detail');
	Route::match(['get','post'],'/add-review-user/{id}/{manager_id?}','Frontend\UserController@add_review');
	Route::match(['get','post'],'/thank-you/{company_id}/{manager_id}','Frontend\UserController@thank_you_view')->name('Thank You Page');
	Route::match(['get','post'],'/get_manager/review/{id}/{company_id}','Frontend\UserController@review_manager_list');
	Route::match(['get','post'],'/get_question/review','Frontend\UserController@review_question_list');
	Route::match(['get','post'],'/get_user_detail/review','Frontend\UserController@review_get_user_detail');
	Route::match(['get','post'],'/submit_review','Frontend\UserController@submit_review');
	Route::match(['get','post'],'/edit/review/{id}','Frontend\UserController@edit_review');
	Route::match(['get','post'],'/search/results','Frontend\SearchController@search_results');
	Route::match(['get','post'],'/reviews','Frontend\UserController@reviews');
	Route::match(['get','post'],'/manager-review-user/{id}','Frontend\UserController@manager_review_view');
	Route::match(['get','post'],'/submit_review_manager/{id}','Frontend\UserController@submit_review_manager');
	Route::match(['get','post'],'/check_user/review/{id}','Frontend\UserController@check_review_user');
	Route::match(['get','post'],'/add-manager-for-review','Frontend\UserController@add_manager_for_review');
	Route::match(['get','post'],'/add-manager-for-manager-list','Frontend\UserController@add_manager_for_manager_list');
	Route::match(['get','post'],'/add-manager-from-search-page','Frontend\SearchController@add_manager_from_search_page');
	Route::match(['get','post'],'/add-colleague-from-search-match/{id}','Frontend\SearchController@add_colleague_from_search_match');
	Route::match(['get','post'],'/add-department-for-review','Frontend\UserController@add_department_for_review');

	Route::match(['get','post'],'/mission-update-company','Frontend\ManagerController@mission_update_company')->name('Mission End');
	Route::match(['get','post'],'/mission-end','Frontend\ManagerController@mission_end')->name('Mission End');
	Route::match(['get','post'],'/mission-step/{step}','Frontend\ManagerController@mission_step')->name('Mission End');
	Route::match(['get','post'],'/manager-detail/{id}','Frontend\ManagerController@manager_detail')->name('Manager Page');
	Route::match(['get','post'],'/manager-graph/{id}','Frontend\ManagerController@manager_graph');
	Route::match(['get','post'],'/company-detail/{id}','Frontend\CompanyController@company_detail')->name('Company Page');
	Route::match(['get','post'],'/department-detail/{id}','Frontend\DepartmentController@department_detail');

	Route::match(['get','post'],'/manager-detail-google','Frontend\ManagerController@redirect_google');
	Route::match(['get','post'],'/manager-detail-facebook','Frontend\ManagerController@redirect_facebook');
	Route::match(['get','post'],'/manager-detail-linkedin','Frontend\ManagerController@redirect_linkedin');
	Route::match(['get','post'],'/manager-detail-signup-user-exist','Frontend\ManagerController@signup_user_exist');
	Route::match(['get','post'],'/manager-detail-user-login','Frontend\ManagerController@login_user');
	Route::match(['get','post'],'/manager-detail-user-signup','Frontend\ManagerController@signup_user');
	Route::match(['get','post'],'/manger-signup-match/{id}','Frontend\ManagerController@signup_user_create');

	Route::match(['get','post'],'/review/like/{id}','Frontend\ReviewController@like');
	Route::match(['get','post'],'/review/remove-like/{id}','Frontend\ReviewController@remove_like');
	Route::match(['get','post'],'/review/dislike/{id}','Frontend\ReviewController@dislike');
	Route::match(['get','post'],'/review/remove-dislike/{id}','Frontend\ReviewController@remove_dislike');
});

Route::match(['get','post'],'/load_companies','Frontend\UserController@loadCompanies');
Route::match(['get','post'],'/load_managers','Frontend\UserController@loadManagers');
Route::match(['get','post'],'/load_departments','Frontend\UserController@loadDepartments');
Route::match(['get','post'],'/load-titles','Frontend\UserController@loadTitles');
Route::match(['get','post'],'/load-company-list','Frontend\UserController@loadCompanyList');


/* Frontend static pages */
Route::get('/import-compnay','Frontend\ImportController@company');
Route::get('/about-us','Frontend\StaticPageController@aboutus_view');
Route::get('/careers','Frontend\StaticPageController@careerss_view');
Route::get('/help','Frontend\StaticPageController@help_view');
Route::get('/let-us-know','Frontend\StaticPageController@let_us_know_view');
Route::get('/press','Frontend\StaticPageController@press_view');
Route::get('/register-your-company','Frontend\StaticPageController@register_your_company_view');
Route::get('/user-agreement','Frontend\StaticPageController@user_agreement_view');
Route::get('/other-policies','Frontend\StaticPageController@other_policies_view');
Route::get('/privacy-policy','Frontend\StaticPageController@privacy_policy_view');
Route::get('/cookie-policy','Frontend\StaticPageController@cookie_policy_view');
Route::get('/terms-conditions','Frontend\StaticPageController@terms_conditions_view');
 
/* Email sends */
Route::post('/careers/info/send','Frontend\EmailController@careers_info');
Route::post('/help/info/send','Frontend\EmailController@help');
Route::post('/let-us-know/info/send','Frontend\EmailController@help_us_know');
Route::post('/add/company/send','Frontend\EmailController@add_company');
Route::match(['get','post'],'/invite/friends','Frontend\EmailController@invite_friends');
Route::match(['get','post'],'/invite/invite_friends_email','Frontend\EmailController@invite_friends_email');

/* bookmarks */
Route::match(['get'],'/bookmarks/perform/{managerid}','Frontend\BookmarksController@perform');

/*  company routes */
Route::match(['get','post'],'/company/dashboard/','Company_dashboard@company_dashboard');
Route::match(['get','post'],'/my/data/update/company','Company_dashboard@update_company');
Route::match(['get','post'],'/company/managers/list','Company_dashboard@manager_list');
Route::match(['get','post'],'/company/change_status/manager/{id}','Company_dashboard@manager_status_change');
Route::match(['get','post'],'/company/delete/manager/{id}','Company_dashboard@delete_manager');
Route::match(['get','post'],'/company/add/manager','Company_dashboard@company_add_manager');
Route::match(['get','post'],'/company/get_data_manager/{id}','Company_dashboard@manager_data');
Route::match(['get','post'],'/company/update/manager/{id}','Company_dashboard@update_manager');
Route::match(['get','post'],'/company/department/list','Company_dashboard@department_list');
Route::match(['get','post'],'/company/add/newdepartment','Company_dashboard@add_newdepartment');
Route::match(['get','post'],'/company/get_data_department/{id}','Company_dashboard@get_data_department');
Route::match(['get','post'],'/company/update/department/{id}','Company_dashboard@update_department');
Route::match(['get','post'],'/company/change_status/dept/{id}','Company_dashboard@change_status_dep');
Route::match(['get','post'],'/company/delete/dept/{id}','Company_dashboard@delete_dep');
Route::match(['get','post'],'/company/review/list','Company_dashboard@company_reviews');
Route::match(['get','post'],'/company/get-user-review-model/{id}','Company_dashboard@show_review_model');

/* notifications */
Route::match(['get','post'],'/notifications','Frontend\notificationController@notifications');

/* Auth */
Auth::routes();

/* Admin Dashboard And Login */
Route::get('/admin', function () { return redirect('/admin/dashboard'); });
Route::match(['get','post'],'/admin/login','Admin\DashboardController@admin_login')->name('admin.login');
Route::match(['get','post'],'/admin/logout','Admin\DashboardController@admin_logout')->name('admin.logout');
Route::match(['get','post'],'/admin/dashboard','Admin\DashboardController@admin_dashboard');
Route::match(['get','post'],'/admin/download-visitor-report','Admin\DashboardController@download_visitor_report');
Route::match(['get','post'],'/admin/download-review-report','Admin\DashboardController@download_review_report');
Route::match(['get','post'],'/admin/download-signup-user-report','Admin\DashboardController@download_signup_user_report');
Route::match(['get','post'],'/admin/download-referrals-report','Admin\DashboardController@download_referrals_report');
Route::match(['get','post'],'/admin/download-review-per-user-report','Admin\DashboardController@download_review_per_user_report');

/* setting */
Route::match(['get'],'/admin/setting','Admin\SettingController@view');
Route::match(['post'],'/admin/setting/update','Admin\SettingController@update');

/* Admin Profile */
Route::match(['get'],'/admin/profile','Admin\ProfileController@view');
Route::match(['post'],'/admin/profile/update','Admin\ProfileController@update');

/* Admin Email */
Route::match(['get'],'/admin/email','Admin\EmailController@index');
Route::match(['get'],'/admin/email/edit/{id}','Admin\EmailController@edit');
Route::match(['post'],'/admin/email/edit/{id}','Admin\EmailController@edit');
Route::match(['post'],'/admin/email/upload','Admin\EmailController@upload');
Route::match(['post'],'/admin/email/testemail','Admin\EmailController@testemail');

/* Admin notifications notifications */
Route::match(['get','post'],'admin/notifications/','Admin\NotificationController@notification_list');
Route::match(['get','post'],'admin/notifications/list','Admin\NotificationController@notification_list');
Route::match(['get','post'],'admin/notifications/detail/{id}','Admin\NotificationController@notification_detail');
Route::match(['get','post'],'admin/change_notification/status','Admin\NotificationController@change_status');

/* Department */
Route::match(['get','post'],'admin/department/list','Admin\DepartmentController@department_list');
Route::match(['get','post'],'admin/department/detail/{id}','Admin\DepartmentController@department_detail');
Route::match(['get','post'],'/get_data_department/{id}','Admin\DepartmentController@get_deparment');
Route::match(['get','post'],'admin/add/department','Admin\DepartmentController@add_department');
Route::match(['get','post'],'admin/add/newdepartment','Admin\DepartmentController@add_newdepartment');
Route::match(['get','post'],'/admin/update/department/{id}','Admin\DepartmentController@update_department');
Route::match(['get','post'],'/admin/delete/dept/{id}','Admin\DepartmentController@delete_department');

/* company */
Route::match(['get','post'],'admin/company/list','Admin\CompanyController@company_list');
Route::match(['get','post'],'/admin/company/detail/{id}','Admin\CompanyController@company_detail');
Route::match(['get','post'],'admin/add/company','Admin\CompanyController@add_company');
Route::match(['get','post'],'admin/edit/company/{id}','Admin\CompanyController@edit_company');
Route::match(['get','post'],'admin/update/company/{id}','Admin\CompanyController@update_company');
Route::match(['get','post'],'/admin/delete/comp/{id}','Admin\CompanyController@delete_company');


/* manager */
Route::match(['get','post'],'admin/add/manager','Admin\ManagerController@add_manager');
Route::match(['get','post'],'admin/check/manager/email','Admin\ManagerController@checkEmail');
Route::match(['get','post'],'/get_data_manager/{id}','Admin\ManagerController@manager_data');
Route::match(['get','post'],'/admin/update/manager/{id}','Admin\ManagerController@update_manager');
Route::match(['get','post'],'/admin/delete/manager/{id}','Admin\ManagerController@delete_manager');
Route::match(['get','post'],'/admin/recover/manager/{id}','Admin\ManagerController@recover_manager');
Route::match(['get','post'],'/get/dep/manager/{id}','Admin\ManagerController@manager_list_by_dep');
Route::match(['get','post'],'/get/company/dep/manager/{id}/{company_id}','Admin\ManagerController@manager_list_by_company_dep');
Route::match(['get','post'],'/company/manager/review/{id}','Admin\ManagerController@review_data');

/* user */
//Route::post('user/home','UserController@user_signup');
Route::match(['get','post'],'/admin/users/list','Admin\UserController@users_list');
Route::match(['get','post'],'/admin/profile/users/list','Admin\ProfileUserController@users_list');
Route::match(['get','post'],'/admin/add/users','Admin\UserController@add_users');
Route::match(['get','post'],'/admin/profile/add/users','Admin\ProfileUserController@add_users');
Route::match(['get','post'],'/admin/edit/users/{id}','Admin\UserController@edit_user');
Route::match(['get','post'],'/admin/banned/users/{id}','Admin\UserController@banned_user');
Route::match(['get','post'],'/admin/profile/edit/users/{id}','Admin\ProfileUserController@edit_user');
Route::match(['get','post'],'/admin/delete/user/{id}','Admin\UserController@delete_user');
Route::match(['get','post'],'/admin/recover/user/{id}','Admin\UserController@recover_user');

Route::match(['get','post'],'/admin/delete/profile/{id}','Admin\UserController@delete_profile');
Route::match(['get','post'],'/admin/recover/profile/{id}','Admin\UserController@recover_profile');	

Route::match(['get','post'],'/admin/profile/delete/user/{id}','Admin\ProfileUserController@delete_user');
Route::match(['get','post'],'/admin/users/detail/{id}/{as?}','Admin\UserController@users_detail');
Route::match(['get','post'],'/admin/users/remove-single-review','Admin\UserController@removeSingleReview');
Route::match(['get','post'],'/admin/profile/users/detail/{id}/{as?}','Admin\ProfileUserController@users_detail');
Route::match(['get','post'],'/admin/profile/users/remove-profile-single-review','Admin\ProfileUserController@removeProfileSingleReview');
Route::match(['get','post'],'/admin/profile/users/hide-review-comment','Admin\ProfileUserController@hideReviewComment');
Route::match(['get','post'],'/admin/users/hide-review-comment','Admin\UserController@hideReviewComment');
Route::match(['get','post'],'/admin/profile/users/hide-review','Admin\ProfileUserController@hideReview');
Route::match(['get','post'],'/admin/users/hide-review','Admin\UserController@hideReview');

/* review Question */
Route::match(['get'],'/admin/review-question/list','Admin\ReviewQuestionController@list_view');
Route::match(['post'],'/admin/review-question/add','Admin\ReviewQuestionController@create');
Route::match(['get'],'/admin/review-question/edit/{id}','Admin\ReviewQuestionController@getData');
Route::match(['post'],'/admin/review-question/edit','Admin\ReviewQuestionController@update');
Route::match(['post'],'/admin/review-question/change_status','Admin\ReviewQuestionController@change_status');
Route::match(['get'],'/admin/review-question/delete/{id}','Admin\ReviewQuestionController@delete');

Route::match(['get','post'],'/change_status/user/comp/{id}','Admin\CompanyController@change_status_user_comp');
Route::match(['get','post'],'/change_status/comp/{id}','Admin\CompanyController@change_status_comp');
Route::match(['get','post'],'/change_status/dept/{id}','HomeController@change_status_dept');
Route::get('/get/state/{id}','HomeController@get_state');



Route::match(['get','post'],'admin/import-data', 'Admin\UserController@import_data');


// review flags and reports
Route::match(['get','post'],'/operate_flag/{reviewId}/{managerId}','Frontend\ReviewFlagReportController@operate_flag');

// Admin reviews panel
Route::match(['get','post'],'admin/reviews', 'Admin\ReviewsController@index');