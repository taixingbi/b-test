@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/agent-order.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/vegas.min.css') }}">
    <style media="screen">
        footer{
            display: none;
        }
        body{
            background: #191919;
        }

        #box {
            background-color: white;
            opacity: 0.9;
            width: 1000px;
            height: 465px;
            overflow: scroll;
            padding: 20px;
            margin: 0 auto;
        }

        p {
            opacity: 1;
            color: black;
        }
    </style>
@endsection

@section('content')
    <div>
        <h1 class="white text-center">Terms and Conditions</h1>
        <div id="box">
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
            Rental Insurance are indemnified and protected against 50% of the cost of damages and
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
            rental time.</b>        </div>

        <br />

        <div>
            <button type="submit" style="margin-bottom: 7px; margin-left: 70px" class="btn btn-primary"
                    onclick="window.open('', '_self', ''); window.close();">
                Go Back</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::to('js/vegas.min.js') }}"></script>
    <script type="text/javascript">
        $("#example, body").vegas({
            firstTransitionDuration: 3000,
            slides: [
                { src: "{{ URL::to('images/1.jpg') }}" },
                { src: "{{ URL::to('images/2.jpg') }}" },
                { src: "{{ URL::to('images/3.jpg') }}" }
            ],
            overlay: '{{ URL::to('images/overlays/01.png') }}'
        });
    </script>
@endsection

