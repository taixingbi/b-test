@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/checkout.css') }}">

@endsection

@section('content')
    {{--<div style="display: flex;--}}
    {{--align-items:center;--}}
    {{--justify-content: center;">--}}
    {{--<h2 class="pb" style="color:#8798AB;">Credit Card Payment</h2>--}}
    {{--<span style="margin-left: 30px"><img height="90" width="90px" src="{{ URL::to('images/credit_card.png') }}" /></span>--}}
    {{--</div>--}}
    {{--<form action="@if(Session::has('rent')) {{ route('agent.ccCheckout') }} @elseif(Session::has('tour')) {{ route('agent.tourccCheckout') }} @endif" id="payment-form" method="post">--}}
    {{--<form action="@if(Session::has('rent')) {{ route('agent.ppCheckout') }} @elseif(Session::has('tour')) {{ route('agent.tourccCheckout') }} @endif" id="payment-form" method="post">--}}

    {{--<label>--}}
    {{--<input name="cardholder_name" id="cardholder_name" class="field is-empty" placeholder="Jane Doe" />--}}
    {{--<span><span>Name</span></span>--}}
    {{--</label>--}}

    {{--<label for="card-element">--}}
    {{--<div id="card-element" class="field is-empty"></div>--}}
    {{--<span><span>Card</span></span>--}}
    {{--</label>--}}
    {{--<label for="card_company">--}}
    {{--<span>Hours</span>--}}
    {{--<select class="agent-order-duration form-control" name="card_company" id="card_company">--}}
    {{--<option>VISA</option>--}}
    {{--<option>MASTER</option>--}}
    {{--<option>DISCOVER</option>--}}
    {{--<option>AMERICAN EXPRESS</option>--}}
    {{--</select>--}}
    {{--</label><br><br>--}}
    {{--<label for="card_number">--}}
    {{--<span>Card</span><br>--}}
    {{--<input type="text" name="card_number" id="card_number" class=" is-empty" />--}}
    {{--</label>--}}
    {{--<label for="card_expiration">--}}
    {{--<span>Expiration</span><br>--}}
    {{--<input type="text" name="card_expiration" id="card_expiration" class=" is-empty" />--}}
    {{--</label>--}}
    {{--<label for="card_cvv">--}}
    {{--<span>CVV</span><br>--}}
    {{--<input type="text" name="card_cvv" id="card_cvv" class=" is-empty" />--}}
    {{--</label>--}}
    {{--<label for="card-element">--}}
    {{--<div id="card-element" class="field is-empty"></div>--}}
    {{--<span><span>Card</span></span>--}}
    {{--</label>--}}
    {{--<label for="price">--}}

    {{--<div id="price" class="field is-empty"></div>--}}

    {{--<span><span>--}}
    {{--@if(Session::has('tour')) {{ "Total $".Session::get('agent_tour_price_after_tax') }}--}}
    {{--@elseif(Session::has('rent')) {{ "Total $".Session::get('agent_price_after_tax') }}--}}
    {{--@endif--}}
    {{--</span></span>--}}
    {{--</label>--}}
    {{--<div id='card-errors' class="error"></div>--}}
    {{--{{ csrf_field() }}--}}
    {{--<button type="submit">{{ $total }}</button>--}}
    {{--<button type="submit" onclick="return getPPToken()">submit</button>--}}

    {{--<div class="outcome">--}}
    {{--<div class="success">--}}
    {{--Success! Your Stripe token is <span class="token"></span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}

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

    <div class="wrap">
        <h2 class="pb" style="padding-bottom: 20px">Credit Card Payment</h2>

        <ul class="cc_images group">
            <div class="card">
                <div class="inside">
                    <div class="front"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/visa.png" alt="Visa"></div>
                    <div class="back"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/credit.png" alt="Back of Card"></div>
                </div>
            </div>

            <div class="card">
                <div class="inside">
                    <div class="front"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/mastercard.png" alt="MasterCard"></div>
                    <div class="back"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/credit.png" alt="Back of Card"></div>
                </div>
            </div>

            <div class="card">
                <div class="inside">
                    <div class="front"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/amex.png" alt="American Express"></div>
                    <div class="back"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/credit.png" alt="Back of Card"></div>
                </div>
            </div>

            <div class="card">
                <div class="inside">
                    <div class="front"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/discover.png" alt="Discover"></div>
                    <div class="back"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/credit.png" alt="Back of Card"></div>
                </div>
            </div>

            <div class="card">
                <div class="inside">
                    <div class="front"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/dinersclub.png" alt="Diners Club"></div>
                    <div class="back"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/credit.png" alt="Back of Card"></div>
                </div>
            </div>

            <div class="card">
                <div class="inside">
                    <div class="front"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/maestro.png" alt="Maestro"></div>
                    <div class="back"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/74196/credit.png" alt="Back of Card"></div>
                </div>
            </div>

        </ul>
        <form action="@if(Session::has('rent')) {{ route('agent.ppCheckout') }} @elseif(Session::has('tour')) {{ route('agent.ppTourCheckout') }} @endif" id="payment-form" class="cc_form" method="post">
            <div class="input-wrap group">
                <label for="cc_number"><i class="fa fa-credit-card"></i></label>
                <input type="text" name="cc_number" id="cc_number" placeholder="Card Number..">
            </div>

            <div class="input-wrap group expiration-wrap" style="width: 50%;">
                <label for="cc_firstname"><i class="fa fa-user"></i></label>
                <input type="text" name="cc_firstname" id="cc_firstname" placeholder="First Name.." value="@if(!empty($firstname)){{ $firstname }} @endif">
            </div>
            <div class="input-wrap group cvc-wrap" style="width: 48%;">
                <label for="cc_lastname"><i class="fa fa-user"></i></label>
                <input type="text" name="cc_lastname" id="cc_lastname" placeholder="Last Name.." value="@if(!empty($lastname)){{ $lastname }} @endif">
            </div>
            <div class="group exp-cvc">
                <div class="input-wrap group expiration-wrap">
                    <label for="cc_expiration"><i class="fa fa-calendar"></i></label>
                    <input type="text" name="cc_expiration" id="cc_expiration" placeholder="Expiration..">
                </div>
                <div class="input-wrap group cvc-wrap">
                    <label for="cc_cvc"><i class="fa fa-lock"></i></label>
                    <input type="text" name="cc_cvc" id="cc_cvc" placeholder="CVC..">
                </div>
            </div>
            <div class="group exp-cvc">
                <div class="input-wrap group ">
                    {{--<label for="cc_expiration"><i class="fa fa-calendar"></i></label>--}}
                    <input type="hidden" name="cc_type" id="cc_type" >
                </div>
            </div>
            <div class="group exp-cvc" style="margin-top: 10px;">
                <div class="input-wrap group ">
                    {{--<label for="cc_expiration"><i class="fa fa-calendar"></i></label>--}}
                    <input type="text" name="" id="" placeholder="@if(!empty($price)) ${{ $price }} @endif ">
                </div>
            </div>
            {{ csrf_field() }}
            <button type="submit" id="ppBtn" onclick="return checkValid()">submit</button>

        </form>
    </div>

@endsection

@section('scripts')
    {{--<script src="https://js.stripe.com/v3/"></script>--}}
    {{--<script src="{{ URL::to('js/checkout.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.0.2/jquery.payment.min.js'></script>
    <script src="{{ URL::to('js/paypal.js') }}"></script>
    <script src="{{ URL::to('js/notify.js') }}"></script>


@endsection