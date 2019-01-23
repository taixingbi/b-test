@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.timepicker.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/rent-main.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/braintree.css') }}" >

@endsection

@section('content')
    {{--<div class="text-center" ><button class="btn btn-success"  onclick="window.print() ">Print Report</button> </div>--}}

    {{--<h2>Daily Report </h2>--}}
    {{--<div class="text-center">--}}
    {{--<h2>Location Summary</h2>--}}
    {{--</div>--}}
    {{--{{ dd($locations) }}--}}
    {{--<div  >--}}
        {{--<div id="dropin-container"></div>--}}
        {{--<button id="submit-button">Request payment method</button>--}}

    {{--</div>--}}
    <div>
        <!-- Add animations on Braintree Hosted Fields events -->

        <!-- Some test Card numbers
        4111 1111 1111 1111: Visa
        5555 5555 5555 4444: MasterCard
        3714 496353 98431: American Express
        -->

        <!--[if IE 9]>
        <style>

            header {
                margin-top: 1em;
                text-align: center;
            }

            #my-sample-form {
                margin: 0 auto;
                padding-top: 2em;
            }

            .bg-illustration {
                z-index: -1;
            }

            #button-pay {
                margin: 1em auto 0;
                display: block;
            }

            .cardinfo-exp-date, .cardinfo-cvv {
                width: 45%;
                float: left;
            }

            .cardinfo-wrapper {
                overflow: hidden;
            }

        </style>
        <![endif]-->

        <div class="form-container">
            <div class="bg-illustration">
                <svg width="801" height="570" viewBox="0 0 801 570" xmlns="http://www.w3.org/2000/svg"><path d="M695.15 540.43c-20.954 6.55-43.243 8.226-64.932 4.89 26.065-11.507 55.1-15.426 83.328-12.16-6.065 2.907-12.257 5.35-18.397 7.27m-74.984-158.957c-21.38 10.4-43.668 18.945-66.534 25.507-10.876 3.124-21.884 5.796-32.982 8.01-9.54 1.897-19.777 4.24-29.407 1.474-3.74-1.074-7.995-3.277-9.628-7.045-1.683-3.892 5.25-9.335 7.905-12.03 7.204-7.305 15.39-13.605 24.186-18.898 17.312-10.42 36.777-16.946 56.58-20.74 29.96-5.74 61.745-5.98 91.927.11-13.534 8.686-27.587 16.578-42.047 23.61M500.756 239.7c-33.755 25.25-73.15 43.654-114.53 52.324-3.04.637-17.404 1.327-11.22-4.79 4.484-4.435 9.366-8.456 14.522-12.093 8.946-6.313 18.65-11.5 28.616-16.02 22.272-10.1 45.856-17.684 69.6-23.497 8.246-2.02 16.557-3.784 24.91-5.325-3.887 3.23-7.85 6.372-11.9 9.402M342.55 48.914c-6.185 9.275-13.586 17.906-21.198 26.05-29.246 31.28-66.41 55.228-107.156 68.748-9.036 2.998-18.98 6.006-28.552 3.737-3.216-.762-9.808-3.368-10.36-7.234-.303-2.117 2.287-5.23 3.342-6.96 1.356-2.23 2.805-4.4 4.337-6.514 12.736-17.588 30.818-30.666 49.696-41.077 34.208-18.862 71.874-31.495 110.664-37.96-.256.404-.51.81-.774 1.21m457.74 519.678c-22.864-19.48-51.17-31.804-80.733-36.312 9.67-5.095 18.695-11.365 26.732-18.812 14.05-13.024 24.878-30.252 26.41-49.644 1.64-20.754-7.21-41.398-19.804-57.542-20.985-26.902-53.498-42.06-86.39-49.197 2.876-1.887 5.738-3.798 8.565-5.757 17.06-11.824 34.41-25.288 44.125-44.053 8.667-16.737 10.507-38.63-.855-54.614-10.888-15.32-30.21-21.3-47.887-24.643-46.346-8.764-94.712-8.922-141.317-2.16-3.577.522-7.144 1.098-10.71 1.703 10.422-9.04 20.23-18.78 29.26-29.202 16.158-18.658 32.707-40.726 35.14-66.04 4.776-49.667-50.926-71.248-90.198-80.87-47.635-11.67-97.6-13.463-146.025-5.768 3.113-5.434 5.273-11.288 4.97-17.58-.47-9.854-7.347-18.123-15.74-22.784-11.377-6.32-25.098-5.845-37.625-4.418-23.028 2.626-45.735 8-67.582 15.672-43.49 15.276-83.362 39.604-118.428 69.25-36.16 30.574-67.404 66.832-93.41 106.278-6.348 9.625-12.37 19.457-18.1 29.46-.54.945.923 1.796 1.463.85 40.29-70.35 96.604-133.587 166.986-175.18C203.47 26.94 241.14 12.15 280.516 5.18c20.895-3.7 51.86-9.495 65.6 11.7 6.22 9.6 3.576 20.047-1.766 29.143-3.298.545-6.592 1.134-9.876 1.768-26.202 5.052-51.843 12.94-76.305 23.567-22.525 9.788-44.832 21.706-62.735 38.713-8.42 8-15.773 17.185-21.18 27.47-3.763 7.16 9.64 11.647 14.766 12.153 10.566 1.042 20.932-2.625 30.718-6.102 11.48-4.08 22.666-8.986 33.446-14.64 21.505-11.28 41.417-25.57 58.974-42.3 9.075-8.65 17.512-17.96 25.207-27.844 2.79-3.58 5.756-7.41 8.263-11.483 52.33-8.38 106.617-5.535 157.177 8.53 36.682 10.207 84.046 32.95 78.09 78.475-3.09 23.603-18.427 44.218-33.538 61.828-9.847 11.478-20.625 22.164-32.15 31.976-19.287 3.427-38.35 8.103-57.007 14.06-21.474 6.853-43.19 14.898-62.414 26.797-8.93 5.53-17.205 12.008-24.462 19.596-.195.202-.327.543-.22.82 3.423 8.837 16.933 4.033 23.404 2.455 11.922-2.908 23.653-6.584 35.105-10.975 22.774-8.73 44.46-20.26 64.415-34.24 7.58-5.31 14.908-10.972 21.96-16.955 39.06-6.903 79.05-8.58 118.555-4.88 21.537 2.018 45.684 4.04 65.153 14.28 9.745 5.127 18.006 12.924 21.967 23.337 3.86 10.146 3.67 21.456.824 31.83-6.102 22.25-24.29 38.393-42.392 51.46-5.212 3.767-10.53 7.39-15.925 10.896-1.224-.252-2.445-.517-3.667-.746-37.45-7.026-77.88-5.438-114.235 6.232-18.002 5.78-35.216 14.388-49.737 26.545-3.65 3.057-7.115 6.33-10.362 9.806-1.567 1.678-3.082 3.4-4.54 5.17-.875 1.064-2.49 2.35-2.57 3.775-.143 2.517 2.89 5.763 4.637 7.185 2.58 2.103 5.815 3.312 9.048 3.995 8.508 1.8 17.07.216 25.46-1.39 11.114-2.13 22.14-4.725 33.04-7.77 21.866-6.106 43.222-14.027 63.787-23.626 17.12-7.99 33.678-17.172 49.527-27.44 7.98 1.705 15.85 3.83 23.528 6.446 36.767 12.53 71.948 39.044 81.216 78.46 9.36 39.803-19.35 71.52-53.047 88.572-16.7-2.21-33.75-1.943-50.4.943-13.49 2.337-26.584 6.463-38.99 12.215-.637.294-.498 1.417.203 1.54 30.05 5.212 62.45.816 89.935-12.918 16.66 2.28 32.98 7.053 48.18 14.26 12.224 5.798 23.625 13.16 33.912 21.924.824.7 2.028-.486 1.197-1.193" fill="#FFF" fill-rule="evenodd"/></svg>

            </div>

            <header>
                <h1>Payment Method</h1>
            </header>
            <input type="text" id="ccard-number" placeholder="test">
            {{--<form id="my-sample-form" class="scale-down" method="post" action="{{ route('agent.payBT') }}">--}}
            <form id="my-sample-form" class="scale-down" >

                <div class="cardinfo-card-number">
                    <label class="cardinfo-label" for="card-number">Carddddd Number</label>
                    <div class='input-wrapper' id="card-number"></div>
                    <div id="card-image"></div>
                </div>

                <div class="cardinfo-wrapper">
                    <div class="cardinfo-exp-date">
                        <label class="cardinfo-label" for="expiration-date">Valid Thru</label>
                        <div class='input-wrapper' id="expiration-date"></div>
                    </div>

                    <div class="cardinfo-cvv">
                        <label class="cardinfo-label" for="cvv">CVV</label>
                        <div class='input-wrapper' id="cvv"></div>
                    </div>
                </div>
            </form>

            <input id="button-pay" type="submit" value="Continue" />
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::to('js/jquery.cardswipe.js') }}"></script>

    {{--<script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>--}}
    {{--<script src="https://js.braintreegateway.com/web/3.37.0/js/client.min.js"></script>--}}
    <script src="{{ URL::to('js/payment/braintree.client.min.js') }}"></script>
    <script src="{{ URL::to('js/payment/hosted-fields.min.js') }}"></script>

    <!-- Load Hosted Fields component. -->
    <script src="https://js.braintreegateway.com/web/3.37.0/js/hosted-fields.min.js"></script>
    {{--    <script src="{{ URL::to('js/jquery.timepicker.js') }}"></script>--}}
    {{--<script src="{{ URL::to('js/agent-report.js') }}"></script>--}}
    <script>
        var sandbox_tokenization_key = '<?php echo $sandbox_tokenization_key;?>'
        // For Drop-in...
        // braintree.dropin.create({
        //     authorization: tokenizationKey
        // }, function (err, dropinInstance) {
        //     // ...
        // });
        //
        // // For custom...
        // braintree.client.create({
        //     authorization: tokenizationKey
        // }, function (err, clientInstance) {
        //     // ...
        // });

        // var button = document.querySelector('#submit-button');
        //
        // braintree.dropin.create({
        //     authorization: sandbox_tokenization_key,
        //     container: '#dropin-container'
        // }, function (createErr, instance) {
        //     button.addEventListener('click', function () {
        //         instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
        //             // Submit payload.nonce to your server
        //         });
        //     });
        // });
    {{--</script>--}}
    {{--<script>--}}
        var form = document.querySelector('#my-sample-form');
        var submit = document.querySelector('input[type="submit"]');

        braintree.client.create({
            authorization: sandbox_tokenization_key
        }, function (err, clientInstance) {
            if (err) {
                console.error(err);
                return;
            }

            // Create input fields and add text styles
            braintree.hostedFields.create({
                client: clientInstance,
                styles: {
                    'input': {
                        'color': '#282c37',
                        'font-size': '16px',
                        'transition': 'color 0.1s',
                        'line-height': '3'
                    },
                    // Style the text of an invalid input
                    'input.invalid': {
                        'color': '#E53A40'
                    },
                    // placeholder styles need to be individually adjusted
                    '::-webkit-input-placeholder': {
                        'color': 'rgba(0,0,0,0.6)'
                    },
                    ':-moz-placeholder': {
                        'color': 'rgba(0,0,0,0.6)'
                    },
                    '::-moz-placeholder': {
                        'color': 'rgba(0,0,0,0.6)'
                    },
                    ':-ms-input-placeholder': {
                        'color': 'rgba(0,0,0,0.6)'
                    }

                },
                // Add information for individual fields
                fields: {
                    number: {
                        selector: '#card-number',
                        placeholder: '1212 1111 1111 1111'
                    },
                    cvv: {
                        selector: '#cvv',
                        placeholder: '123'
                    },
                    expirationDate: {
                        selector: '#expiration-date',
                        placeholder: '10 / 2019'
                    }
                }
            }, function (err, hostedFieldsInstance) {
                if (err) {
                    console.error(err);
                    return;
                }

                hostedFieldsInstance.on('validityChange', function (event) {
                    // Check if all fields are valid, then show submit button
                    var formValid = Object.keys(event.fields).every(function (key) {
                        return event.fields[key].isValid;
                    });

                    if (formValid) {
                        $('#button-pay').addClass('show-button');
                    } else {
                        $('#button-pay').removeClass('show-button');
                    }
                });

                hostedFieldsInstance.on('empty', function (event) {
                    $('header').removeClass('header-slide');
                    $('#card-image').removeClass();
                    $(form).removeClass();
                });

                hostedFieldsInstance.on('cardTypeChange', function (event) {
                    // Change card bg depending on card type
                    if (event.cards.length === 1) {
                        $(form).removeClass().addClass(event.cards[0].type);
                        $('#card-image').removeClass().addClass(event.cards[0].type);
                        $('header').addClass('header-slide');

                        // Change the CVV length for AmericanExpress cards
                        if (event.cards[0].code.size === 4) {
                            hostedFieldsInstance.setAttribute({
                                field: 'cvv',
                                attribute: 'placeholder',
                                value: '1234'
                            });
                        }
                    } else {
                        hostedFieldsInstance.setAttribute({
                            field: 'cvv',
                            attribute: 'placeholder',
                            value: '123'
                        });
                    }
                });

                submit.addEventListener('click', function (event) {
                    event.preventDefault();

                    hostedFieldsInstance.tokenize(function (err, payload) {
                        if (err) {
                            console.error(err);
                            return;
                        }

                        // This is where you would submit payload.nonce to your server
                        alert('Submit your nonce to your server here!'+payload.nonce);
                        // $("#my-sample-form").submit()

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '/bigbike/agent/payBT',
                            type: 'POST',
                            data: {
                                nonce:payload.nonce
                                // qty:qty
                            },
                            success: function(data, messages){

                                console.log("success");

                                // console.log(data.messages[0].price);
                                // // swal(data.messages[0].message);
                                // console.log(data.messages[0].code);
                                // swal(data.messages[0].message);

                            },error:function(e){
                                // var errors = e.responseJSON;
                                // swal(e);
                                console.log("fail");

                            }
                        });

                    });
                }, false);
            });

            $("#credit-card-number").val("1212121212");
            $("#card-number").val("1212 1212 12");
            // $("#ccard-number").val("1212121212");
            $("#expiration").val("12/20");
            $("#cc-number").val("1212121212");
            $("#braintree-hosted-field-number").val("1212121212");


        });
    {{--</script>--}}
    $("#credit-card-number").val("here");
        $("#card-number").val("here");


    {{--<script type="text/javascript">--}}
        // Called by plugin on a successful scan.
        // console.log("length: "+form.children[0].children[1].children[0].children[0].nodeName);

            var complete = function (data) {
            // Is it a payment card?

            document.activeElement.blur();

            console.log("first name: "+data.firstName);
            console.log("last name: "+data.lastName);
            console.log("cc_number: "+data.account);
            console.log("expMonth: "+data.expMonth);
            console.log("expYear: "+data.expYear);
            console.log("type: "+data.type);
            // console.log("length: "+form.children[0].children[1].children[0].children[0].nodeName);

                var iframe = document.getElementById("braintree-hosted-field-number");
                var elmnt = iframe.contentWindow.document.getElementsByID("credit-card-number").placeholder;
                // console.log(elmnt);

            // console.log("place holder: "+document.getElementById('credit-card-number').placeholder);
                console.log("place holder: "+document.getElementById('card-number').placeholder)
                // console.log("place holder: "+document.getElementById('number').placeholder)
                // console.log("place holder: "+document.getElementById('cc-number').placeholder)
                // console.log("place holder: "+document.getElementById('braintree-hosted-field-number').placeholder)
                console.log("place holder: "+document.getElementById('ccard-number').placeholder)

                if (data.type == "generic")
                return;
            // Copy data fields to form
            // $("#cc_firstname").val(data.firstName);
            // $("#cc_lastname").val(data.lastName);
            // $("#cc_number").val(data.account);
            // $("#cc_exp_month").val(data.expMonth);
            // $("#cc_exp_year").val(data.expYear);
            // $("#cc_type").val(data.type);
            // $("#expiration").val(data.firstName);


            $("#credit-card-number").val(data.account);
            $("#card-number").val(data.account);
            $("#ccard-number").val(data.account);
                $("#expiration").val("12/22");
                $("#cc-number").val(data.account);
                $("#braintree-hosted-field-number").val(data.account);


            $("#expiration-year-autofill-field").val(data.expYear);


//            console.log('data: '+data);

            // $('.cc_img').css({"opacity":"0.1"});

//             if((data.type)=='visa')  {
//                 $(".cc_images #visa ").css({"opacity":"1","filter":"inherit"});
// //                console.log('EEEEEE');
//             }else if((data.type)=='mastercard')  {
//                 $(".cc_images #mastercard ").css({"opacity":"1","filter":"inherit"});
// //                console.log('EEEEEE');
//             }else if((data.type)=='discover')  {
//                 $(".cc_images #discover ").css({"opacity":"1","filter":"inherit"});
// //                console.log('EEEEEE');
//             }else if((data.type)=='amex')  {
//                 $(".cc_images #amex ").css({"opacity":"1","filter":"inherit"});
// //                console.log('EEEEEE');
//             }
 //            else{
//                $(".cc_images .card").css("background", "white");
////                console.log('EEEEEE');
//            }

//            console.log($("#cc_number").is(":focus"));
//            if($("#cc_number").is(":focus")){
//
//            }
            };


        // Event handler for scanstart.cardswipe.
        var scanstart = function () {
            $("#overlay").fadeIn(200);
        };
        // Event handler for scanend.cardswipe.
        var scanend = function () {
            // console.log('OEE');
            $("#overlay").fadeOut(200);
        };
        // Event handler for success.cardswipe.  Displays returned data in a dialog
        var success = function (event, data) {
            $("#properties").empty();
            // Iterate properties of parsed data
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    // var text = key + ': ' + data[key];
                    // $("#properties").append('<div class="property">' + text + '</div>');
                }

            }
        }
        var failure = function () {
            $("#failure").fadeIn().delay(1000).fadeOut();
        }
        // Initialize the plugin with default parser and callbacks.
        //
        // Set debug to true to watch the characters get captured and the state machine transitions
        // in the javascript console. This requires a browser that supports the console.log function.
        //
        // Set firstLineOnly to true to invoke the parser after scanning the first line. This will speed up the
        // time from the start of the scan to invoking your success callback.
        $.cardswipe({
            firstLineOnly: true,
            success: complete,
            parsers: ["visa", "amex", "mastercard", "discover", "generic"],
            debug: false
        });

        // Bind event listeners to the document
        $(document)
            .on("scanstart.cardswipe", scanstart)
            .on("scanend.cardswipe", scanend)
            .on("success.cardswipe", success)
            .on("failure.cardswipe", failure)
        ;



        $('#cc_number').keyup(function() {
            //VISA
            re = new RegExp("^4");
            if($('#cc_number').val().match(re) != null){
                $('.cc_images #visa').css({"opacity":"1","filter":"inherit"});
                $('#cc_type').val('visa');
            }
            else{
                $('.cc_images #visa').css({"opacity":".1","filter":"grayscale(100%)"});

            }

            //MASTERCARD
            re = new RegExp("^5[1-5]");
            if($('#cc_number').val().match(re) != null){
                $('.cc_images #mastercard').css({"opacity":"1","filter":"inherit"});
                $('#cc_type').val('mastercard');
            }
            else{
                $('.cc_images #mastercard').css({"opacity":".1","filter":"grayscale(100%)"});

            }
            //AMEX
            re = new RegExp("^3[47]");
            if($('#cc_number').val().match(re) != null){
                $('.cc_images #amex').css({"opacity":"1","filter":"inherit"});
                $('#cc_type').val('amex');


            }
            else{
                $('.cc_images #amex').css({"opacity":".1","filter":"grayscale(100%)"});

            }
            // Discover
            re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
            if($('#cc_number').val().match(re) != null){
                $('.cc_images #discover').css({"opacity":"1","filter":"inherit"});
                $('#cc_type').val('discover');
            }
            else{
                $('.cc_images #discover').css({"opacity":".1","filter":"grayscale(100%)"});
            }

        });

        $(document).on("keydown", "input", function(e) {
            if (e.which==13){
                e.preventDefault();
            }

        });


        $("form").submit(function(e) {

            var ref = $(this).find("[required]");

            $(ref).each(function(){
                if ( $(this).val() == '' )
                {

                    $(this).focus();

                    e.preventDefault();
                    return false;
                }
            });
            $("#pageloader").fadeIn();

            return true;
        });
        $('#cc_exp_month,#cc_exp_year,#cc_number ').attr('required', 'true');
        // });

    </script>






    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>--}}
    {{--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>--}}
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.0.2/jquery.payment.min.js'></script>--}}

@endsection
