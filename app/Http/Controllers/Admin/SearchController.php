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
use App\Models\Admin\OrderDetails;
use App\Models\Admin\Payments;

class SearchController extends Controller
{

	public function searchAll(Request $request){
		try {
				 $data = $cat_ids = [];
		        if(!empty($request->data)){
					$c_data = json_decode($request->data);
					$data['received'] 	=	$c_data;
					$data['venues']     = Venue::where('system_id',$c_data->system_id)->where('venue_name','like','%'.$c_data->searchText. '%')->get();
					$data['products'] 	= Product::where('system_id',$c_data->system_id)->where('product_name','like','%'.$c_data->searchText. '%')->get();
					foreach ($data['products'] as $key => $prod) {
						$prod['venue'] = Venue::where('system_id',$c_data->system_id)->where('id',$prod->venue_id)->first();
						$prod['merchant'] = Merchant::where('system_id',$c_data->system_id)->where('id',$prod->merchant_id)->first();
						if($prod->modifier_id){
                    		$prod['modifier'] = ProductModifier::where('system_id',$data1->system_id)
		                                                    ->where('id',$prod->modifier_id)
		                                                    ->where('product_id',$prod->id)
		                                                    ->where('status',1)
		                                                    ->first();
		                } else {
		                    $prod['modifier'] = ProductModifier::where('system_id',$data1->system_id)
		                                                    ->where('product_id',$prod->id)
		                                                    ->where('status',1)
		                                                    ->get();
		                }

		                if($prod->offer_id){
		                    $prod['offer']    = ProductOffer::where('system_id',$data1->system_id)
		                                                    ->where('id',$prod->offer_id)
		                                                    ->where('product_id',$prod->id)
		                                                    ->where('status',1)
		                                                    ->first();
		                } else {
		                    $prod['offer']    = ProductOffer::where('system_id',$data1->system_id)
		                                                    ->where('product_id',$prod->id)
		                                                    ->where('status',1)
		                                                    ->get();
		                }
		                
		                if(!empty($prod->product_brand_ids))
		                {
		                    $ids = explode($prod['products']->product_brand_ids);
		                    $prod['brand']    	= ProductBrand::where('system_id',$data1->system_id)
		                                                    ->whereIn('id',$ids)
		                                                    ->where('status',1)
		                                                    ->select('brand_name')
		                                                    ->first();
		                }
					}
					$category					=   Category::where('system_id',$data1->system_id)
                                                    ->get();

	                if (!empty($category) && count($category)) {
	                    foreach ($category as $key => $cat) {
	                        $cat_ids[] = $cat->id;
	                        if (!empty($cat->breadcrumb)) {
	                            foreach (explode("/",$cat->breadcrumb) as $cat1) {
	                                $cat_ids[] = (int)$cat1; 
	                            }
	                        }
	                    }
	                }

	                $data['category'] 			= Category::where('system_id',$data1->system_id)
	                									->whereIn('id',$cat_ids)
                                                    	->get();
					return response()->json(['status'=>200,'data'=>$data]);

		} catch (Exception $e) {
			
		}
	}
	
	    // get details of searched product with name
    public function searchProduct(Request $request){
       $data = $cat_ids = [];
        if(!empty($request->data)){
            $c_data = json_decode($request->data);
            foreach ($c_data as $key => $data1) {
                $data[$key]['received']     = $data1;
                $data[$key]['products']     = Product::where('system_id',$data1->system_id)
                                                    ->where('product_name','like','%'.$data1->search_key.'%')
                                                    ->where('status',1)
                                                    ->get();
                $data[$key]['venues']       = Venue::where('system_id',$data1->system_id)
                                                    ->where('id',$data1->venue_id)
                                                    ->where('merchant_id',$data1->merchant_id)
                                                    ->where('status',1)
                                                    ->first();
                if($data1->modifier_id){
                    $data[$key]['modifier'] = ProductModifier::where('system_id',$data1->system_id)
                                                    ->where('id',$data1->modifier_id)
                                                    ->where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->first();
                } else {
                    $data[$key]['modifier'] = ProductModifier::where('system_id',$data1->system_id)
                                                    ->where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->get();
                }
                if($data1->offer_id){
                    $data[$key]['offer']    = ProductOffer::where('system_id',$data1->system_id)
                                                    ->where('id',$data1->offer_id)
                                                    ->where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->first();
                } else {
                    $data[$key]['offer']    = ProductOffer::where('system_id',$data1->system_id)
                                                    ->where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->get();
                }
                if(!empty($data[$key]['products']['product_brand_ids']))
                {
                    $ids = explode($data[$key]['products']->product_brand_ids);
                    $data[$key]['brand']    = ProductBrand::where('system_id',$data1->system_id)
                                                    ->whereIn('id',$ids)
                                                    ->where('status',1)
                                                    ->first();
                }

                $category                   =   Category::where('system_id',$data1->system_id)
                                                    ->where('venue_id',$data1->venue_id)
                                                    ->get();

                if (!empty($category) && count($category)) {
                    foreach ($category as $key => $cat) {
                        $cat_ids[] = $cat->id;
                        if (!empty($cat->breadcrumb)) {
                            foreach (explode("/",$cat->breadcrumb) as $cat1) {
                                $cat_ids[] = (int)$cat1; 
                            }
                        }
                    }
                } 
            }

        $data['category'] = Category::whereIn('id',$cat_ids)->get();
        }
        return response()->json(['status'=>200,'data'=>$data]);
    }

}
