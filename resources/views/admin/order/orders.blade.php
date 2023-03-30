@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Order List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $order)                                            
                    <tr>
                        <td>{{$order->order_id}}</td>
                        <td>&#2547;{{$order->total}}</td>
                        <td>{{$order->created_at->diffForHumans()}}</td>
                        <td>
                            @if ($order->payment_method == 1)
                                <div class="badge badge-primary">Cash On Delivery</div>
                            @elseif ($order->payment_method == 1)   
                            <div class="badge badge-primary">SSL Comerze</div>
                            @else
                            <div class="badge badge-primary">Strip</div>                    
                            @endif
                        </td>
                        <td>
                            @php
                                if($order->status == 0){
                                    echo '<span class="badge badge-primary">Placed</span>';
                                }
                                elseif ($order->status == 1) {
                                    echo '<span class="badge badge-primary">Processing</span>';
                                }
                                elseif ($order->status == 2) {
                                    echo '<span class="badge badge-primary">Pick Up</span>';
                                }
                                elseif ($order->status == 3) {
                                    echo '<span class="badge badge-primary">Ready to Delivery</span>';
                                }
                                elseif ($order->status == 4) {
                                    echo '<span class="badge badge-primary">Delivered</span>';
                                }
                                else {
                                   'NA';
                                }
                            @endphp
                        </td>
                        <td>
                            <div class="dropdown mb-2">
                               <form action="{{route('status.update')}}" method="POST">
                                @csrf
                                    <input type="hidden" name="order_id" value="{{$order->order_id}}">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <button value="0" name="status" class="dropdown-item d-flex align-items-center" href=""><span class="">Placed</span></button>                                  
                                        <button value="1" name="status" class="dropdown-item d-flex align-items-center" href=""><span class="">Processing</span></button>                                  
                                        <button value="2" name="status" class="dropdown-item d-flex align-items-center" href=""><span class="">Pick Up</span></button>                                  
                                        <button value="3" name="status" class="dropdown-item d-flex align-items-center" href=""><span class="">Redy to Delivery</span></button>                                  
                                        <button value="4" name="status" class="dropdown-item d-flex align-items-center" href=""><span class="">Delivered</span></button>                                  
                                    </div>
                               </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection