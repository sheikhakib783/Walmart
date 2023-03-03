<?php

// namespace App\Http\Controllers;

// use App\Models\Wishlist;
// use Carbon\Carbon;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class WishlistController extends Controller
// {
//     function wishlist_store(Request $request){
//         if(Wishlist::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
//             Wishlist::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
//             return back()->with('cart_added', 'Cart Successfuly Added');
//         }
//         else{
//             Wishlist::insert([
//                 'customer_id'=>Auth::guard('customerlogin')->id(),
//                 'product_id'=>$request->product_id,
//                 'color_id'=>$request->color_id,
//                 'size_id'=>$request->size_id,
//                 'quantity'=>$request->quantity,
//                 'created_at'=>Carbon::now(),
//             ]);
//         }            
//         return back()->with('cart_added', 'Cart Successfuly Added');
//     }

    // Cart Remove
//     function remove_cart($cart_id){
//         Wishlist::find($cart_id)->delete();
//         return back();
//     }
// }
