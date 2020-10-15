<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\review_questions;
use App\Company;
use App\Managers;

class ReviewLikes extends Model {
    protected $table = 'review_likes';
}
