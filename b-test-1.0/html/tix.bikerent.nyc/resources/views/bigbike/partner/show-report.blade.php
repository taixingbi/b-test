@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mr-top text-center">
            <h2>PARTNER REPORT</h2>

            <form action="{{ route('partner.showReport') }}" id="payment-form" method="post">
                {{--<div class="col-md-4">--}}

                <label id="start_date_label" style="margin-right:60px;">
                    <h4>Start Month</h4><br>

                    <input name="start_date" id="start_date" class="datepicker field is-empty datepickermonth"/>
                </label>
                {{--</div>--}}
                {{--<div class="col-md-4">--}}
                <label id="end_date_label">
                    <h4>End Month</h4><br>

                    <input name="end_date" id="end_date" class="datepicker datepickermonth" type="text" />
                </label><br>
                {{--</div>--}}
                {{ csrf_field() }}
                {{--<div class="col-md-4">--}}
                <br><br>
                <button type="submit" class="btn btn-primary" id="submit" >Get Report</button>
                {{--</div>--}}
            </form>
        </div>
    </div>

    @if(isset($search))
    <div class="row text-center">
        <h2>Month Details:</h2>
        <h3>From {{ $start_date }} to {{ $end_date }}</h3>
        {{--@hasanyrole('store_partner')--}}
        {{--<h3>Total Commision Fee (credit card + cash): ${{ (float)$sum }}</h3>--}}
        {{--@endrole--}}
        @role('admin')
        <h3>Total Commision Fee Needs to Paid (credit card): ${{ (float)$sum }}</h3>
        @endrole

        <div class="text-center">
            <h2>Credit Card</h2>
            <h4>Total Commision Fee (credit card): ${{ $sum }}</h4>
        </div>

        <div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr style="background:#38a070;color:white">
                    <th>#</th>
                    <th>Location</th>
                    <th>Customer Name</th>
                    <th>Total Price</th>
                    <th>Commission Fee</th>
                    <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>
                <?php $idx = 1; ?>

                @foreach($agent_cc_rents as $agent_cc_rent)
                    <tr <?php if($agent_cc_rent->agent_refund==1) echo "style='color:red;'";?> >
                        <th scope="row">{{ $idx++ }}</th>
                        <td>{{ $agent_cc_rent->location }}</td>
                        <td>{{ $agent_cc_rent->customer_name." ".$agent_cc_rent->customer_lastname }}</td>
                        <td>${{ $agent_cc_rent->total_price_after_tax }}</td>
                        <td>${{ number_format(0.5*(float)$agent_cc_rent->total_price_after_tax,2) }}<?php if($agent_cc_rent->agent_refund==1) echo " refunded";?></td>
                        <td>{{ $agent_cc_rent->created_at }}</td>
                    </tr>
                @endforeach

                @foreach($agent_cc_tours as $agent_cc_tour)
                    <tr <?php if($agent_cc_tour->agent_refund==1) echo "style='color:red;'";?> >
                        <th scope="row">{{ $idx++ }}</th>
                        <td>{{ $agent_cc_tour->location }}</td>
                        <td>{{ $agent_cc_rent->customer_name." ".$agent_cc_rent->customer_lastname }}</td>

                        <td>${{ $agent_cc_tour->total_price_after_tax }}</td>
                        <td>${{ number_format(0.5*(float)$agent_cc_tour->total_price_after_tax,2) }}<?php if($agent_cc_tour->agent_refund==1) echo " refunded";?></td>
                        <td>{{ $agent_cc_tour->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>
    @endif
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ URL::to('js/jquery.timepicker.js') }}"></script>

    <script src="{{ URL::to('js/agent-rent-order.js') }}"></script>
    <script src="{{ URL::to('js/agent-report.js') }}"></script>

@endsection