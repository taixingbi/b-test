@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
    <div class="row text-center">
        <h2>Month Details:</h2>
        <h3>From {{ $start_date }} to {{ $end_date }}</h3>
        @hasanyrole('tour_operator')
        <h3>Total Commision Fee (credit card + cash): ${{ (float)$sum+(float)$cash_sum }}</h3>
        @endrole
        @hasanyrole('big_agent')
        <h3>Total Commision Fee (credit card): ${{ (float)$sum }}</h3>
        @endrole
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
                    <th>Agent</th>
                    <th>Customer</th>
                    <th>Total Price</th>
                    @hasanyrole('tour_operator')
                    <th>Commission Fee</th>
                    @endrole
                    <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>
                <?php $idx = 1; ?>

                @foreach($agent_cc_rents as $agent_cc_rent)
                    <tr <?php if($agent_cc_rent->agent_refund==1) echo "style='color:red;'";?> >
                        <th scope="row">{{ $idx++ }}</th>
                        <td>{{ $agent_cc_rent->tix_agent }}</td>
                        <td>{{ $agent_cc_rent->customer_name." ".$agent_cc_rent->customer_lastname }}</td>
                        <td>${{ $agent_cc_rent->total_price_after_tax }}</td>
                        @hasanyrole('tour_operator')
                        <td>${{ number_format(0.3*(float)$agent_cc_rent->total_price_after_tax,2) }}<?php if($agent_cc_rent->agent_refund==1) echo " refunded";?></td>
                        @endrole
                        <td>{{ $agent_cc_rent->completed_at }}</td>
                    </tr>
                @endforeach

                @foreach($agent_cc_tours as $agent_cc_tour)
                    <tr <?php if($agent_cc_tour->agent_refund==1) echo "style='color:red;'";?> >
                        <th scope="row">{{ $idx++ }}</th>
                        <td>{{ $agent_cc_tour->tix_agent }}</td>
                        <td>{{ $agent_cc_tour->customer_name." ".$agent_cc_tour->customer_lastname }}</td>
                        <td>${{ $agent_cc_tour->total_price_after_tax }}</td>
                        @hasanyrole('tour_operator')
                        <td>${{ number_format(0.3*(float)$agent_cc_tour->total_price_after_tax,2) }}<?php if($agent_cc_tour->agent_refund==1) echo " refunded";?></td>
                        @endrole
                        <td>{{ $agent_cc_tour->completed_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @hasanyrole('tour_operator')
        <div class="text-center">
            <h2>Cash</h2>
            <h4>Total Commision Fee (Cash): ${{ $cash_sum }}</h4>
        </div>
        <div >
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr style="background:#38a070;color:white">                    <th>#</th>
                    <th>Agent</th>
                    <th>Customer</th>
                    <th>Total Price</th>
                    <th>Agent charge</th>
                    <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>
                <?php $idx = 1; ?>

                @foreach($agent_cash_rents as $agent_cash_rent)
                    <tr <?php if($agent_cash_rent->agent_refund==1) echo "style='color:red;'";?> >
                        <th scope="row">{{ $idx++ }}</th>
                        <td>{{ $agent_cash_rent->tix_agent }}</td>
                        <td>{{ $agent_cash_rent->customer_name." ".$agent_cash_rent->customer_lastname }}</td>
                        <td>${{ $agent_cash_rent->total_price_after_tax }}</td>
                        <td>${{ $agent_cash_rent->agent_price_after_tax }}<?php if($agent_cash_rent->agent_refund==1) echo " refunded";?></td>
                        <td>{{ $agent_cash_rent->created_at }}</td>
                    </tr>
                @endforeach

                @foreach($agent_cash_tours as $agent_cash_tour)
                    <tr <?php if($agent_cash_tour->agent_refund==1) echo "style='color:red;'";?> >
                        <th scope="row">{{ $idx++ }}</th>
                        <td>{{ $agent_cash_tour->tix_agent }}</td>
                        <td>{{ $agent_cash_tour->customer_name." ".$agent_cash_tour->customer_lastname }}</td>
                        <td>${{ $agent_cash_tour->total_price_after_tax }}</td>
                        <td>${{ $agent_cash_tour->agent_price_after_tax }}<?php if($agent_cash_tour->agent_refund==1) echo " refunded";?></td>
                        <td>{{ $agent_cash_tour->created_at }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endrole
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ URL::to('js/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::to('js/agent-report.js') }}"></script>


@endsection