<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Str;
use Image;

class CategoryController extends Controller
{ 

    function category(){
        $categories = Category::all();
        $trash_categories  = Category::onlyTrashed()->get();
        return view('admin.category.category', [
            'categories'=> $categories,
            'trash_categories'=> $trash_categories,
        ]);
    }

    function category_store(Request $request){
        $request->validate([
            'category_name'=> 'required|unique:categories',
            'category_image'=> 'required',
        ]);

        if($request->category_image == ''){
            Category::insert([
                'category_name'=>$request->category_name,
            ]);
        }
        else{
            $random_number = random_int(100000, 999998);
            $category_image = $request->category_image;
            $extension = $category_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)).'-'.$random_number.'.'.$extension;
           
            Image::make($category_image)->save(public_path('uploads/category/'.$file_name));

            Category::insert([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
            ]);

        }

        return back();
    }
// Category Delete
    function category_delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('delete_success', 'Category Deleted Successfuly');
    }
// Category Edit
    function category_edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.edit_category', [
            'category_info'=> $category_info,
        ]);  
    }
// Category Update
    function category_update(Request $request){
       if($request->$category_image == ''){
        Category::find($request -> category_id)->update([
            'category_name' => $request ->category_name,
        ]);
        return back();
       }
       else{

            $present_image = Category::find($request -> category_id);
            $delete_from = public_path('uploads/category/' .$present_image->$category_image);
            unlink($delete_from);

            $random_number = random_int(100000, 999998);
            $category_image = $request->category_image;
            $extension = $category_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)).'-'.$random_number.'.'.$extension;
            
            Image::make($category_image)->save(public_path('uploads/category/'.$file_name));
            Category::find($request -> category_id)->update([
            'category_name' => $request ->category_name,
            'category_image' => $request ->$file_name,
        ]);
        return back();

       }
    }

    function category_restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }

    function category_del($category_id){
        $present_image = Category::onlyTrashed()->find($category_id);
        $delete_from = public_path('uploads/category/' .$present_image->category_image);
        unlink($delete_from);

        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('perdelete_success', 'Category Permanent Deleted Successfuly');
    }

    function category_checked_delete(Request $request){
        foreach($request->category_id as $category){
            Category::find($category)->delete();
        }
        return back();
    }
// restore all
    function category_restore_single(Request $request){
        foreach($request->trash as $category){
         Category::onlyTrashed()->find($category)->restore();
        }
        return back();
    }

    // function category_permanent_delete(Request $request){
    //     foreach($request->trash as $category){
    //         Category::onlyTrashed()->find($category)->delete();
    //        }
    //        return back();
    // }
}