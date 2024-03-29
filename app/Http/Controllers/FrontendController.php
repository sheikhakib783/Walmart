<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductGallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{

    function index(){
        $categories = Category::all();
        $products = Product::take(9)->get();
        return view('frontend.index',[
            'categories'=>$categories,
            'products'=>$products,
        ]);
    }

    function details($product_id){
       $product_info = Product::find($product_id);
       $galleries = ProductGallery::where('product_id', $product_id)->get();
       $releted_products = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();
       $colors = Inventory::where('product_id',$product_info->id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
       $sizes = Inventory::where('product_id',$product_info->id)->groupBy('size_id')->selectRaw('count(*) as total, size_id')->get();
       $all_review = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();
        return view('frontend.details',[
            'product_info'=>$product_info,        
            'galleries'=>$galleries,        
            'releted_products'=>$releted_products,
            'colors'=>$colors,
            'sizes'=>$sizes,
            'all_review'=>$all_review,
        ]);
    }

    function getSize(Request $request){
        $sizes =Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        
        $str = '';

        foreach($sizes as $size){

            if($size->size_id==1){
                $str = '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input checked class="form-check-input" type="radio" name="size_id" id="size'.$size->size_id.'" value="'.$size->size_id.'">
                    <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
                    </div>';
            }
            else{
                $str .='<div class="form-check size-option form-option form-check-inline mb-2">
                    <input checked class="form-check-input" type="radio" name="size_id" id="size'.$size->size_id.'" value="'.$size->size_id.'">
                    <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
                    </div>';
            }    
        }
        echo $str;        
    }


    //  View Cart Page

    function cart(Request $request){
        // Coupon
        $discount = 0;
        $type = '';
        $mesg = '';

        if(isset($request->coupon_name)){
            if(Coupon::where('coupon_name', $request->coupon_name)->exists()){
                if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_name', $request->coupon_name)->first()->expire_date){
                    if(Coupon::where('coupon_name', $request->coupon_name)->first()->type == 1){
                        $discount = 20;
                        $type = 1;
                    }
                    else{    
                        $type = 2;            
                        $discount = 100;                    
                    }
                }
                else{
                    $mesg = 'Coupon Code Expired';                
                    $discount = 0;
                }
            }
            else{
                $mesg = 'Coupon Code Does not Exist';
                $discount = 0;
            }
        }

        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
            'discount'=>$discount,
            'mesg'=>$mesg,
            'type'=>$type,
        ]);
    }
            
        
  
}
