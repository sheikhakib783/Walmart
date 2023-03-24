<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class CustomerController extends Controller
{
    function customer_reg_log(){
        return view('frontend.customer.register_login');
    }

    // Customer Register
    function customer_reg_store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

       Customerlogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_at'=>Carbon::now(),
       ]);
        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect('/');
        }
    }

    // Customer Login
    function customer_login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect('/');
        }
        else{
            return back()->with('wrong', 'Wong Credential');
        }
    }
    // Customer Logout
    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }

    // Customer Profile
    function customer_profile(){
        return view('frontend.customer.profile');
    }

    // Customer Update
    function customer_profile_update(Request $request){
        // if Photo not exit
        if($request->photo == ''){
            if($request->password == ''){
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                ]);
                return back();
            }
            else{
                if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>Hash::make($request->password),
                    ]);
                }
                else{
                    return back()->with('old', 'Current Password Wrong');
                }
            }
        }
        
        // if Photo exit
        else{
            if($request->password == ''){
                $photo = $request->photo;
                $extension = $photo->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id(). '.'.$extension;

                Image::make($photo)->save(public_path('uploads/customer/' .$file_name));             

                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back();
            }
            else{
                if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                    $photo = $request->photo;
                    $extension = $photo->getClientOriginalExtension();
                    $file_name = Auth::guard('customerlogin')->id(). '.'.$extension;

                    Image::make($photo)->save(public_path('uploads/customer/' .$file_name));   
                    
                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>Hash::make($request->password),
                        'photo'=>$file_name,
                    ]);
                }
                else{
                    return back()->with('old', 'Current Password Wrong');
                }
            }
        }
    }
// MyOrder
    function myorder(){
        $myorder = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer.myorder', [
            'myorder'=>$myorder
        ]);
    }
}
