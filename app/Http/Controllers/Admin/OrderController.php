<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Category;
use App\Models\Admin\Merchant;
use App\Models\Admin\Venue;
use App\Models\Admin\Product;
use App\Models\Admin\ProductBrand;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductModifier;
use App\Models\Admin\VenueCategory;
use App\Models\Admin\ProductOffer;

class OrderController extends Controller
{
    public function newOrder(Request $request){
    	try {
    		  	$c_data = json_decode($request->data);
    		  	foreach ($c_data as $key => $data) {
    		  		$products 	= 	Product::where('id',$data->product_id)
    		  								->where('venue_id',$data->venue_id)
    		  								->where('merchant_id',$data->merchant_id)
    		  								->where('modifier_id',$data->modifier_id)
    		  								->first();
    		  		if($products){
    		  			if($data->offer_id){ 
    		  					$offer 	= 	ProductOffer::where('id',$data->offer_id)->first();
    		  			} else {
    		  				$date 		= Date('Y-m-d H:m');
    		  				$offer 		= ProductOffer::where('product_id',$data->product_id)
    		  											->where('venue_id',$data->venue_id)
    		  											->where('merchant_id',$data->merchant_id)
    		  											->whereRaw("Find_in_set('days',)")
    		  											->first();

    		  			}
						if($offer){
							$perpcprice 	= 	$offer->costperpc; 
						} else {
							$modifier 		= ProductModifier::where('id',$data->modifier_id)->first();
						}	    		  								
    		  		}


    		  	}

    	} catch (Exception $e) {
			    		
    	}
    }
}
