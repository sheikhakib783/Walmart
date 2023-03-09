<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\ShippingDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function checkout(){
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        $countries = Country::all();
        return view('frontend.checkout', [
            'countries'=>$countries,
            'carts'=>$carts,
        ]);
    }
// City 
    function getCity(Request $request){
        $str = '<option value="">--- Select City ----</option>';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }
// Order Table
    function order_store(Request $request){
        $random_number2 = random_int(1000000, 9999999);
        $city = City::find($request->city_id);  
        $order_id ='#'.Str::upper(substr( $city->name, 0,3)).'-'.$random_number2;    
        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'subtotal'=>$request->sub_total,
            'total'=>$request->sub_total+$request->charge - ($request->discount),
            'charge'=>$request->charge,
            'discount'=>$request->discount,
            'payment_method'=>$request->payment_method,
            'created_at'=>Carbon::now(),
        ]);

        // Billing Details
        BillingDetails::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'name'=>Auth::guard('customerlogin')->user()->name,
            'email'=>Auth::guard('customerlogin')->user()->email,
            'mobile'=>$request->billing_number,
            'company'=>$request->company,
            'address'=>Auth::guard('customerlogin')->user()->address,
            'created_at'=>Carbon::now(),
        ]);
        // Shipping Details
        ShippingDetails::insert([
            'order_id'=>$order_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'address'=>$request->address,
            'zip'=>$request->zip,
            'notes'=>$request->notes,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }


}
