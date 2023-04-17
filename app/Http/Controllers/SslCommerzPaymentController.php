<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\CustomerInvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Customerlogin;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ShippingDetails;
use App\Models\SslOrder;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {

        $data = session('data');
        $amount = $data['sub_total']+$data['charge']-$data['discount'];
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.

        // SSL Insert Database
        $customer_id = $data['customer_id'];
        $amount = $data['sub_total']+$data['charge'];
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => Customerlogin::find($customer_id)->name,
                'email' => Customerlogin::find($customer_id)->email,
                'phone' => $data['mobile'],
                'amount' => $amount,
                'status' => 'Pending',
                'address' =>Customerlogin::find($customer_id)->address,
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'customer_id' => $data['customer_id'],
                'shipping_name' => $data['name'],
                'shipping_email' => $data['email'],
                'shipping_phone' => $data['mobile'],
                'company' => $data['company'],
                'country_id' => $data['country_id'],
                'city_id' => $data['city_id'],
                'shipping_address' => $data['address'],
                'zip_code' => $data['zip'],
                'notes' => $data['notes'],
                'sub_total' => $data['sub_total'],
                'discount' => $data['discount'],
                'charge' => $data['charge'],
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
       

        $tran_id = $request->input('tran_id');
        $data = SslOrder::where('transaction_id', $tran_id)->get();
        $random_number2 = random_int(1000000, 9999999);
        $city = City::find($data->first()->city_id);  
        $order_id ='#'.Str::upper(substr( $city->name, 0,3)).'-'.$random_number2; 

        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>$data->first()->customer_id,
            'subtotal'=>$data->first()->sub_total,
            'total'=>$data->first()->amount,
            'charge'=>$data->first()->charge,
            'discount'=>$data->first()->discount,
            'payment_method'=>2,
            'created_at'=>Carbon::now(),
        ]);

        // Billing Details
        BillingDetails::insert([
            'order_id'=>$order_id,
            'customer_id'=>$data->first()->customer_id,
            'name'=>$data->first()->name,
            'email'=>$data->first()->email,
            'mobile'=>$data->first()->phone,
            'company'=>$data->first()->company,
            'address'=>$data->first()->address,
            'created_at'=>Carbon::now(),
        ]);
        // Shipping Details
        ShippingDetails::insert([
            'order_id'=>$order_id,
            'name'=>$data->first()->shipping_name,
            'email'=>$data->first()->shipping_name,
            'mobile'=>$data->first()->shipping_phone,
            'country_id'=>$data->first()->country_id,
            'city_id'=>$data->first()->city_id,
            'address'=>$data->first()->shipping_address,
            'zip'=>$data->first()->zip,
            'notes'=>$data->first()->notes,
            'created_at'=>Carbon::now(),
            
        ]);
        // Order Product
        $carts = Cart::where('customer_id', $data->first()->customer_id)->get();

        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->first()->customer_id,
                'product_id'=>$cart->product_id,
                'price'=>$cart->rel_to_product->after_discount,
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'quantity'=>$cart->quantity,
                'created_at'=>Carbon::now(),
            ]);

            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

            // Cart::find($cart->id)->delete();
        } 
        $mail = $data->first()->email;
        Mail::to($mail)->send(new CustomerInvoiceMail($order_id));

        // Mobile SMS Code
                                    
                $total =$data->first()->amount;

                // $url = "http://bulksmsbd.net/api/smsapi";
                // $api_key = "VywwqwoTzPxKRcMT1CVw";
                // $senderid = "akib sheikh";
                // $number = $request->billing_number;
                // $message = "Congratulations! Your order has been placed! Please ready TK ".$total;
            
                // $data = [
                //     "api_key" => $api_key,
                //     "senderid" => $senderid,
                //     "number" => $number,
                //     "message" => $message
                // ];
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                // $response = curl_exec($ch);
                // curl_close($ch);

                // // old
                //    $total = $request->sub_total+$request->charge - ($request->discount);
                //     $url = "http://66.45.237.70/api.php";
                //     $number=$request->billing_number;
                //     $text="Congratulations! Your order has been placed! Please ready TK ".$total;
                //     $data= array(
                //     'username'=>"01834833973",
                //     'password'=>"TE47RSDM",
                //     'number'=>"$number",
                //     'message'=>"$text"
                //     );

                    
                //     $ch = curl_init(); // Initialize cURL
                //     curl_setopt($ch, CURLOPT_URL,$url);
                //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //     $smsresult = curl_exec($ch);
                //     $p = explode("|",$smsresult);
                //     $sendstatus = $p[0];
                                            

        $order_id_new = substr($order_id, 1);       
        return redirect()->route('order.success', $order_id_new)->withOrdersuccess('Cart Added!');  
        
        // $amount = $request->input('amount');
        // $currency = $request->input('currency');

        // $sslc = new SslCommerzNotification();

        // #Check order status in order tabel against the transaction id or order id.
        // $order_details = DB::table('sslorders')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'amount')->first();

        // if ($order_details->status == 'Pending') {
        //     $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        //     if ($validation) {
        //         /*
        //         That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
        //         in order table as Processing or Complete.
        //         Here you can also sent sms or email for successfull transaction to customer
        //         */
        //         $update_product = DB::table('sslorders')
        //             ->where('transaction_id', $tran_id)
        //             ->update(['status' => 'Processing']);

        //         echo "<br >Transaction is successfully Completed";
        //     }
        // } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
        //     /*
        //      That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
        //      */
        //     echo "Transaction is successfully Completed";
        // } else {
        //     #That means something wrong happened. You can redirect customer to your product page.
        //     echo "Invalid Transaction";
        // }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('sslorders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
