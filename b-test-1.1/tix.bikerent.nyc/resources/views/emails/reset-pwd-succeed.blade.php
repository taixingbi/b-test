<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://tix.bikerent.nyc/css/agent-order.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>
        body{ background-color: #f5f8fa;}
        .logo{
            padding-top: 15px;
            padding-left: 5px;
            display: inline-block;
            text-decoration: none;
            min-width: 100px;

        }
    </style>
</head>
<div class="header">
    <a href="https://tix.bikerent.nyc/bigbike/agent/main"><img src="https://tix.bikerent.nyc/images/favicon-small.png" alt="" style="float: left;"></a>
    <a class="logo" href="https://tix.bikerent.nyc/bigbike/agent/main"><font color="#61982d">TIX.BIKE</font><font color="#676767">RENT</font><font color="green">.</font><font color="black">NYC</font></a>


</div>
<body>

<div class="logo2">
    <img src="{{ URL::to('images/favicon.png') }}" width="200px" height="200px"></div>

<h3>Welcome to {!! $name !!} website!</h3><br>
<h3>Congratulations! Your password has been successfully changed</h3>


</body>
</html>
