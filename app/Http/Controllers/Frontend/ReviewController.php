<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
use View;
use App\Setting;
use App\Invitations;
use App\ReviewLikes;
use App\Reviews;
class ReviewController extends Controller {
   
    public function like(Request $request, $id){
        if(Auth::check()){
            ReviewLikes::where(['review_id' => $id, 'like_by'=>Auth::user()->id])->delete();
            $newReviewLike = new ReviewLikes;
            $newReviewLike->like_by = Auth::user()->id;
            $newReviewLike->review_id = $id;
            $newReviewLike->action = 'Like';
            $newReviewLike->save();
            $review = Reviews::find($id);
            $html = View::make('frontend.review.review_like_dislike', compact('review'))->render();
            return  response()->json(['status' => true, 'html' => $html, 'message' => 'Like successfully!', ]);
        } else {
            return  response()->json(['status' => false, 'message' => 'Please login first.', ]);
        }
        return back();
    }

    public function dislike(Request $request, $id){
        if(Auth::check()){
            ReviewLikes::where(['review_id' => $id, 'like_by'=>Auth::user()->id])->delete();

            $newReviewLike = new ReviewLikes;
            $newReviewLike->like_by = Auth::user()->id;
            $newReviewLike->review_id = $id;
            $newReviewLike->action = 'Dislike';
            $newReviewLike->save();
            $review = Reviews::find($id);
            $html = View::make('frontend.review.review_like_dislike', compact('review'))->render();
            return  response()->json(['status' => true, 'html' => $html, 'message' => 'Dislike successfully!', ]);
        } else {
            return  response()->json(['status' => false, 'message' => 'Please login first.', ]);
        }
        return back();
    }

    public function remove_like(Request $request, $id){
        if(Auth::check()){
            ReviewLikes::where(['review_id' => $id, 'like_by'=>Auth::user()->id, 'action' => 'Like'])->delete();
            $review = Reviews::find($id);
            $html = View::make('frontend.review.review_like_dislike', compact('review'))->render();
            return  response()->json(['status' => true, 'html' => $html, 'message' => 'Updated successfully!', ]);
        } else {
            return  response()->json(['status' => false, 'message' => 'Please login first.', ]);
        }
        return back();
    }
    public function remove_dislike(Request $request, $id){
        if(Auth::check()){
            ReviewLikes::where(['review_id' => $id, 'like_by'=>Auth::user()->id, 'action' => 'Dislike'])->delete();
            $review = Reviews::find($id);
            $html = View::make('frontend.review.review_like_dislike', compact('review'))->render();
            return  response()->json(['status' => true, 'html' => $html, 'message' => 'Updated successfully!', ]);
        } else {
            return  response()->json(['status' => false, 'message' => 'Please login first.', ]);
        }
        return back();
    }

}
