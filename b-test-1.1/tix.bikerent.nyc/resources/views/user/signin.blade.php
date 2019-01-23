@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/agent-order.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('css/vegas.min.css') }}">
    <style media="screen">
        footer{
            display: none;
        }
        body{
            background: #191919;
        }
    </style>
@endsection
@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-4 center-mainl">
            <div class="logo">
                <img src="{{ URL::to('images/logo-bike-rent.svg') }}" width="350px" height="200px"></div>
            <h2 class="white">Sign In</h2>
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('msg'))
                <div class="alert alert-info">
                    {{ Session::get('msg') }}
                    {{ Session::forget('msg') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                    {{ Session::forget('error') }}

                </div>
            @endif

            <form action="{{ route('user.signin') }}" method="post">
                <div class="form-group">
                    <label class="white" for="email">E-mail</label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label class="white" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div><button type="submit" style="margin-bottom: 7px" class="btn btn-primary">Sign In</button>
{{--                    <div class="pass"><a href="{{ route('agent.getResetPage') }}">Forgot password?</a></div>--}}
                    <p style="color: white">
                        Terms & Conditions:
                        By signing into tix.bikerent.nyc, you are accepting the Booking Conditions and Terms of Use. If you are not registered please complete a registration form.  You may obtain a registration form by sending a request email to <a>reservations@bikerent.nyc</a> with 'Registration Form Tix' in the subject line.  Thank you.
                    </p>
                    <a href="{{ route('user.terms') }}" target="_blank">Terms & Conditions of Use</a>
                </div>
                {{ csrf_field() }}
            </form>
{{--            <span class="white">Don't have an account? <a href="{{ route('user.signup') }} ">Sign up</a></span>--}}
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
