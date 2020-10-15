<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmarks extends Model
{
    protected $table = 'bookmarks';
    protected  $fillable = [
        'manager_id', 'user_id'
    ];
}
