@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection

@section('styles')
    <link rel="stylesheet" media="print" href="{{ URL::to('css/print.css') }}">
@endsection

@section('content')
    @if(Session::has('rent_success'))
        {{ Session::forget('rent_success') }}
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div style="display:flex;">
                    <div class="text-right" ><button class="btn btn-success"  onclick="window.print() ">Print Receipt</button> </div>
                    <div class="text-right" style="margin-left: 36%"><button class="btn btn-success"  onclick="window.location='{{ route('agent.rentTicket') }}' ">Print Ticket</button> </div><br>
                </div><br>
                <div id="charge-message" class="">

                    {{--{{ dd($agent_rents_order) }}--}}
                    Bike Rent: <br><br>

                    Purchase At: {{ $agent_rents_order['time'] }}<br><br>
                    Agent: {{ $agent_rents_order['tix_agent'] }}<br><br>
                    Payment Type: {{ $agent_rents_order['payment_type'] }}<br><br>
                    {{--Total: ${{ $agent_rents_order['total_price_before_tax'] }}<br><br>--}}
                    {{--Tax: ${{ number_format(floatval($agent_rents_order['total_price_before_tax'])*.08875,2) }}<br><br>--}}
                    Total after Tax: ${{ $agent_rents_order['total_price_after_tax'] }}<br><br>
                    Deposit: ${{ $agent_rents_order['agent_price_after_tax'] }}<br><br>
                    Payment Due in Store: ${{ floatval($agent_rents_order['total_price_after_tax'])-floatval($agent_rents_order['agent_price_after_tax']) }}<br><br>

                    Barcode:<br>
                    <?php
                    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($agent_rents_order['barcode'], "C39") . '" alt="barcode"   />';
//                    $data = "data:image/png;base64," . DNS1D::getBarcodePNG($agent_rents_order['barcode'], "C39");
//
//                    list($type, $data) = explode(';', $data);
//                    list(, $data)      = explode(',', $data);
//                    $data = base64_decode($data);

//                    file_put_contents('asassads.png', $data);
//                                            echo DNS1D::getBarcodeHTML($agent_rents_order['barcode'], "C39");

                    ?>

                    <br><br>
                    Customer: {{ $agent_rents_order['customer_name'].' '.$agent_rents_order['customer_lastname'] }}<br><br>
                    Customer Email: {{ $agent_rents_order['customer_email'] }}<br><br>

                    Rent Date: {{ $agent_rents_order['date'] }}<br><br>
                    {{--Rent Time: {{ $agent_rents_order['time'] }}<br><br>--}}
                    Duration:{{ $agent_rents_order['duration'] }}<br><br>

                    @if( $agent_rents_order['adult']!='0')Adult Bike: {{ $agent_rents_order['adult'] }}<br><br>@endif
                    @if( $agent_rents_order['child']!='0')Children Bike: {{ $agent_rents_order['child'] }}<br><br>@endif
                    @if( $agent_rents_order['tandem']!='0')Tandem Bike: {{ $agent_rents_order['tandem'] }}<br><br>@endif
                    @if( $agent_rents_order['road']!='0')Road Bike: {{ $agent_rents_order['road'] }}<br><br>@endif
                    @if( $agent_rents_order['mountain']!='0')Mountain Bike: {{ $agent_rents_order['mountain'] }}<br><br>@endif
                    @if( $agent_rents_order['trailer']!='0')Trailer: {{ $agent_rents_order['trailer'] }}<br><br>@endif
                    @if( $agent_rents_order['seat']!='0')Baby Seat: {{ $agent_rents_order['seat'] }}<br><br>@endif
                    @if( $agent_rents_order['basket']!='0')Basket: {{ $agent_rents_order['basket'] }}<br><br>@endif
                    Total Bikes: {{ $agent_rents_order['total_bikes'] }}<br><br>

                    Drop off: @if($agent_rents_order['dropoff']=='1') Yes @else No @endif<br><br>
                    Insurance: @if($agent_rents_order['insurance']=='1') Yes @else No @endif<br><br>
                    @if( $agent_rents_order['comment'])Comment: {{ $agent_rents_order['comment'] }}<br><br>@endif

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

@section('scripts')

@endsection

