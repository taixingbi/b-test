@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection
@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.timepicker.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/rent-main.css') }}" >

@endsection

@section('nav-buttons')
    @include('bigbike.agent.nav-buttons')
@endsection

@section('content')
    <br><br>
    @if(Session::has('rent_price_error'))
        <br>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="price-error" class="alert alert-warning">
                    {{ Session::get('rent_price_error') }}
                    {{ Session::forget('rent_price_error') }}
                </div>
            </div>
        </div><br>
    @endif

    @if(Session::has('error'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="price-error" class="alert alert-warning">
                    {{ Session::get('error') }}
                    {{ Session::forget('error') }}
                </div>
            </div>
        </div>

    @endif

    <br><br><br>

    <div >
        <div class="col-md-11 mr-top" >
            <h2>BIKE RENTAL PRICE CHART</h2>
            <p class="text-center" style="font-size: medium;">
                In this table, you can choose the type of bike, quantity of bikes, and how many hours a customer would like the bike for.
            </p>
            <p class="text-center" style="font-size: medium;">
                In order to proceed, you must choose the Hours first. After you have selected the hours, you have to click on
                the respective price for however many bikes, that are required by the customer. Once the amount of Bikes and the Hours
                are selected, fill in the customer information below the table, and proceed to checkout.
            </p>


            <div class="mk-fancy-table mk-shortcode table-style1">
                {{--<h4>BICYCLE RENTAL</h4>--}}
                <span>
                  Choose Hours First <span style="color:red">*</span><br>
                    Click Button to Add Bike<span style="color:red"> *</span>
                </span>

                <table width="100%" style="margin-top: 10px;">
                    <thead>
                    <tr class="bl">
                        <th >HOURS</th>
                        <th >Adult Bike</th>
                        <th >Child Bike</th>
                        <th >Tandem Bike</th>
                        <th >Road Bike</th>
                        <th >Mountain Bike</th>
                        <th >Basket</th>
                        <th >Trailer</th>
                        <th >Baby Seat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $row = 0;?>
                    @foreach($agent_rent_table as $item)
                        <tr>
                            <td class="cell-size" >
                                <button class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="@if($item->title!='all day'){{ $item->title }}@else{{'All Day (8am-8pm)'}}@endif" onclick="">{{ $item->title }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}1" id="{{ $row }}1" name="adult" value="{{ number_format($rate*$item->adult,2) }}" onclick="getPrice(this,'#adult');">&#36;{{ number_format($rate*$item->adult,2) }}</button>
                                {{--<h5 class="cell-item">${{ $item->adult }}</h5>--}}
                                {{--<button class="cell-item" name="adult" value="{{ $item->adult }}">+</button>--}}
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}2" id="{{ $row }}2" name="child" value="{{ number_format($rate*$item->child,2) }}" onclick="getPrice(this,'#child');">&#36;{{ number_format($rate*$item->child,2) }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}3" id="{{ $row }}3" name="tandem" value="{{ number_format($item->tandem,2) }}" onclick="getPrice(this,'#tandem');">&#36;{{ number_format($item->tandem,2) }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}4" id="{{ $row }}4" name="road" value="{{ number_format($item->road,2) }}" onclick="getPrice(this,'#road');">&#36;{{ number_format($item->road,2) }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}5" id="{{ $row }}5" name="mountain" value="{{ number_format($item->mountain,2) }}" onclick="getPrice(this,'#mountain');">&#36;{{ number_format($item->mountain,2) }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}6" id="{{ $row }}6" name="basket" value="{{ $item->basket }}" onclick="getPrice(this,'#basket');">&#36;{{ $item->basket }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}7" id="{{ $row }}7" name="trailer" value="{{ $item->trailer }}" onclick="getPrice(this,'#trailer');">&#36;{{ $item->trailer }}</button>
                            </td>
                            <td class="cell-size">
                                <button class="cell-item btn btn-default {{ $row }}8" id="{{ $row }}8" name="seat" value="{{ $item->seat }}" onclick="getPrice(this,'#seat');">&#36;{{ $item->seat }}</button>
                            </td>
                        </tr>
                        <?php $row++; ?>
                    @endforeach
                    </tbody>
                </table><br>
                <span>
                  Make sure the Time and Date are correct <span style="color:red">*</span><br>
                </span>
            </div>
        </div>
    </div>
    @include('bigbike.agent.rent-main-order')


@endsection


@section('scripts')
@endsection