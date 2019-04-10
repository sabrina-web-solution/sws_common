<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system_id', 'product_name', 'venue_id','merchant_id','product_brand_ids','product_category_ids','product_modifier_ids','product_description','product_images','status'
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
