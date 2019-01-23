@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.timepicker.min.css') }}" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection

<div class="row">
    @if(Session::has('error'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-warning">
                    {{ Session::get('error') }}
                    {{ Session::forget('error') }}
                </div>
            </div>
        </div>
    @endif
</div>
<div class="col-md-11">
 
    <form action="{{ route('agent.rentOrderSubmit') }}" id="payment-form" method="post">

        <label id="rent_date_label">
            <span>First Name</span><br>
            <input name="rent_customer" id="rent_customer" class=" is-empty"/>
        </label>
        <label id="rent_date_label">
            <span>Last Name</span><br>
            <input name="rent_customer_last" id="rent_customer_last" class=" is-empty"/>
        </label>
        <label id="rent_time_label">
            <span>Email</span><br>
            <input name="rent_email" id="rent_email" class="is-empty" type="email" />
        </label>

        {{--<h4>Date & Time</h4>--}}
        <label id="rent_date_label">
            <span>Date</span><br>
            <input name="rent_date" id="rent_date" class="datepicker is-empty"/>
        </label>
        <label id="rent_time_label">
            <span>Time</span><br>
            <input name="rent_time" id="rent_time" class="timepicker" type="text" />
        </label>

        <label for="rent_duration">
            <span>Hours</span>
            <select class="agent-order-duration form-control" name="rent_duration" id="rent_duration">
                <option value="1 hour">1 hour</option>
                <option value="2 hours">2 hours</option>
                <option value="3 hours">3 hours</option>
                <option value="5 hours">5 hours</option>
                <option value="All Day (8am-8pm)">All Day (8am-8pm)</option>
                <option value="24 hours">24 hours</option>
            </select>
        </label><br><br>


        <label id="adult_bike_label">
            <span>Adult</span><br>
            <input name="adult_bike" id="adult_bike" class="spinner field is-empty" value="0" placeholder="0"/>
        </label>
        <label>
            <span>Child</span><br>
            <input name="child_bike" id="child_bike" class="spinner field is-empty" value="0" placeholder="0" />
        </label>
        <label class="c24hours-label">
            <span>Tandem</span><br>
            <input name="tandem_bike" id="tandem_bike" class="c24hours spinner field is-empty" value="0" placeholder="0" />
        </label>
        <label class="c24hours-label">
            <span>Road</span><br>
            <input name="road_bike" id="road_bike" class="c24hours spinner field is-empty" value="0" placeholder="0" />
        </label>
        <label class="c24hours-label">
            <span>Mountain</span><br>
            <input name="mountain_bike" id="mountain_bike" class="c24hours spinner field is-empty" value="0" placeholder="0" />
        </label>
        <label class="c24hours-label">
            <span>Child Trailers</span><br>
            <input name="trailer_bike" id="trailer_bike" class="c24hours spinner field is-empty" value="0" placeholder="0" />
        </label>
        <label class="c24hours-label">
            <span>Child Seat</span><br>
            <input name="seat_bike" id="seat_bike" class="c24hours spinner field is-empty" value="0" placeholder="0"/>
        </label>
        <label class="c24hours-label">
            <span>Basket</span><br>
            <input name="basket_bike" id="basket_bike" class="c24hours spinner field is-empty" value="0" placeholder="0"/>
        </label><br>
        <div id="section">
            <div id="one">
                <label>
                    <span>Select a Store Location</span>
                    <select class="form-control" id="itemImage" name="location">
                        {{--<option value="" disabled selected>Select a Location</option>--}}
                        <option data-img="{{ URL::to('images/locations/203west.png') }}" value="203W 58th Street">203 West 58th Street, New York, NY 10019</option>
                        <option data-img="{{ URL::to('images/locations/117west.png') }}" value="117W 58th Street">117 West 58th Street, New York, NY 10019</option>
                        <option data-img="{{ URL::to('images/locations/145nassau.png') }}" value="145 Nassau Street">145 Nassau Street, New York, NY 10038</option>
                        <option data-img="{{ URL::to('images/locations/40west55th.png') }}" value="40W 55th Street">40 West 55th Street, New York, NY 10019</option>
                        <option data-img="{{ URL::to('images/locations/west-60th.png') }}" value="Central Park West">West 60th Street and Central Park West, NYC</option>
                        <option data-img="{{ URL::to('images/locations/west-59th.png') }}" value="Central Park South">Central Park Driveway and West 59th Street, NYC</option>
                        <option data-img="{{ URL::to('images/locations/grand-army-plaza.png') }}" value="Grand Army Plaza">Fifth Avenue and 59th Street</option>
                        <option data-img="{{ URL::to('images/locations/208west80th.png') }}" value="208 West 80th Street">208 West 80th Street</option>
                        <option data-img="{{ URL::to('images/locations/riverside.png') }}" value="Riverside Park">River Side Park, South of 79th Street Boat Basin</option>
                        <option data-img="{{ URL::to('images/locations/east-river.png') }}" value="East River Park">East River Park, south of Williamsburg Bridge, NYC</option>
                        <option data-img="{{ URL::to('images/locations/highbridge.png') }}" value="High Bridge Park">High Bridge Park, 169th Street</option>
                        <option data-img="{{ URL::to('images/locations/hudson-river.png') }}" value="452 West 45th Street">452 W 45th St, New York, NY 10036</option>
                    </select>
                </label><br><br>
                <div style="display: inline-block;margin-top:15px;margin-bottom: 10px">
            <span class="padding-sp" style="display: none;">Insurance: $2 each
                <input name="insurance" id="insurance" type="checkbox">
            </span>
                    <span class="padding-sp">Drop off at any other <a>www.bikerent.nyc</a> location than your pick up location: $5 each
                <input name="dropoff" id="dropoff" type="checkbox">
            </span></div><br>
                <label id=""><br>
                    <span>Total Price</span><br>
                    $<input style="font-size:16px;font-weight: bold" name="rent_total_label" id="rent_total_label" class="readonly is-empty" type="text" readonly/>
                </label>
                {{--<label id=""><br>--}}
                {{--<span>Tax</span><br>--}}
                {{--<input style="font-size:16px;font-weight: bold;color:green;" name="rent_tax" id="rent_tax" class="readonly is-empty" type="text" readonly/>--}}
                {{--</label>--}}
                <label id=""><br>
                <span>Total After Tax</span><br>
                <input style="font-size:16px;font-weight: bold" name="rent_total_after_tax" id="rent_total_after_tax" class="readonly is-empty" type="text" readonly/>
                </label>
                <label id="agent_com" style="display: none;"><br>
                    <span>Agent's Commission</span><br>
                    $<input style="font-size:16px;font-weight: bold" name="rent_tips_label" id="rent_tips_label" class="readonly is-empty" type="text" readonly/>
                </label><br>
                {{--<label id=""><br>--}}
                {{--<span>Cash Paid</span><br>--}}
                {{--<input style="font-size:16px;font-weight: bold;color:green;" name="cash_paid_label" id="cash_paid_label" class=" is-empty" type="text"/>--}}
                {{--</label>--}}
                {{--<label id=""><br>--}}
                {{--<span>Cash Change</span><br>--}}
                {{--<input style="font-size:16px;font-weight: bold" name="cash_change_label" id="cash_change_label" class="readonly is-empty" type="text" readonly/>--}}
                {{--</label><br>--}}
                <label id="rent_date_label">
                    <span>Comment</span><br>
                    <textarea rows="2" cols="35" form="payment-form" name="comment" id="comment" class=" is-empty" ></textarea>
                </label><br><br>

                <h3>Payment Method</h3>
                {{ csrf_field() }}

                <button type="submit" class="btn btn-primary" name="credit_card" id="mer" value="credit_card" onclick="return ccSubmitCheck()">Credit Card</button>
                @hasanyrole('tour_operator')
                <button type="submit" class="btn btn-primary" name="cash" value="cash"  onclick="return cashSubmitCheck()">Cash</button>
                @endrole
                <button type="button" id="cc-hidden" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="myfunc()" style="display: none">Credit Card</button>
                <button type="button" id="cash-hidden" class="btn btn-primary" data-toggle="modal" data-target="#myModalCash" onclick="myfuncCash()" style="display: none;">Cash</button>

                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <span id="name"></span><br>
                                <span id="email"></span><br>
                                <span id="date"></span><br>
                                <span id="time"></span><br>
                                <span id="duration"></span><br>
                                <br>
                                <h5>Bikes</h5>
                                <span id="adult"></span><br>
                                <span id="child"></span><br>
                                <span id="tandem"></span><br>
                                <span id="road"></span><br>
                                <span id="mountain"></span><br>
                                <span id="trailer"></span><br>
                                <span id="seat"></span><br>
                                <span id="basket"></span><br>
                                <br>
                                <span id="total"></span><br>

                                <p>Would you like to proceed with the card payment?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary proceed" id="credit_card" name="credit_card" value="credit_card" onclick="return cursor()">Proceed</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModalCash" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <span id="nameCash"></span><br>
                                <span id="emailCash"></span><br>
                                <span id="dateCash"></span><br>
                                <span id="timeCash"></span><br>
                                <span id="durationCash"></span><br>
                                <br>
                                <h5>Bikes</h5>
                                <span id="adultCash"></span><br>
                                <span id="childCash"></span><br>
                                <span id="tandemCash"></span><br>
                                <span id="roadCash"></span><br>
                                <span id="mountainCash"></span><br>
                                <span id="trailerCash"></span><br>
                                <span id="seatCash"></span><br>
                                <span id="basketCash"></span><br>
                                <br>
                                <span id="totalCash"></span><br>
                                <p>Would you like to proceed with the cash payment?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary proceed" id="proceed" name="cash" value="cash" onclick="return cursor()">Proceed</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

                @role('tour_operator')
                <label style="margin-left: 20px;" class="custom-control shak custom-checkbox">
                    <input type="checkbox" name="comCheckbox" id="comCheckbox" class="custom-control-input" >
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Display Agent Deposit</span>
                </label>
                @endrole

            </div>
            <div id="two">
                <img src="{{ URL::to('images/locations/203west.png') }}" id='changeImage'
                     style="width: 60%; height: 325.52px; padding-left: 50px; border: 0px;"
                        {{--onload="this.style.display=''"--}}
                />
            </div>
        </div>

        <br><br>

        {{--<div style="display: inline-block;margin-top:15px;margin-bottom: 10px">--}}
            {{--<span class="padding-sp">Insurance: $2 each--}}
                {{--<input name="insurance" id="insurance" type="checkbox">--}}
            {{--</span>--}}
            {{--<span class="padding-sp">Drop off: $5 each--}}
                {{--<input name="dropoff" id="dropoff" type="checkbox">--}}
            {{--</span></div><br>--}}
        {{--<label id=""><br>--}}
            {{--<span>Total Price</span><br>--}}
            {{--$<input style="font-size:16px;font-weight: bold" name="rent_total_label" id="rent_total_label" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label>--}}
        {{--<label id=""><br>--}}
        {{--<span>Tax</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold;color:green;" name="rent_tax" id="rent_tax" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label>--}}
        {{--<label id=""><br>--}}
        {{--<span>Total After Tax</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold" name="rent_total_after_tax" id="rent_total_after_tax" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label>--}}
        {{--<label id="agent_com" style="display: none;"><br>--}}
            {{--<span>Agent's Commission</span><br>--}}
            {{--$<input style="font-size:16px;font-weight: bold" name="rent_tips_label" id="rent_tips_label" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label><br>--}}
        {{--<label id=""><br>--}}
        {{--<span>Cash Paid</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold;color:green;" name="cash_paid_label" id="cash_paid_label" class=" is-empty" type="text"/>--}}
        {{--</label>--}}
        {{--<label id=""><br>--}}
        {{--<span>Cash Change</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold" name="cash_change_label" id="cash_change_label" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label><br>--}}
        {{--<label id="rent_date_label">--}}
            {{--<span>Comment</span><br>--}}
            {{--<textarea rows="2" cols="35" form="payment-form" name="comment" id="comment" class=" is-empty" ></textarea>--}}
        {{--</label><br><br>--}}

        {{--<h3>Payment Method</h3>--}}
        {{--{{ csrf_field() }}--}}
        {{--<button type="submit" class="btn btn-primary" name="credit_card" id="mer" value="credit_card" onclick="return ccSubmitCheck()">Credit Card</button>--}}
        {{--<button type="submit" class="btn btn-primary" name="cash" value="cash" onclick="return cashSubmitCheck()">Cash</button>--}}
        {{--<label style="margin-left: 20px;" class="custom-control shak custom-checkbox">--}}
            {{--<input type="checkbox" name="comCheckbox" id="comCheckbox" class="custom-control-input">--}}
            {{--<span class="custom-control-indicator"></span>--}}
            {{--<span class="custom-control-description">Agent Commission</span>--}}
        {{--</label>--}}

    </form>
</div>
<script>
    var rate = '<?php echo $rate; ?>';
    // console.log("rate: "+rate);
</script>



@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- for Modal -->
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

    <script src="{{ URL::to('js/notify.js') }}"></script>
    <script src="{{ URL::to('js/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::to('js/agent-order.js') }}"></script>
    <script src="{{ URL::to('js/agent-rent.js') }}"></script>
{{--    <script src="{{ URL::to('js/agent-rent-order.js') }}"></script>--}}
    <script src="{{ URL::to('js/agent-locations.js') }}"></script>

    <script type="text/javascript">
        function myfunc() {
            var first_name = document.getElementById("rent_customer").value;
            var last_name = document.getElementById("rent_customer_last").value;
            var rent_email = document.getElementById("rent_email").value;
            var rent_date = document.getElementById("rent_date").value;
            var rent_time = document.getElementById("rent_time").value;
            var rent_duration = document.getElementById("rent_duration");

            var strUser = rent_duration.options[rent_duration.selectedIndex].value;

            var adult_bike = document.getElementById("adult_bike").value;
            var child_bike = document.getElementById("child_bike").value;
            var tandem_bike = document.getElementById("tandem_bike").value;
            var road_bike = document.getElementById("road_bike").value;
            var mountain_bike = document.getElementById("mountain_bike").value;
            var trailer_bike = document.getElementById("trailer_bike").value;
            var seat_bike = document.getElementById("basket_bike").value;
            var basket_bike = document.getElementById("basket_bike").value;

            var total_tax = document.getElementById("rent_total_after_tax").value;

            document.getElementById("name").innerHTML = "<b>Customer Name:</b> " + first_name + " " + last_name;
            document.getElementById("email").innerHTML = "<b>Email:</b> " + rent_email;
            document.getElementById("date").innerHTML = "<b>Date:</b> " + rent_date;
            document.getElementById("time").innerHTML = "<b>Time:</b> " + rent_time;
            document.getElementById("duration").innerHTML = "<b>Rent Duration:</b> " + strUser;

            document.getElementById("adult").innerHTML = "<b>Adult Bikes:</b> " + adult_bike;
            document.getElementById("child").innerHTML = "<b>Child Bikes:</b> " + child_bike;
            document.getElementById("tandem").innerHTML = "<b>Tandem Bikes:</b> " + tandem_bike;
            document.getElementById("road").innerHTML = "<b>Road Bikes:</b> " + road_bike;
            document.getElementById("mountain").innerHTML = "<b>Mountain Bikes:</b> " + mountain_bike;
            document.getElementById("trailer").innerHTML = "<b>Trailer for Bikes:</b> " + trailer_bike;
            document.getElementById("seat").innerHTML = "<b>Seat for Bikes:</b> " + seat_bike;
            document.getElementById("basket").innerHTML = "<b>Basket for Bikes:</b> " + basket_bike;

            document.getElementById("total").innerHTML = "<b>Total Price after Tax: </b>" + "$" + total_tax;

            document.getElementById("credit_card").onclick = function () {
                if(!first_name && !last_name && !rent_email && !rent_date && !rent_time && !rent_duration) {
                    return false;
                }
                else {
                    location.href = "/var/www/html/tix.bikerent.nyc/resources/views/bigbike/agent/contact.blade.php";
                }
            }
        }

    </script>

    <script type="text/javascript">
        // function myfuncCash() {
        //     var first_name = document.getElementById("rent_customer").value;
        //     var last_name = document.getElementById("rent_customer_last").value;
        //     var rent_email = document.getElementById("rent_email").value;
        //     var rent_date = document.getElementById("rent_date").value;
        //     var rent_time = document.getElementById("rent_time").value;
        //     var rent_duration = document.getElementById("rent_duration");
        //
        //     var strUser = rent_duration.options[rent_duration.selectedIndex].value;
        //
        //     var adult_bike = document.getElementById("adult_bike").value;
        //     var child_bike = document.getElementById("child_bike").value;
        //     var tandem_bike = document.getElementById("tandem_bike").value;
        //     var road_bike = document.getElementById("road_bike").value;
        //     var mountain_bike = document.getElementById("mountain_bike").value;
        //     var trailer_bike = document.getElementById("trailer_bike").value;
        //     var seat_bike = document.getElementById("basket_bike").value;
        //     var basket_bike = document.getElementById("basket_bike").value;
        //
        //     var total_tax = document.getElementById("rent_total_after_tax").value;
        //
        //     document.getElementById("nameCash").innerHTML = "<b>Customer Name:</b> " + first_name + " " + last_name;
        //     document.getElementById("emailCash").innerHTML = "<b>Email:</b> " + rent_email;
        //     document.getElementById("dateCash").innerHTML = "<b>Date:</b> " + rent_date;
        //     document.getElementById("timeCash").innerHTML = "<b>Time:</b> " + rent_time;
        //     document.getElementById("durationCash").innerHTML = "<b>Rent Duration:</b> " + strUser;
        //
        //     document.getElementById("adultCash").innerHTML = "<b>Adult Bikes:</b> " + adult_bike;
        //     document.getElementById("childCash").innerHTML = "<b>Child Bikes:</b> " + child_bike;
        //     document.getElementById("tandemCash").innerHTML = "<b>Tandem Bikes:</b> " + tandem_bike;
        //     document.getElementById("roadCash").innerHTML = "<b>Road Bikes:</b> " + road_bike;
        //     document.getElementById("mountainCash").innerHTML = "<b>Mountain Bikes:</b> " + mountain_bike;
        //     document.getElementById("trailerCash").innerHTML = "<b>Trailer for Bikes:</b> " + trailer_bike;
        //     document.getElementById("seatCash").innerHTML = "<b>Seat for Bikes:</b> " + seat_bike;
        //     document.getElementById("basketCash").innerHTML = "<b>Basket for Bikes:</b> " + basket_bike;
        //
        //     document.getElementById("totalCash").innerHTML = "<b>Total Price after Tax: </b>" + "$" + total_tax;
        // }

        function cursor(){
            $(".proceed").css("cursor", "progress");
            return true;
        }


    </script>

    {{--<script type="text/javascript">--}}
        {{--document.getElementById("credit_card").onclick = function () {--}}
            {{--if(!checkName()) return false;--}}
            {{--else if(!checkEmail()) return false;--}}
            {{--else if(!checkBikeNum()) return false;--}}
            {{--else if(!checkValid()) return false;--}}
            {{--else {--}}
                {{--return true;--}}
                {{--location.href = "/var/www/html/tix.bikerent.nyc/resources/views/bigbike/agent/contact.blade.php";--}}
            {{--}--}}

            {{--var floatRegex = /^(0\.[1-9]|[1-9][0-9]{0,2}(\.[0-9]{0,2})?)$/;--}}

            {{--// if(!$('#rent_total_label').val().match(floatRegex)){--}}
            {{--//     $('#rent_total_label').notify("Please input valid price", {position: "right middle"});--}}
            {{--//     return false;--}}
            {{--// }else{--}}
            {{--//     location.href = "/var/www/html/tix.bikerent.nyc/resources/views/bigbike/agent/contact.blade.php";--}}
            {{--//     return true;--}}
            {{--// }--}}


        {{--}--}}
    {{--</script>--}}

@endsection
