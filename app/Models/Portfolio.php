<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table = 'portfolio';
    
    protected $fillable = [
        'coverpic',
        'info',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($portfolio) {
            if (is_null($portfolio->display_order)) {
                $maxOrder = Portfolio::max('display_order');
                $portfolio->display_order = ($maxOrder)? $maxOrder + 1 : 1;
            }
        });
    }
}