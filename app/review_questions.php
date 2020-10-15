<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\question_rate;

class review_questions extends Model
{
    //

    public function question_rate($id,$question_id)
    {
       return $rate = question_rate::where('user_id',$id)->where('question_id',$question_id)->avg('rate');   
    }

    public function category_question_rate($categoryName, $questionId, $managerId) {
		$questionIds[] = $questionId;
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
}
