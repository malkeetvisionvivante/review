<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question_rate extends Model
{
     protected $table = 'question_rate';
     protected  $fillable = [
        'user_id','customer_id','question_id','rate',
    ];
}
