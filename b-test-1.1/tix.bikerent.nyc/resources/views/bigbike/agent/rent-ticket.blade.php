@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection

@section('styles')
    <link rel="stylesheet" media="print" href="{{ URL::to('css/print.css') }}">
    <style>
        footer{
            display: none;
        }
    </style>
@endsection

@section('content')


    @if(Session::has('rent_success'))
        {{ Session::forget('rent_success') }}
        <div class="container">
            <div class="row">
                <span style="position: absolute;zoom: 140%;"><img src="{{ URL::to('images/central.jpg')}}"></span>

                <div class="ticket-rec" style="position: absolute">
                    <div style="display: inline">
                        <span style="float:right"><img src="{{ URL::to('images/favicon.png')}}" height="90px" width="90px" ></span></div>
                    <span style="font-size:18px" class="font700">Bike Rent Ticket</span><br><br>
                    <div>
                        <div style="max-width:650px;" class="table-ticket" style="z-index:15;">
                            <div class="col-md-6 col-sm-6">
                                <div class="font700">Payment :</div>
                                <div>Order Complated At: {{ $agent_rents_order['time'] }}</div>
                                <div>Agent: {{ $agent_rents_order['tix_agent'] }}</div>
                                <div>Payment Type: {{ $agent_rents_order['payment_type'] }}</div>
                                {{--<div>Total: ${{ $agent_rents_order['total_price_before_tax'] }}</div>--}}
                                {{--<div>Tax: ${{ number_format(floatval($agent_rents_order['total_price_before_tax'])*.08875,2) }}</div>--}}

                                <div>Total price: ${{ $agent_rents_order['total_price_after_tax'] }} </div>
                                <div>Deposit: ${{ $agent_rents_order['agent_price_after_tax'] }} </div>
                                <div>Payment Due in Store: ${{ floatval($agent_rents_order['total_price_after_tax'])-floatval($agent_rents_order['agent_price_after_tax']) }}</div><br><br>

                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="font700">Rent Info :</div>
                                <div>Customer: {{ $agent_rents_order['customer_name'] }}  </div>
                                <div>Email: {{ $agent_rents_order['customer_email'] }}  </div>
                                <div>Rent Date: {{ $agent_rents_order['date'] }}</div>
                                {{--<div>Rent Time: {{ $agent_rents_order['time'] }}</div>--}}
                                {{--<div>Rent Type: {{ $agent_rents_order['rent_type'] }}</div>--}}
                                <div>Duration:{{ $agent_rents_order['duration'] }}</div>
                                @if( $agent_rents_order['adult'] !='0')<div> Adult Bike: {{ $agent_rents_order['adult'] }}</div>@endif
                                @if( $agent_rents_order['child']!='0')<div>Children Bike: {{ $agent_rents_order['child'] }}</div>@endif
                                @if( $agent_rents_order['road']!='0' )<div> Road Bike:{{ $agent_rents_order['road'] }}</div>@endif
                                @if( $agent_rents_order['mountain']!='0' )<div> Mountain Bike:{{ $agent_rents_order['mountain'] }}</div>@endif
                                @if( $agent_rents_order['tandem']!='0' )<div> Tandem Bike:{{ $agent_rents_order['tandem'] }}</div>@endif
                                @if( $agent_rents_order['trailer']!='0' )<div>Trailer:{{ $agent_rents_order['trailer'] }}</div>@endif
                                @if( $agent_rents_order['seat']!='0' )<div> Baby Seat:{{ $agent_rents_order['seat'] }}</div>@endif
                                @if($agent_rents_order['basket']!='0' )<div>Basket: {{ $agent_rents_order['basket'] }}</div>@endif
                                Total Bikes: {{ $agent_rents_order['total_bikes'] }}<br><br>
                                <div>Insurance: @if($agent_rents_order['insurance']=='1') Yes @else No @endif </div>
                                <div>Drop off: @if($agent_rents_order['dropoff']=='1') Yes @else No @endif</div>
                                <div>@if( $agent_rents_order['comment'])Comment: {{ $agent_rents_order['comment'] }}</div>@endif

                            </div>
                        </div>
                        {{--<table style="max-width:650px;" class="table-ticket" style="z-index:15;">--}}
                        {{--<tr>--}}
                        {{--<th>Payment :</th>--}}
                        {{--<th>Date & time : </th>--}}
                        {{--<th>Order :</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Order Complated At: {{ $agent_rents_order['completed_at'] }}</td>--}}
                        {{--<td>Customer: {{ $agent_rents_order['customer_name'] }}  </td>--}}
                        {{--<td>Customer Email: {{ $agent_rents_order['customer_email'] }}  </td>--}}

                        {{--<td>@if ( $agent_rents_order['adult'] !='0') Adult Bike: {{ $agent_rents_order['adult'] }}@endif--}}
                        {{--</td>--}}

                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Agent Email: {{ $agent_rents_order['agent_email'] }}</td>--}}
                        {{--<td>Rent Date: {{ $agent_rents_order['date'] }}--}}
                        {{--</td>--}}
                        {{--<td>Insurance: @if($agent_rents_order['insurance']=='1') Yes @else No @endif </td>--}}
                        {{--<td>@if ( $agent_rents_order['child']!='0')Children Bike: {{ $agent_rents_order['child'] }}@endif--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Payment Type: {{ $agent_rents_order['payment_type'] }}</td>--}}
                        {{--<td>Rent Time: {{ $agent_rents_order['time'] }}--}}
                        {{--</td>--}}
                        {{--<td>Basket: {{ $agent_rents_order['basket'] }}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Total price: {{ $agent_rents_order['total_price_after_tax'] }} </td>--}}
                        {{--<td>Duration:{{ $agent_rents_order['duration'] }}</td>--}}
                        {{--<td>--}}
                        {{--Drop off: @if($agent_rents_order['dropoff']=='1') Yes @else No @endif--}}
                        {{--</td>--}}

                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td></td>--}}
                        {{--<td>@if ( $agent_rents_order['road']!='0' ) Road Bike:{{ $agent_rents_order['road'] }} @endif--}}
                        {{--</td>--}}

                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Agent charged: {{ $agent_rents_order['agent_price_after_tax'] }}</td>--}}
                        {{--<td>@if ( $agent_rents_order['seat']!='0' ) Baby Seat:{{ $agent_rents_order['seat'] }} @endif--}}
                        {{--</td>--}}
                        {{--</tr>--}}



                        {{--<tr>--}}
                        {{--<td></td>--}}
                        {{--<td>@if ( $agent_rents_order['tandem']!='0' ) Tandem Bike:{{ $agent_rents_order['tandem'] }} @endif--}}
                        {{--</td>--}}

                        {{--<td>@if ( $agent_rents_order['trailer']!='0' ) Trailer:{{ $agent_rents_order['trailer'] }} @endif--}}


                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td></td>--}}
                        {{--<td></td>--}}
                        {{--<td>@if ( $agent_rents_order['mountain']!='0' ) Mountain Bike:{{ $agent_rents_order['mountain'] }} @endif--}}

                        {{--</table>--}}
                    </div>
                    <div class="barcode">
                        <?php
                        //                        echo DNS1D::getBarcodeHTML($agent_rents_order['barcode'], "C39");

                        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($agent_rents_order['barcode'], "C39") . '" alt="barcode"   />';

                        ?></div>

                </div>
            </div>
        </div>
    @else
        <div>No Transaction!</div>
    @endif
@endsection
@section('scripts')
    <script>
        window.onload = function() { window.print(); }
    </script>

@endsection
