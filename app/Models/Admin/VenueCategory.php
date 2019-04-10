<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class VenueCategory extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    $fillable = [
    	'system_id','venue_category_name','venue_category_images','merchant_id','venue_id','cat_id','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
