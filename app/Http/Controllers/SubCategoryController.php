<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Str;
use Image;

class SubCategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.category.subcategory', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function subcategory_store(Request $request){

        if($request->subcategory_image == ''){
            Subcategory::insert([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
            ]);
        }
        else{
            
            $random_number = random_int(100000, 999998);
            $subcategory_image = $request->subcategory_image;
            $extension = $subcategory_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->subcategory_name)).'-'.$random_number.'.'.$extension;
            
            Image::make($subcategory_image)->save(public_path('uploads/subcategory/'.$file_name));

            Subcategory::insert([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
                'subcategory_image'=>$file_name,
            ]);
        }
        
        return back();
    }
}
