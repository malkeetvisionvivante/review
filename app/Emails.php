<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $table = 'emails';
    protected  $fillable = [
        'subject', 'from','to','content'
    ];
}
