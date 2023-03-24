<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
   function orders(){
    $orders = Order::all();
    return view('admin.order.orders', [
        'orders'=>$orders,
    ]);
   }
}
