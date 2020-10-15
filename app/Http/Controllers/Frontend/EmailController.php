<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Setting;
use App\Invitations;
use App\InvitationBy;
use App\AdminNotificationModel;
class EmailController extends Controller
{
    public function careers_info(Request $request)
    {
    	 if($request->isMethod('post'))
    	 {
    	 	 $postData = $request->all();
    	 	 $validatedData = $request->validate([
                'subject' => 'required',
                'message' => 'required',
                'email' => 'required|email',
              ]);
             // echo "<pre>";
             // print_r($postData);
             // die('rr');

    	 	        $email_data = array(
                    'user_email' => $request->email,
                    'text'     => $request->message,
                    'subject' => $request->subject,
                );
    	 	        $customer_email = $request->email;
                    $admin_mail = Setting::value('email');
                    $admin_name = 'Review System';
                    $subjact = "Careers"; 
                    try
                    {
                        Mail::send(['html' => 'email/careers'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                                    $message->from($customer_email);
                                    $message->to($admin_mail,'Review System')->subject($subjact);

                        });
                    } 
                    catch(\Exception $ex)
                    {
                       toastr()->warning('Mail Not Send !!!');
                       return back();    
                    }
                toastr()->success('Careers Mail Send Successfully');
                return redirect('/home');    
    	 }
    }

    public function help(Request $request)
    {
        if($request->isMethod('post'))
    	 {
    	 	 $postData = $request->all();
    	 	 $validatedData = $request->validate([
                'subject' => 'required',
                'message' => 'required',
                'email' => 'required|email',
              ]);
    	 	        $customer_email = $request->email;
                    $admin_mail = Setting::value('email');
                    $admin_name = 'Review System';
                    $subjact = "Help"; 
                    try
                    {
                         $email_data = array(
                        'user_email' => $request->email,
                        'text'     => $request->message,
                        'subject' => $request->subject,
                        );
                        Mail::send(['html' => 'email/help'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                                    $message->from($customer_email);
                                    $message->to($admin_mail,'Review System')->subject($subjact);

                        });
                    } 
                    catch(\Exception $ex)
                    {
                       toastr()->warning('Mail Not Send !!!');
                       return back();    
                    }
                toastr()->success('Help Mail Send Successfully');
                return redirect('/home');    
    	 }
    }

    public function help_us_know(Request $request)
    {
        if($request->isMethod('post'))
         {
             $postData = $request->all();
             $validatedData = $request->validate([
                'subject' => 'required',
                'message' => 'required',
                'email' => 'required|email',
              ]);
                    $customer_email = $request->email;
                    $admin_mail = Setting::value('email');
                    $admin_name = 'Review System';
                    $subjact = "Help"; 
                    try
                    {
                         $email_data = array(
                        'user_email' => $request->email,
                        'text'     => $request->message,
                        'subject' => $request->subject,
                        );
                        Mail::send(['html' => 'email/help_us_know'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                                    $message->from('preformly@gmail.com');
                                    $message->to($admin_mail,'Blossam.team')->subject($subjact);

                        });
                    } 
                    catch(\Exception $ex)
                    {
                       toastr()->warning('Mail Not Send !!!');
                       return back();    
                    }
                toastr()->success('Submitted Successfully.');
                return back();    
         }
    }

