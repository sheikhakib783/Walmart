<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

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
       $avilable_colors = Inventory::where('product_id',$product_info->id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
       $avilable_sizes = Inventory::where('product_id',$product_info->id)->groupBy('size_id')->selectRaw('count(*) as total, size_id')->get();
        return view('frontend.details',[
            'product_info'=>$product_info,
            'galleries'=>$galleries,
            'releted_products'=>$releted_products,
            'avilable_colors'=>$avilable_colors,
            'avilable_sizes'=>$avilable_sizes,
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
  
}
