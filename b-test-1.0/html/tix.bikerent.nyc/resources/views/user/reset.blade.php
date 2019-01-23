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
    </style>
@endsection


@section('content')
    <div class="row" style="padding-bottom: 50px">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="white text-center">Reset</h1>
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('user.resetpww') }}" method="post">
                <div class="form-group" >
                    <label class="white" for="first_name">Email</label>
                    <input type="text" id="first_name" name="email" value="{{ $email }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="white" for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control">
                </div>
                <div class="form-group">
                    <label class="white" for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control">
                </div>
                {{--<div class="form-group">--}}
                    {{--<label class="white" for="email">E-mail</label>--}}
                    {{--<input type="text" id="email" name="email" class="form-control">--}}
                {{--</div>--}}
                <div class="form-group">
                    <label class="white" for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label class="white" for="password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Reset</button>
                {{ csrf_field() }}
            </form>
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