    public function add_company(Request $request)  {
        if($request->isMethod('post')) {
            $InvitationBy = new InvitationBy;
            if(Auth::check()){
                $InvitationBy->type = 'User';
                $InvitationBy->send_by = Auth::user()->id;
                $title = "New Company: ".$request->company_name." company has been requested for addition by ".$InvitationBy->type." ".Auth::user()->fullName();
            } else {
                $InvitationBy->type = 'Guest';
                $title = "New Company: ".$request->company_name." company has been requested for addition by ".$InvitationBy->type;
            }
            $InvitationBy->save();

            $invitations = new Invitations;
            $invitations->invitation_by = $InvitationBy->id;
            $invitations->account_origin = 'Add your company';
            $invitations->sender_email = $request->email;
            if(Auth::check()){
                $invitations->send_by = Auth::user()->id;
            }
            $invitations->save();

    	 	$postData = $request->all();
    	 	$validatedData = $request->validate([
                'subject' => 'required',
                'message' => 'required',
                'company_name' => 'required',
                'email' => 'required|email',
            ]);

            $email_data = array(
                'title' => $title,
                'company_name' => $request->company_name,
                'user_email' => $request->email,
                'text'     => $request->message,
                'subject' => $request->subject,
            );

            $AdminNotificationModel = new AdminNotificationModel;
            $AdminNotificationModel->type="newCompanyAddedThroughFooter";
            $AdminNotificationModel->status="open";
            if( Auth::check() ){
                $AdminNotificationModel->user_id = Auth::user()->id;
            }
            $AdminNotificationModel->company_name = $request->company_name;
            $AdminNotificationModel->save();

 	        $customer_email = $request->email;
            $admin_mail = Setting::value('email');
            $admin_name = 'Blossom Team';
            $subjact = $title;  
            try {
                Mail::send(['html' => 'email/add_company'],$email_data, function ($message) use ($email_data,$customer_email,$admin_mail,$subjact,$admin_name){
                            $message->from("preformly@gmail.com");
                            $message->to($admin_mail,'Blossom Team')->subject($subjact);

                });
            } catch(\Exception $ex) {
            //    print_r($ex->getMessage()); die;
               toastr()->warning('Mail Not Send !!!');
               return back();    
            }

            toastr()->success('Company registration request sent.');
            return redirect('/home');    
    	}
    }
    public function invite_friends(Request $request){
        if($request->isMethod('post')) {
            $postData = $request->all();
            $validatedData = $request->validate([
                'name' => 'required',
                'friend_name' => 'required',
                'email' => 'required|email',
            ]);

            $subjact = "Invitation";
            $user_email = trim($request->email);
            $sender_name = $request->name;

            $InvitationBy = new InvitationBy;
            if(Auth::check()){
                $InvitationBy->type = 'Invitee';
                $InvitationBy->send_by = Auth::user()->id;;
            } else {
                $InvitationBy->type = 'Guest';
            }
            $InvitationBy->save();

            $invitations = new Invitations;
            $invitations->invitation_by = $InvitationBy->id;
            $invitations->sender_name = $request->name;
            $invitations->account_origin = 'Invite friend';
            $invitations->receiver_name = $request->friend_name;
            $invitations->receiver_email = $request->email;
            if(Auth::check()){
                $invitations->send_by = Auth::user()->id;
            }
            $invitations->save();
            $url = url('/invite-link/'.$invitations->id);
            $email_data = array(
                'my_name' => $request->name,
                'friend_name' => $request->friend_name,
                'refer_url' => $url,
            );

            $from = Setting::value('email');
            // try {
            //     Mail::send(['html' => 'email/invitation'],$email_data, function ($message) use ($email_data,$user_email,$subjact,$sender_name,$from){
            //         $message->from($from);
            //         $message->to($user_email,$sender_name)->subject($subjact);

            //     });

            // } catch(\Exception $ex) { 
            //     print_r($ex->getMessage());die;
            //     toastr()->warning('Invitation Mail Not Send');
            //     return back();
            // }
            toastr()->success('Invitation sent');
            return back(); 
         }
    }


    public function invite_friends_email(Request $request){
        if($request->isMethod('post')) {
            $postData = $request->all();
            $validatedData = $request->validate([
                '_fname' => 'required',
                '_lname' => 'required',
                '_email' => 'required|email',
                // '_login_user_email' => 'required|email',
            ]);

            $subjact = "Invitation";
            $user_email = trim($request->_email);
            $sender_name = "John Doe";

            $InvitationBy = new InvitationBy;
            if(Auth::check()){
                $InvitationBy->type = 'Invitee';
                $InvitationBy->send_by = Auth::user()->id;;
            } else {
                $InvitationBy->type = 'Guest';
            }
            $InvitationBy->save();

            $invitations = new Invitations;
            $invitations->invitation_by = $InvitationBy->id;
            // $invitations->sender_name = $request->name;
            $invitations->receiver_name = $request->_fname;
            $invitations->account_origin = "Invite friend";
            $invitations->receiver_last_name = $request->_lname;
            $invitations->receiver_email = $request->_email;
            // $invitations->sender_email = $request->_login_user_email;
            if($request->_linkedin){
                $invitations->receiver_linkedin_profille = $request->_linkedin;
            }
            if($request->mystery){
                $invitations->mystery_invite = "1";
            }
            if(Auth::check()){
                $invitations->send_by = Auth::user()->id;
            }
            $invitations->save();
            $url = url('/invite-link/'.$invitations->receiver_email);
            $email_data = array(
                'my_name' => "John Doe",
                'friend_name' => $request->friend_name,
                'refer_url' => $url,
            );

            $from = Setting::value('email');
            // try {
            //     Mail::send(['html' => 'email/invitation'],$email_data, function ($message) use ($email_data,$user_email,$subjact,$sender_name,$from){
            //         $message->from($from);
            //         $message->to($user_email,$sender_name)->subject($subjact);

            //     });

            // } catch(\Exception $ex) { 
            //     print_r($ex->getMessage());die;
            //     toastr()->warning('Invitation Mail Not Send');
            //     return back();
            // }
            return response()->json(array('success' => true));
        }else{
          return response()->json(array('error' => true));
        }
    }
}
