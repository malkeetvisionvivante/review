<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\review_questions;
use App\Reviews;
use App\Company;
use App\Managers;
use DB;

class ReviewCategory extends Model
{
    protected $table = 'review_category';

    // public function question_rate($categoryId, $managerId) {
    // 	$questionIds = [];
    // 	$review_questions = review_questions::select('id')->where('category_id',$categoryId)->get();
    // 	if(count($review_questions) > 0){
	   //  	foreach ($review_questions as $key => $question) {
	   //  		$questionIds[] = $question->id;
	   //  	}
    // 	}
    // 	if(count($questionIds) > 0){
    // 		$allReviewAvg = [];
	   //  	$reviews = Reviews::where('user_id', $managerId)->get();
	   //  	foreach ($reviews as $key => $review) {
	   //  		$reviewData = json_decode( $review->review_value );
	   //  		$reviewAvg = [];
	   //  		foreach ($reviewData as $key => $value) {
	   //  			if(in_array( $key, $questionIds)){
	   //  				$reviewAvg[] = $value;
	   //  			}
	   //  		}
	   //  		$allReviewAvg[] = array_sum($reviewAvg) / count($questionIds);
	   //  	}
	   //  	if(count($allReviewAvg) > 0){
		  //   	$data = array_sum($allReviewAvg) / count($allReviewAvg);
		  //   	return number_format((float)$data, 2, '.', '');
		  //   } else {
    // 			return 0;
    // 		}	
    // 	} else {
    // 		return 0;
    // 	}
    // }

    public function categoryRate($categoryId, $managerId, $for) {
        $questionIds = [];
        $review_questions = review_questions::select('id')->where(['category_id' => $categoryId,'question_for' => $for])->get();
        if(count($review_questions) > 0){
            foreach ($review_questions as $key => $question) {
                $questionIds[] = $question->id;
            }
        }
        if(count($questionIds) > 0){
            $allReviewAvg = [];
            $reviews = Reviews::where('user_id', $managerId)->get();
            foreach ($reviews as $key => $review) {
                $reviewData = json_decode( $review->review_value );
                $reviewAvg = [];
                foreach ($reviewData as $key => $value) {
                    if(in_array( $key, $questionIds)){
                        $reviewAvg[] = $value;
                    }
                }
                if(count($reviewAvg) > 0){
                    $allReviewAvg[] = array_sum($reviewAvg) / count($reviewAvg);
                }
            }
            if(count($allReviewAvg) > 0){
                $data = array_sum($allReviewAvg) / count($allReviewAvg);
                return number_format((float)$data, 1, '.', '');
            } else {
                return number_format((float)0, 1, '.', '');
            }   
        } else {
            return number_format((float)0, 1, '.', '');
        }
    }

    public function question_count($categoryId) {
    	$review_questions = review_questions::select('id')->where(['category_id'=>$categoryId,'status'=> 0])->get();
    	return count($review_questions);
    }

    public function question_count1($categoryId, $question_for) {
    	$review_questions = review_questions::select('id')->where(['category_id'=>$categoryId,'status'=> 0,'question_for' => $question_for])->get();
    	return count($review_questions);
    }
}
