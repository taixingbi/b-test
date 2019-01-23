<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a href="{{ route('agent.main') }}"><img src="{{ URL::to('images/logo-bike-rent.svg') }}" alt="" height="50px" width="90px" style="float: left;"></a>
                    <a class="navbar-brand logo" style="margin-left:-30px"  href="{{ route('agent.main') }}" >TIX.BIKE<font color="#676767">RENT</font><font color="green">.</font><font color="black">NYC</font></a>
                </div>
            </div>

        <?php
            //set headers to NOT cache a page
            header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
            header("Pragma: no-cache"); //HTTP 1.0
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        ?>


        <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            User Management <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Auth::check())
                                <li><a href="{{ route('user.logout') }}">Logout</a></li>
                                <li><a href="{{ route('user.resetpw') }}">Reset User Info</a></li>
                            @else
                                {{--<li><a href="{{ route('user.signup') }}">Sign up</a></li>--}}
                                <li><a href="{{ route('user.signin') }}">Sign in</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <span style="float: right; margin-top:14px;">
                @if(Session::has('name'))
                        <span style="margin-right: 20px;">User: {{ Session::get('name') }}</span>
                @endif
            </span>
            </div><!-- /.navbar-collapse -->
        </div>
    </div><!-- /.container-fluid -->
</nav>