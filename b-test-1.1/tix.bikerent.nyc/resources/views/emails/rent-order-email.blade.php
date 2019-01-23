<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://tix.bikerent.nyc/css/agent-order.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>
        body{ background-color: #f5f8fa;}
        .logo{
            padding: 15px;
            display: inline-block;
            text-decoration: none;
            min-width: 100px;

        }
    </style>
</head>
<div class="header">
    <a href="https://tix.bikerent.nyc/bigbike/agent/main"><img src="https://tix.bikerent.nyc/images/favicon-small.png" alt="" style="float: left;"></a>
    <a class="logo" href="https://tix.bikerent.nyc/bigbike/agent/main"><font color="#61982d">BIKE</font><font color="#676767">RENT</font><font color="green">.</font><font color="black">NYC</font></a>

</div>
<body>

<div class="logo2">
    <img src="{{ URL::to('images/favicon.png') }}" width="200px" height="200px"></div>

<h3>Welcome to {!! $name !!} website!</h3><br>
<h3>Congratulations, your order has been complete!</h3>
<h3>Voucher Valids for 1 Year from {{ $completed_at }}</h3>

Bike Rent: <br><br>
Purchased At: {{ $completed_at }}<br><br>
Agent: {{ $agent_email }}<br><br>

Payment Type: {{ $payment_type }}<br><br>
{{--Total: ${{ $agent_rents_order['total_price_before_tax'] }}<br><br>--}}
{{--Tax: ${{ number_format(floatval($agent_rents_order['total_price_before_tax'])*.08875,2) }}<br><br>--}}
Total after Tax: ${{ $total_price_after_tax }}<br><br>
{{--Agent charged: ${{ $agent_price_after_tax }}<br><br>--}}
@if($payment_type=='cash') Payment Due In Store due: ${{ floatval($total_price_after_tax)-floatval($agent_price_after_tax) }}<br><br> @endif

<?php
//echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($barcode, "C39") . '" alt="barcode"   />';
//echo '<img src={{ URL::to('images/favicon.png') }}  />';

//echo DNS1D::getBarcodeHTML($barcode, "C39");

?>
{{--Another: --}}
{{--<img src="{{ $message->embed(DNS1D::getBarcodeHTML($barcode, "C39+")) }}">--}}

<br><br>
Customer: {{ $customer_name.' '.$customer_lastname }}<br><br>
Customer Email: {{ $customer_email }}<br><br>

Rent Date: {{ $date }}<br><br>
Rent Time: {{ $time }}<br><br>
Duration:{{ $duration }}<br><br>

@if( $adult='0')Adult Bike: {{ $adult }}<br><br>@endif
@if( $child='0')Children Bike: {{ $child }}<br><br>@endif
@if( $tandem!='0')Tandem Bike: {{ $tandem }}<br><br>@endif
@if( $road!='0')Road Bike: {{ $road }}<br><br>@endif
@if( $mountain!='0')Mountain Bike: {{ $mountain }}<br><br>@endif
@if( $trailer!='0')Trailer: {{ $trailer }}<br><br>@endif
@if( $seat!='0')Baby Seat: {{ $seat }}<br><br>@endif
@if( $basket!='0')Basket: {{ $basket }}<br><br>@endif

Drop off: @if($dropoff=='1') Yes @else No @endif<br><br>
Insurance: @if($insurance=='1') Yes @else No @endif<br><br>
Barcode: <img src={{ URL::to('images/barcode/rent/'.$barcode.'.png') }} /><br><br>

</div>



</body>
</html>
