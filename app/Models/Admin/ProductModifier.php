<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductModifier extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system_id', 'product_id', 'venue_id','merchant_id','modifier_name','modifier_images','buy_price','sell_price','availablepc'
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
