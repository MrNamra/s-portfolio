<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'name',
        'deg',
        'img',
        'message',
        'isActive',
    ];
}
