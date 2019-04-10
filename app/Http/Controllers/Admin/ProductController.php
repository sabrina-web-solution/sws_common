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

class ProductController extends Controller
{
    //Details of single product with product id
    public function getProductDetails(Request $request){
        $data = $cat_ids = [];
        if(!empty($request->data)){
            $c_data = json_decode($request->data);

            foreach ($c_data as $key => $data1) {
                $data[$key]['received']     = $data1;
                $data[$key]['venues']       = Venue::where('id',$data1->venue_id)
                                                    ->where('merchant_id',$data1->merchant_id)
                                                    ->where('status',1)
                                                    ->first();

                $data[$key]['products']     = Product::where('id',$data1->product_id)
                                                    ->where('merchant_id',$data1->merchant_id)
                                                    ->where('venue_id',$data1->venue_id)
                                                    ->where('status',1)
                                                    ->first();
                  
                if($data1->modifier_id){
                    $data[$key]['modifier'] = ProductModifier::where('id',$data1->modifier_id)
                                                    ->where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->first();
                } else {
                    $data[$key]['modifier'] = ProductModifier::where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->get();
                }

                if($data1->offer_id){
                    $data[$key]['offer']    = ProductOffer::where('id',$data1->offer_id)
                                                    ->where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->first();
                } else {
                    $data[$key]['offer']    = ProductOffer::where('product_id',$data1->product_id)
                                                    ->where('status',1)
                                                    ->get();
                }
                
                if(!empty($data[$key]['products']['product_brand_ids']))
                {
                    $ids = explode($data[$key]['products']->product_brand_ids);
                    $data[$key]['brand']    = ProductBrand::whereIn('id',$ids)
                                                    ->where('status',1)
                                                    ->select('brand_name')
                                                    ->first();
                }
                
                $category                   =   Category::where('venue_id',$data1->venue_id)
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
            $cat_ids = unique($cat_ids);

            $data['category'] = Category:::where('system_id',$data1->system_id)->whereIn('id',$cat_ids)->get();

        }
        return response()->json(['status'=>200,'data'=>$data]);
    }

     //Details of venue products 
    public function getProductDetails(Request $request){
        $data = $cat_ids = [];
        if(!empty($request->data)){
            $c_data = json_decode($request->data);

            foreach ($c_data as $key => $data1) {
                $data[$key]['received']     = $data1;
                $data[$key]['venues']       = Venue::where('id',$data1->venue_id)
                                                    ->where('merchant_id',$data1->merchant_id)
                                                    ->where('status',1)
                                                    ->first();

                $data[$key]['products']     = Product::where('merchant_id',$data1->merchant_id)
                                                    ->where('venue_id',$data1->venue_id)
                                                    ->where('status',1)
                                                    ->get();

                foreach ($data[$key]['products'] as $key => $prod) {
                    if($prod->modifier_id){
                        $prod['modifier'] = ProductModifier::where('id',$prod->modifier_id)
                                                        ->where('product_id',$prod->id)
                                                        ->where('status',1)
                                                        ->first();
                    } else {
                        $prod['modifier'] = ProductModifier::where('product_id',$prod->id)
                                                        ->where('status',1)
                                                        ->get();
                    }

                    
                        $prod['offer']    = ProductOffer::where('system_id',$data1->system_id)
                                                        ->where('product_id',$prod->id)
                                                        ->where('status',1)
                                                        ->get();
                    if(!empty($prod->product_brand_ids))
                    {
                        $ids = explode($prod->product_brand_ids);
                        $prod['brand']    = ProductBrand::whereIn('id',$ids)
                                                        ->where('status',1)
                                                        ->select('brand_name')
                                                        ->first();
                    }
                  }  

                
                $category                   =   Category::where('venue_id',$data1->venue_id)
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
            $cat_ids = unique($cat_ids);

            $data['category'] = Category:::where('system_id',$data1->system_id)->whereIn('id',$cat_ids)->get();

        }
        return response()->json(['status'=>200,'data'=>$data]);
    }
   
}
