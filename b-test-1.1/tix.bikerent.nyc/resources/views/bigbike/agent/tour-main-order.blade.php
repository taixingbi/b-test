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

    @if(!empty($error))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-warning">
                    {{ $error }}
                </div>
            </div>
        </div>
    @endif
</div>

<div class="col-md-10">
    <form action="{{ route('agent.tourOrderSubmit') }}" id="payment-form" method="post">
        <label id="tour_date_label">
            <span>First Name</span><br>
            <input name="tour_customer_first" id="tour_customer_first" class="field is-empty"/>
        </label>
        <label id="rent_date_label">
            <span>Last Name</span><br>
            <input name="tour_customer_last" id="tour_customer_last" class=" is-empty"/>
        </label>
        <label id="tour_time_label">
            <span>Email</span><br>
            <input name="tour_email" id="tour_email" class="field is-empty" type="email" />
        </label><br><br>

        <label id="tour_date_label">
            <span><span>Date </span></span><br>
            <input name="tour_date" class="datepicker" id="tour_date" class="field is-empty" placeholder="" />
        </label>
        <label id="tour_time_label">
            <span><span>Tour Start Time </span></span><br>
            <select  class="agent-order-duration form-control" name="tour_time" id="tour_time">
                <option selected value="9AM">9AM</option>
                <option value="10AM">10AM</option>
                <option value="1PM">1PM</option>
                <option value="4PM">4PM</option>
            </select>
        </label>
        <label>
            <span><span>Place </span></span>
            <select class="agent-order-place form-control" id="tour_place" name="location" onchange="checkTourType(this);">
                <option selected value="203W 58th Street">Central Park</option>
                <option value="145 Nassau Street">Brooklyn Bridge</option>
                <option value="Movies & Film">Movies & Film</option>
                <option value="Arts & Architecture">Arts & Architecture</option>
                <option value="Uptown NYC">Uptown NYC</option>
                <option value="Downtown NYC">Downtown NYC</option>
            </select>
        </label>

        <label>
            <span><span>Type of Tour</span></span>
            <select class="agent-order-place form-control" name="tour_type" id="tour_type">
                <option selected id="public" value="public(2h)">public(2h)</option>
                <option value="private(2h)">private(2h)</option>
                <option value="private(3h)">private(3h)</option>
            </select>
        </label><br>
        <label >
            <span><span>Number of adult tours </span></span><br>
            <input name="adult_tour" id="adult_tour" class="tour-spinner field is-empty" value="0" placeholder="0"/>
        </label>
        <label id="child_tour_label">
            <span><span>Number of child tours </span></span><br>
            <input name="child_tour" id="child_tour" class="tour-spinner field is-empty" value="0" placeholder="0" />
        </label><br>
        {{--<label>--}}
        {{--<span><span>Total number of tours: </span></span>--}}
        {{--<input name="total_tours" class="readonly field is-empty" placeholder="0" readonly />--}}
        {{--</label><br><br>--}}
        <label id=""><br>
            <span>Total Price</span><br>
            $<input style="font-size:16px;font-weight: bold" name="tour_total" id="tour_total" class="readonly is-empty" type="text" readonly/>
        </label><br>
        {{--<label id=""><br>--}}
            {{--<span>Total Price after Tax</span><br>--}}
            {{--$<input style="font-size:16px;font-weight: bold" name="tour_total_after_tax" id="tour_total_after_tax" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label>--}}
        {{--<label id=""><br>--}}
        {{--<span>Tax</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold;color:green;" name="tour_tax" id="tour_tax" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label>--}}
        {{--<label id=""><br>--}}
        <label id="">
        <span>Total After Tax</span><br>
        $<input style="font-size:16px;font-weight: bold" name="tour_total_after_tax" id="tour_total_after_tax" class="readonly is-empty" type="text" readonly/>
        </label>
        <label id="agent_com" style="display: none;"><br>
            <span>Agent's Commission</span><br>
            $<input style="font-size:16px;font-weight: bold" name="tour_tips" id="tour_tips" class="readonly is-empty" type="text" readonly/>
        </label><br>
        {{--<label id=""><br>--}}
        {{--<span>Cash Paid</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold;color:green;" name="cash_paid_label" id="cash_paid_label" class=" is-empty" type="text"/>--}}
        {{--</label>--}}
        {{--<label id="">--}}
        {{--<span>Cash Change</span><br>--}}
        {{--<input style="font-size:16px;font-weight: bold" name="cash_change_label" id="cash_change_label" class="readonly is-empty" type="text" readonly/>--}}
        {{--</label><br>--}}
        <label id="rent_date_label">
            <span>Comment</span><br>
            <textarea rows="2" cols="35" form="payment-form" name="comment" id="comment" class=" is-empty" ></textarea>
        </label><br><br>
        <br><br>
        {{--{{ csrf_field() }}--}}
        {{--<button type="submit" class="btn btn-success" id="credit_card" name="credit_card" value="credit_card" onclick="return ccSubmitCheck()">Credit Card</button>--}}
        {{--<button type="submit" class="btn btn-success" name="cash" value="cash" onclick="return cashSubmitCheck()">Cash</button>--}}

        <h3>Payment Method</h3>
        {{ csrf_field() }}

        <button type="submit" class="btn btn-primary" name="credit_card" id="mer" value="credit_card" onclick="return ccSubmitCheck()">Credit Card</button>
        @hasanyrole('tour_operator')
        <button type="submit" class="btn btn-primary" name="cash" value="cash" onclick="return cashSubmitCheck()">Cash</button>
        @endrole
        <button type="button" id="cc-hidden" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="myfunc()" style="display: none;">Credit Card</button>
        {{--<button type="button" id="cash-hidden" class="btn btn-primary" data-toggle="modal" data-target="#myModalCash" onclick="myfuncCash()" style="display: none;">Cash</button>--}}

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
                        <span id="place"></span><br>
                        <span id="type_tour"></span><br>
                        <br>
                        <h5>Number of Tours</h5>
                        <span id="adult"></span><br>
                        <span id="child"></span><br>
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

        {{--<div class="modal fade" id="myModalCash" role="dialog">--}}
            {{--<div class="modal-dialog">--}}
                {{--<!-- Modal content-->--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                        {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                        {{--<span id="name"></span><br>--}}
                        {{--<span id="email"></span><br>--}}
                        {{--<span id="date"></span><br>--}}
                        {{--<span id="time"></span><br>--}}
                        {{--<span id="place"></span>--}}
                        {{--<span id="type_tour"></span><br>--}}
                        {{--<br>--}}
                        {{--<h5>Number of Tours</h5>--}}
                        {{--<span id="adult"></span><br>--}}
                        {{--<span id="child"></span><br>--}}
                        {{--<br>--}}
                        {{--<span id="total"></span><br>--}}

                        {{--<p>Would you like to proceed with the card payment?</p>--}}
                    {{--</div>--}}

                    {{--<span id="totalCash"></span><br>--}}
                    {{--<p>Would you like to proceed with the cash payment?</p>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="submit" class="btn btn-primary proceed" id="proceed" name="cash" value="cash" onclick="return cursor()">Proceed</button>--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        @role('tour_operator')
        <label style="margin-left: 20px;" class="custom-control shak custom-checkbox">
            <input type="checkbox" name="comCheckbox" id="comCheckbox" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Display Agent Deposit</span>
        </label>
        @endrole

    </form>
</div>

<script>
    var rate = '<?php echo $rate; ?>';
    // console.log("rate: "+rate);
</script>


@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ URL::to('js/notify.js') }}"></script>
    <script src="{{ URL::to('js/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::to('js/agent-order.js') }}"></script>

    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

    <script type="text/javascript">
        function myfunc() {
            // console.log("here");

            var tour_customer_first = document.getElementById("tour_customer_first").value;
            var tour_customer_last = document.getElementById("tour_customer_last").value;
            var tour_email = document.getElementById("tour_email").value;
            var tour_date = document.getElementById("tour_date").value;
            var tour_time = document.getElementById("tour_time").value;
            var tour_place = document.getElementById("tour_place").value;
            var tour_type = document.getElementById("tour_type").value;

            // var strTime = tour_time.options[tour_time.selectedIndex].value;
            // var strPlace = tour_place.options[tour_place.selectedIndex].value;
            // var strType = tour_type.options[tour_type.selectedIndex].value;

            var adult_tour = document.getElementById("adult_tour").value;
            var child_tour = document.getElementById("child_tour").value;

            var total_tax = document.getElementById("tour_total").value;
            // console.log(tour_customer_first+" "+tour_customer_last);
            document.getElementById("name").innerHTML = "<b>Customer Name:</b> " + tour_customer_first + " " + tour_customer_last;
            document.getElementById("email").innerHTML = "<b>Email:</b> " + tour_email;
            document.getElementById("date").innerHTML = "<b>Date:</b> " + tour_date;
            document.getElementById("time").innerHTML = "<b>Time:</b> " + tour_time;
            document.getElementById("duration").innerHTML = "<b>Tour Start Time:</b> " + tour_time;
            document.getElementById("place").innerHTML = "<b>Tour Start Place:</b> " + tour_place;
            document.getElementById("type_tour").innerHTML = "<b>Tour Type:</b> " + tour_type;

            document.getElementById("adult").innerHTML = "<b>Adult Bikes:</b> " + adult_tour;
            document.getElementById("child").innerHTML = "<b>Child Bikes:</b> " + child_tour;

            document.getElementById("total").innerHTML = "<b>Total Price after Tax: </b>" + "$" + total_tax;

            document.getElementById("credit_card").onclick = function () {
                if(!tour_customer_first && !tour_customer_last && !tour_email && !tour_date && !tour_time && !tour_place && !tour_type) {
                    // console.log("there");
                    return false;
                }
                else {
                    location.href = "/var/www/html/tix.bikerent.nyc/resources/views/bigbike/agent/contact.blade.php";
                }
            }
        }

    </script>

    <script type="text/javascript">
        function cursor(){
            $(".proceed").css("cursor", "progress");
            return true;
        }
    </script>
    <script src="{{ URL::to('js/agent-tour.js') }}"></script>

@endsection

