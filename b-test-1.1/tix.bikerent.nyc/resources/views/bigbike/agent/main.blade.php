@extends('layouts.master')

@section('title')
    Bike Rent NYC
@endsection
@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.timepicker.min.css') }}" >


@endsection

@section('nav-buttons')
    @include('bigbike.agent.nav-buttons')
@endsection

@section('content')

    <br><br><br><br>
    @if(Session::has('price-error'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="price-error" class="alert alert-warning">
                    {{ Session::get('price-error') }}
                    {{ Session::forget('price-error') }}
                </div>
            </div>
        </div>
    @endif


    <div class="col-md-12 mr-top" >

        <dl>
            <h3>ABOUT BIKE RENT NYC</h3>
            <dd>
                Bike Rent NYC is the largest bike rental business in New York City! BRNYC is committed to serving New York City residents and visitors through daily bike rentals, guided bike tours of Central Park and the Brooklyn Bridge, and daily, monthly or annual “hop-on, hop-off” biking programs. We currently offer the following kinds of bicycles: comfortable hybrid, lightweight road racing, tandem bikes for two, and children’s bikes.
            </dd>
        </dl>

        <dl>
            <h3>MORE INFORMATION</h3>
            <dd>
                Bike Rent NYC is now the most-popular place to rent bikes in New York City, offering great prices, top-quality Trek and Giant bikes, and friendly professional service. Take advantage of our daily pass add-on ($5) to pick-up in one location and drop off in another. Bike Rent NYC offers bike rentals, guided bike tours of Central Park, and guided bike tours of the Brooklyn Bridge, Brooklyn Bridge Park and the Greenway. Please call <a>(917) 283-2453</a> or email <a>reservations@bikerent.nyc</a> for any special requests with your booking.
            </dd>
        </dl>


    </div>


@endsection

@section('scripts')
    {{--<script src="{{ URL::to('agent-rent.js') }}"></script>--}}
@endsection