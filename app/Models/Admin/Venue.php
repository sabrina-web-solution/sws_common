<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system_id', 'merchant_id','venue_name','venue_images','venue_longitude','venue_latitude','status'
    ];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
