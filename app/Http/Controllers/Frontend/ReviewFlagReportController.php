<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\ReviewFlagReport;
use App\AdminNotification;
use App\Reviews;
use App\AdminNotificationModel;
use App\User;


class ReviewFlagReportController extends Controller {

  public function __construct() {}

  public function operate_flag(Request $request, $reviewId, $managerId){
    $flag = ReviewFlagReport::where([['review_id',$reviewId],['manager_id',$managerId],['flagger_id',Auth::user()->id]])->first();
    if ($flag === null) {
      $flag = new ReviewFlagReport();
      $flag->review_id = $reviewId;
      $flag->manager_id = $managerId;
      $flag->flagger_id = Auth::user()->id;
      if($flag->save()){
        $count = ReviewFlagReport::where('review_id', $reviewId)->count();
        $reviewData = ReviewFlagReport::where('review_id', $reviewId)->get();
        $reviewData1 = Reviews::find($reviewId);
        AdminNotification::reviewReport(Auth::user(), User::find($managerId), $count, $reviewData, $reviewData1->comment);  
        if($count >=5){
          $review = Reviews::find($reviewId);
          $review->hidden_comment = 1;
          $review->save();
        }
        $AdminNotificationModel = AdminNotificationModel::where(['review_id' => $reviewId,'type' => 'commentReportLimit'])->first();
        if($AdminNotificationModel){
        	$AdminNotificationModel = AdminNotificationModel::find($AdminNotificationModel->id);
        	$AdminNotificationModel->number_of_reports = $AdminNotificationModel->number_of_reports + 1;
        	$AdminNotificationModel->status="open";
        	$AdminNotificationModel->save();
        } else {
		    $AdminNotificationModel = new AdminNotificationModel;
		    $AdminNotificationModel->type="commentReportLimit";
		    $AdminNotificationModel->status="open";
		    $AdminNotificationModel->review_id=$reviewId;
		    $AdminNotificationModel->number_of_reports=1;
		    $AdminNotificationModel->save();
		}
        return response()->json(array('success' => true));
      }
    }else{
      if($flag->delete()){
        return response()->json(array('success' => true)); 
      }
    }
  }
}