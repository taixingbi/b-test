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
    @if(Session::has('tour_price_error'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="price-error" class="alert alert-warning">
                    {{ Session::get('tour_price_error') }}
                    {{ Session::forget('tour_price_error') }}
                </div>
            </div>
        </div>

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
    <br><br>
    <div>

        <div class="col-md-11 mr-top">
            <h2>BIKE TOUR PRICE CHART</h2>
            <p class="text-center" style="font-size: large;">
                In this table, you can choose the type of tour, the length of the tour (only applicable for private tours),
                and how many customers would like to go on the tour.</p>
            <p class="text-center" style="font-size: large;">
                Select the tour type and then click on how many Adults and Children will be going on that tour.</p>
            </p>
            <div class="mk-fancy-table mk-shortcode table-style1">

                <span>
                  Choose Tour Type First <span style="color:red">*</span><br>
                    Click Button to Add Bike<span style="color:red"> *</span>
                </span>
                <table width="100%" style="margin-top: 10px;">
                    <thead>
                    <tr class="bl2">
                        <th >Tour Type</th>
                        <th >Adult</th>
                        <th >Child</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $row = 0;?>
                    @foreach($agent_tour_table as $item)
                        <tr>
                            <td class="cell-size" >
                                <button class="cell-item btn btn-default btn-green tour-title " id="{{ $row }}0" value="{{ $item->title }}">{{ $item->title }}</button>
                            </td>
                            <td class="cell-size" >
                                <button class="cell-item btn btn-default btn-green " id="{{ $row }}1" value="{{ number_format($rate*$item->adult,2) }}" onclick="getPrice(this,'#adult');">${{ number_format($rate*$item->adult,2) }}</button>
                            </td>
                            <td class="cell-size" >
                                <button class="cell-item btn btn-default btn-green " id="{{ $row }}2" value="{{ number_format($rate*$item->child,2) }}" onclick="getPrice(this,'#child');">${{ number_format($rate*$item->child,2) }}</button>
                            </td>
                        </tr>
                        <?php $row++; ?>
                    @endforeach
                    </tbody>
                </table><br>
            </div>
        </div>
    </div>

    @include('bigbike.agent.tour-main-order')
    
@endsection


@section('scripts')
@endsection