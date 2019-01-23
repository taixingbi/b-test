<div class="container">
    <div class="row">
        <span style="position:absolute; zoom: 140%"><img src="{{ URL::to('images/central.jpg')}}" /></span>

        <div class="ticket-rec" style="position: absolute;" >

            <div style="display: inline">
                <span style="float:right"><img src="{{ URL::to('images/favicon.png')}}" height="90px" width="90px" ></span>

            </div>
            <span style="font-size:18px" class="font700">Bike Tour Ticket</span><br><br>

            <div>
                <div style="max-width:650px;" class="table-ticket" style="z-index:15;">
                    <div class="col-md-6 col-sm-6">
                        <div class="font700">Payment :</div>
                        <div>Order Complated At: {{ $agent_tours_order['date'].' '.$agent_tours_order['time'] }}</div>
                        <div>Agent: {{ $agent_tours_order['tix_agent'] }}</div>
                        <div>Payment Type: {{ $agent_tours_order['payment_type'] }}</div>
                        {{--<div>Total: ${{ $agent_tours_order['total_price_before_tax'] }}</div>--}}
                        {{--<div>Tax: ${{ number_format(floatval($agent_tours_order['total_price_before_tax'])*.08875,2) }}</div>--}}
                        <div>Total after Tax: ${{ $agent_tours_order['total_price_after_tax'] }} </div>
                        <div>@if($agent_tours_order['cash_deposit_checked']=='1') Agent Deposit: ${{ $agent_tours_order['agent_price_after_tax'] }}</div> @endif
                        <div>Balance due: ${{ floatval($agent_tours_order['total_price_after_tax'])-floatval($agent_tours_order['agent_price_after_tax']) }}<br><br>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="font700">Tour Info :</div>
                        <div>Customer: {{ $agent_tours_order['customer_name'].' '.$agent_tours_order['customer_lastname'] }}  </div>
                        <div>Email: {{ $agent_tours_order['customer_email'] }}  </div>
                        <div>Tour Date: {{ $agent_tours_order['date'] }}</div>
                        <div>Tour Time: {{ $agent_tours_order['time'] }}</div>
                        <div>Tour Type: {{ $agent_tours_order['tour_type'] }}</div>
                        <div>Adult: {{ $agent_tours_order['adult'] }}</div>
                        <div>Children: {{ $agent_tours_order['child'] }}</div>
                        <div>Total Bikes: {{ $agent_tours_order['total_people'] }}</div>
                        <div>@if( $agent_tours_order['comment'])Comment: {{ $agent_tours_order['comment'] }}</div>@endif

                    </div>
                </div>
            </div>


            <div class="barcode">
                <?php
                //                                                echo DNS1D::getBarcodeHTML($agent_rents_order['barcode'], "C39");

                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($agent_tours_order['barcode'], "C39") . '" alt="barcode"   />';

                ?>
            </div>

        </div>
    </div>
</div>