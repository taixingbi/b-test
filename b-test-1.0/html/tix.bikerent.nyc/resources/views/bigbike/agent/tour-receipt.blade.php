@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection

@section('styles')
    <link rel="stylesheet" media="print" href="{{ URL::to('css/print.css') }}">
@endsection

@section('content')
    @if(Session::has('tour_success'))
        {{ Session::forget('tour_success') }}
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div style="display:flex;">
                    <div class="text-right" ><button class="btn btn-success"  onclick="window.print() ">Print Receipt</button> </div>
                    <div class="text-right" style="margin-left: 30%"><button class="btn btn-success"  onclick="window.location='{{ route('agent.tourTicket') }}' ">Print Ticket</button> </div><br>
                </div>
                <div id="charge-message" class="">


                    {{--<img src="data:image/png;base64,{{DNS1D::getBarcodeSVG($barcode, 'PHARMA2T')}}" alt="barcode" /><br><br>--}}
                    {{--<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode, "C39+") }}" alt="barcode" /><br><br>--}}

                    Bike Tour: <br><br>

                    Order Complated At: {{ $agent_tours_order['real_time'] }}<br><br>
                    Agent: {{ $agent_tours_order['tix_agent'] }}<br><br>
                    Payment Type: {{ $agent_tours_order['payment_type'] }}<br><br>
                    {{--Total: ${{ $agent_tours_order['total_price_before_tax'] }}<br><br>--}}
                    {{--Tax: ${{ number_format(floatval($agent_tours_order['total_price_before_tax'])*.08875,2) }}<br><br>--}}
                    Total after Tax: ${{ $agent_tours_order['total_price_after_tax'] }}<br><br>
                    Deposit: ${{ $agent_tours_order['agent_price_after_tax'] }}<br><br>
                    Payment Due in Store: ${{ floatval($agent_tours_order['total_price_after_tax'])-floatval($agent_tours_order['agent_price_after_tax']) }}<br><br>

                    Barcode:
                    <?php
                        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($agent_tours_order['barcode'], "C39") . '" alt="barcode"   />';

                    //                    echo DNS1D::getBarcodeHTML($agent_tours_order['barcode'], "C39");
                    //                    echo DNS1D::getBarcodeSVG($agent_tours_order['barcode'], "PHARMA2T");

                    ?>
                    <br><br>

                    Customer: {{ $agent_tours_order['customer_name'].' '.$agent_tours_order['customer_lastname'] }}<br><br>
                    Customer Email: {{ $agent_tours_order['customer_email'] }}<br><br>

                    Tour Type: {{ $agent_tours_order['tour_type'] }}<br><br>
                    Rent Date: {{ $agent_tours_order['date'] }}<br><br>
                    Rent Time: {{ $agent_tours_order['time'] }}<br><br>

                    Adult: {{ $agent_tours_order['adult'] }}<br><br>
                    Children: {{ $agent_tours_order['child'] }}<br><br>
                    Total: {{ $agent_tours_order['total_people'] }}<br><br>
                    @if( $agent_tours_order['comment'])Comment: {{ $agent_tours_order['comment'] }}<br><br>@endif

                </div>
                <div class="print-colf">

                    <u>Activity:</u>
                    I have chosen to rent and participate in bike rental services (hereinafter referred to
                    as “the Activity”, which is organized by Central Park Bike Tours (hereinafter referred
                    to as “CPBT”) I understand that the Activity is inherently hazardous and I may be exposed
                    to dangers and hazards, including some of the following: falls, injuries associated with a
                    fall, injuries from lack of fitness, death, equipment failures and negligence of others.
                    As a consequence of these risks, I may be seriously hurt or disabled or may die from the
                    resulting injuries and my property may also be damaged.
                    In consideration of the permission to participate in the Activity, I agree to the terms
                    contained in this contract. I agree to follow the rules and directions for the Activity,
                    including any New York State traffic laws and
                    park rules
                    <br><br>
                    <u>Liability:</u>
                    All adult customers assume full liability and ride at their own risk. If you feel that you
                    or anyone in your party cannot operate a bicycle safely and competently, that person should
                    not rent or ride a bicycle. All children are to be supervised at all times by their parents
                    or an adult over the age of 18.
                    Children under the age of 14 must wear a helmet pursuant to New York State Law.
                    With the purchase of bicycle services, you hereby release and hold harmless from all
                    liabilities, causes of action, claims and demands that may arise in any way from injury,
                    death, loss or harm that may occur. This release does not extend to any claims for gross
                    negligence, intentional or reckless misconduct.
                    I acknowledge that CPBT has no control over and assumes no responsibility for the actions
                    of any independent contractors providing any services
                    for the Activity
                    <br><br>
                    <u>Bike Rental Insurance:</u>
                    Bike rental insurance is available at additional cost. Customers who had purchased Bike
                    Rental Insurance are indemnified and protected against 100% of the cost of damages and
                    repairs; Customers are not responsible for costs of repairs to damages bicycles during
                    normal use, wear and tear, lost or stolen bicycle when they purchase Bike Rental Insurance.
                    Bike Rental Insurance does not indemnify for any cost or liability that arises as a result
                    of personal injury, coverage shall apply only to property damage. Bike Rental Insurance
                    includes damaged bike-pick up within Central Park only.
                    <br><br>
                    <u>Late Fee:</u>
                    A 15-minute grace period shall be allowed for the return of bicycles following the cessation
                    of bike rental period, with no late fee charged. If you do not return any bicycle or child
                    seat for any reason before that 15-minute grace period, the hourly late fee begins calculating
                    and you will be required to pay an appropriate late fee. Late Fee Prices: Adult Bikes, Child
                    Bikes and Child Bike Trailers = $10 per bike-per hour; Tandem Bikes, Road Bikes, Mountain
                    Bikes and Hand-cycles = $20 per hour-per bike; Child Seat = $5 per hour-per seat. Late fees
                    are not prorated and any minute-used of an hour, constitutes full use of that hour. Late fee
                    may not be waived except by cause or emergency, and only with approval of Manager.
                    <br><br>
                    <u>All Sales Are Final:</u>
                    No bicycle may be rented without signature and liability acceptance of a responsible adult.
                    No cash refund for any reason; nor may the store credit be applied for unused bicycle during
                    rental time.</b>

                    <div><div style="text-align: left">X</div><div style="text-align: right">Signature</div><hr style="border: 1px dashed grey;"></div>
                </div>
            </div>
        </div>
    @else
        <div>No Transaction!</div>
    @endif
@endsection

