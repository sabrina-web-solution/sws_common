<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system_id', 'merchant_name', 'merchant_images','status'
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
