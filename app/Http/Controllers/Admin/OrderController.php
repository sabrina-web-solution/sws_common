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
    			$today 	= strtotime(date('dS M, Y H:i A'));
    		  	$c_data = json_decode($request->data);
    		  	$data['received'] 	= 	$c_data;
    		  	$order 	= 	$orderdetails 	= 	$productdetails		= 	[];
    		  	
    		  	foreach ($c_data['product_details'] as $key => $data) {
    		  		$products 	= 	Product::find($data->product_id);
    		  		if($products){
    		  			$perpcprice 	= 	$products->sell_price;
    		  			if($data->modifier_id) {
							$modifier 		= ProductModifier::find($data->modifier_id);
							if($modifier){
								$perpcprice = $modifier->sell_price;	
							}
						}
	  					$offer 	= 	ProductOffer::where('product_id',$data->product_id)->where('venue_id',$data->)->where('start','<=',$today)->where('end','>=',$today)->first();
	  					if($offer){
	  						if($offer->type == 'per'){
	  							$perpcprice		*=	(100-$offer->peramt)/100;
	  						} elseif($offer->type == 'amt'){
	  							$perpcprice		-=	$offer->peramt;
	  						} elseif ($offer->type == 'comboper') {
	  							
	  						}
    		  			}
    		  			$tax 	= 	Tax::find($products->taxid);
    		  			if($tax){
    		  				$taxamount 	= 	$tax->amount;
    		  			}
    		  		$productdetails 	= [
							'costperpc' 	= 	$perpcprice,
							'quantity'		= 	$data->quantity,
							'total'			= 	$perpcprice * $data->quantity,
							'taxid'			= 	!empty($data->taxid)?($data->taxid):null,
							'net_amount' 	=	$perpcprice + $taxamount;
				  		]
    		  		}
    		  	}
    		  	
    		  	return response()->json(['status'=>200,'data'=>$orders]);
    	} catch (Exception $e) {
			    		
    	}
    }
}
