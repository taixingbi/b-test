@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection
@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.timepicker.min.css') }}" >
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::to('css/rent-main.css') }}" >--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" >

@endsection

@section('nav-buttons')
    @include('bigbike.agent.nav-buttons')
@endsection

@section('content')
    <div >
        <div class="col-md-10 mr-top" >
            <div class="mk-fancy-table mk-shortcode table-style1">
                {{--<div style="width:350px">--}}
                    {{--<input type="text" id="search" placeholder="Search...">--}}
                    {{--<span class="glyphicon glyphicon-search" ></span>--}}
                {{--</div>--}}
                <table id="partner" width="100%" style="margin-top: 10px;">
                    <caption>BIKE RENT</caption>
                    <thead>
                    <tr class="bl">
                        <th >#</th>
                        <th >Date</th>
                        <th >Hours</th>
                        <th >Name</th>
                        {{--<th >Last Name</th>--}}
                        <th >Adult</th>
                        <th >Child</th>
                        <th >Tandem</th>
                        <th >Road</th>
                        <th >Mountain</th>
                        <th >Trailer</th>
                        <th >Drop Off</th>
                        <th >Insurance</th>
                        <th >Amount</th>
                        <th >Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $row = 1;?>
                    @foreach($agent_rent_table as $item)
                        <tr >
                            {{--<tr href='{{route("agent.showReservationDetail",['id'=>$item->id])}}'>--}}
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $row }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->date }}" >{{ $item->date }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->duration }}" >{{ $item->duration }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->customer_name." ".$item->customer_lastname }}</span>
                            </td>
                            {{--<td class="cell-size" >--}}
                                {{--<span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->customer_lastname }}</span>--}}
                            {{--</td>--}}
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->adult }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->child }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->tandem }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->road }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->mountain }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >{{ $item->trailer }}</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >@if($item->dropoff){{ "Yes" }} @else {{ "No" }}@endif</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >@if($item->insurance){{ "Yes" }} @else {{ "No" }}@endif</span>
                            </td>
                            <td class="cell-size" >
                                <span class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->total_price_after_tax }}" >${{ $item->total_price_after_tax }}</span>
                            </td>
                            <td class="cell-size" >
                                <a href='partner-served/{{$item->id}}' class="btn btn-info" role="button">Served</a>

                                {{--<button class="cell-item btn duration-title {{ $row }}0" id="{{ $row }}0" name="duration" value="{{ $item->id }}" >Served</button>--}}
                            </td>
                        </tr>
                        <?php $row++; ?>
                    @endforeach
                    </tbody>
                </table><br>


            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::to('js/agent-reservation.js') }}"></script>
    <script src="{{ URL::to('js/agent-barcode.js') }}"></script>

    <script>
        $(document).ready( function () {
            $('#partner').DataTable();
        } );


        // $("#search").keyup(function(){
        //     _this = this;
        //     // Show only matching TR, hide rest of them
        //     $.each($("table tbody tr"), function() {
        //         if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
        //             $(this).hide();
        //         else
        //             $(this).show();
        //     });
        // });
    </script>

@endsection

