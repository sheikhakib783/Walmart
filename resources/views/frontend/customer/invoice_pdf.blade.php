
<!DOCTYPE html>
<!-- saved from url=(0068)https://cdpn.io/tareqdesign/fullpage/QWWgxWX?anon=true&view=fullpage -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
    <meta name="apple-mobile-web-app-title" content="CodePen">
    <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">
    <link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-b4b4269c16397ad2f0f7a01bcdf513a1994f4c94b8af2f191c09eb0d601762b1.svg" color="#111">
  <title>CodePen - Invoice Template</title>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
*{
  margin: 0;
  box-sizing: border-box;

}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}

#invoiceholder{
  width:100%;
  hieght: 100%;
  padding-top: 50px;
}
#headerimage{
  z-index:-1;
  position:relative;
  top: -50px;
  height: 350px;
  -webkit-box-shadow:inset 0 2px 4px rgba(0,0,0,.15), inset 0 -2px 4px rgba(0,0,0,.15);
	-moz-box-shadow:inset 0 2px 4px rgba(0,0,0,.15), inset 0 -2px 4px rgba(0,0,0,.15);
	box-shadow:inset 0 2px 4px rgba(0,0,0,.15), inset 0 -2px 4px rgba(0,0,0,.15);
  overflow:hidden;
  background-attachment: fixed;
  background-size: 1920px 80%;
  background-position: 50% -90%;
}
#invoice{
  position: relative;
  top: -290px;
  margin: 0 auto;
  width: 700px;
  background: #FFF;
}

[id*='invoice-']{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
  padding: 30px;
}

#invoice-top{min-height: 120px;}
#invoice-mid{min-height: 120px;}
#invoice-bot{ min-height: 250px;}

.logo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
	background-size: 60px 60px;
}
.clientlogo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  float:left;
  margin-left: 20px;
}
.title{
  float: right;
}
.title p{text-align: right;}
#project{margin-left: 52%;}
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  padding: 5px 0 5px 15px;
  border: 1px solid #EEE
}
.tabletitle{
  padding: 5px;
  background: #EEE;
}
.service{border: 1px solid #EEE;}
.item{width: 50%;}
.itemtext{font-size: .9em;}

#legalcopy{
  margin-top: 30px;
}
form{
  float:right;
  margin-top: 30px;
  text-align: right;
}
.effect2
{
  position: relative;
}

.legal{
  width:70%;
}
</style>

  <script>
  window.console = window.console || function(t) {};
</script>

</head>

<body translate="no">
  <div id="invoiceholder">

  <div id="headerimage"></div>
  <div id="invoice" class="effect2">

    <!--Start InvoiceTop-->
    <div id="invoice-top">
      <div class="logo"></div>
      <div class="info">
        <h2>{{App\Models\BillingDetails::where('order_id', $data)->first()->name}}</h2>
        <p> {{App\Models\BillingDetails::where('order_id', $data)->first()->email}} <br>
            {{App\Models\BillingDetails::where('order_id', $data)->first()->mobile}}
        </p>
      </div><!--End Info-->
      <div class="title">
        <h1>Invoice {{$data}}</h1>
        <p>Issued:{{App\Models\Order::where('order_id', $data)->first()->created_at->format('d-M-Y')}}        
        </p>
      </div><!--End Title-->
    </div><!--End InvoiceTop-->   
    <div id="invoice-bot">      
      <div id="table">
        <table>
          <tbody><tr class="tabletitle">
            <td class="item"><h2>Item Description</h2></td>
            <td class="Hours"><h2>Quantity</h2></td>
            <td class="Rate"><h2>Price</h2></td>
            <td class="subtotal"><h2>Sub-total</h2></td>
          </tr>
          @foreach (App\Models\OrderProduct::where('order_id', $data)->get() as $product) 
          <tr class="service">
            <td class="tableitem"><p class="itemtext">{{$product->rel_to_product->product_name}}</p></td>
            <td class="tableitem"><p class="itemtext">{{$product->quantity}}</p></td>
            <td class="tableitem"><p class="itemtext">TK{{$product->price}}</p></td>
            <td class="tableitem"><p class="itemtext">TK{{$product->price*$product->quantity}}</p></td>
          </tr>
          @endforeach          
          <tr class="tabletitle">
            <td><h2>Discount:TK{{App\Models\Order::where('order_id', $data)->first()->discount}}</h2></td>
            <td><h2>Charge:TK{{App\Models\Order::where('order_id', $data)->first()->charge}}</td>
            <td class="Rate"><h2>Total</h2></td>
            <td class="payment"><h2>TK{{App\Models\Order::where('order_id', $data)->first()->total}}</h2></td>
          </tr>
          
        </tbody></table>
      </div><!--End Table-->
      
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="QRZ7QTM9XRPJ6">
      <input type="image" src="./paypal.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    </form>
      <div id="legalcopy">
        <p class="legal"><strong>Thank you for your business!</strong>&nbsp; Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices. 
        </p>
      </div>
    </div><!--End InvoiceBot-->
  </div><!--End Invoice-->
</div><!-- End Invoice Holder-->
</body></html>