<div class="col-md-3">
    {{--@role('tour_operator','big_agent')--}}
    @hasanyrole('tour_operator|big_agent|35_agent')
    <button type="button" class="btn btn-primary btn-circle btn-xl" onclick="window.location='{{route("agent.rentOrder")}}'">
            <i class="glyphicon ">
                <img src="{{ URL::to('images/bicycle.svg') }}" width="60px" alt="">
            </i>
            <p class="icon-main">RENTAL</p>
        </button>
    @else
        <button type="button" class="btn btn-primary btn-circle btn-xl" onclick="window.location='{{route("agent.showReservationPage")}}'">
            <i class="glyphicon ">
                <img src="{{ URL::to('images/bicycle.svg') }}" width="60px" alt="">
            </i>
            <p class="icon-main" style="font-size: 17px;">RESERVATION</p>
        </button>
    @endrole
</div>

{{--@role('tour_operator','big_agent')--}}
@hasanyrole('tour_operator|big_agent|35_agent')
<div class="col-md-3">
    <button type="button" class="btn btn-success btn-circle btn-xl" onclick="window.location='{{route("agent.tourOrder")}}'">
       <i class="glyphicon glyphicon-map-marker"></i> <p class="icon-main">TOUR</p></button>
</div>
@endrole

<div class="col-md-3">
    {{--@role('tour_operator','big_agent')--}}
    @hasanyrole('tour_operator|big_agent|35_agent')
    <button style="background-color: #5e4485;color: white;border-color:#5e4485!important;" type="button" class="btn btn-warning btn-circle btn-xl" onclick="window.location='{{route("agent.report")}}'">
            <div>
        <i class="glyphicon glyphicon-folder-open"></i><p class="icon-main">REPORT</p></div>
        </button>
    @else
        <button style="background-color: #5e4485;color: white;border-color:#5e4485!important;" type="button" class="btn btn-warning btn-circle btn-xl" onclick="window.location='{{route("partner.report")}}'">
            <div>
                <i class="glyphicon glyphicon-folder-open"></i><p class="icon-main">REPORT</p></div>
        </button>
    @endrole
</div>

{{--@role('tour_operator','big_agent')--}}
@hasanyrole('tour_operator|big_agent|35_agent')
<div class="col-md-3">
    <button style="color: #fff;background-color: #dc3545;border-color: #dc3545;" type="button" class="btn btn-info btn-circle btn-xl" onclick="window.location='{{route("agent.contact")}}'">
        <i class="glyphicon glyphicon-earphone"></i><p class="icon-main">CONTACTS</p></button>
</div>
@endrole