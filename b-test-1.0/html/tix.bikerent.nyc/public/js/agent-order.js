$(document).ready(function() {
    // $('#contact_form').bootstrapValidator({
    //     // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
    //     feedbackIcons: {
    //         valid: 'glyphicon glyphicon-ok',
    //         invalid: 'glyphicon glyphicon-remove',
    //         validating: 'glyphicon glyphicon-refresh'
    //     },
    //     fields: {
    //         first_name: {
    //             validators: {
    //                 stringLength: {
    //                     min: 2,
    //                 },
    //                 notEmpty: {
    //                     message: 'Please supply your first name'
    //                 }
    //             }
    //         },
    //         last_name: {
    //             validators: {
    //                 stringLength: {
    //                     min: 2,
    //                 },
    //                 notEmpty: {
    //                     message: 'Please supply your last name'
    //                 }
    //             }
    //         },
    //         email: {
    //             validators: {
    //                 notEmpty: {
    //                     message: 'Please supply your email address'
    //                 },
    //                 emailAddress: {
    //                     message: 'Please supply a valid email address'
    //                 }
    //             }
    //         },
    //         phone: {
    //             validators: {
    //                 notEmpty: {
    //                     message: 'Please supply your phone number'
    //                 },
    //                 phone: {
    //                     country: 'US',
    //                     message: 'Please supply a vaild phone number with area code'
    //                 }
    //             }
    //         },
    //         address: {
    //             validators: {
    //                 stringLength: {
    //                     min: 8,
    //                 },
    //                 notEmpty: {
    //                     message: 'Please supply your street address'
    //                 }
    //             }
    //         },
    //         city: {
    //             validators: {
    //                 stringLength: {
    //                     min: 4,
    //                 },
    //                 notEmpty: {
    //                     message: 'Please supply your city'
    //                 }
    //             }
    //         },
    //         state: {
    //             validators: {
    //                 notEmpty: {
    //                     message: 'Please select your state'
    //                 }
    //             }
    //         },
    //         zip: {
    //             validators: {
    //                 notEmpty: {
    //                     message: 'Please supply your zip code'
    //                 },
    //                 zipCode: {
    //                     country: 'US',
    //                     message: 'Please supply a vaild zip code'
    //                 }
    //             }
    //         },
    //         comment: {
    //             validators: {
    //                 stringLength: {
    //                     min: 10,
    //                     max: 200,
    //                     message:'Please enter at least 10 characters and no more than 200'
    //                 },
    //                 notEmpty: {
    //                     message: 'Please supply a description of your project'
    //                 }
    //             }
    //         }
    //     }
    // })
    //
    //     .on('success.form.bv', function(e) {
    //         $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
    //         $('#contact_form').data('bootstrapValidator').resetForm();
    //
    //         // Prevent form submission
    //         e.preventDefault();
    //
    //         // Get the form instance
    //         var $form = $(e.target);
    //
    //         // Get the BootstrapValidator instance
    //         var bv = $form.data('bootstrapValidator');
    //
    //         // Use Ajax to submit form data
    //         $.post($form.attr('action'), $form.serialize(), function(result) {
    //             console.log(result);
    //         }, 'json');
    //     });
    //$( "#datepicker" ).datepicker();

    $( ".datepicker" ).datepicker({
        minDate: new Date()
    });

    $(".datepicker").datepicker().datepicker("setDate", new Date());


    $('.spinner').spinner({
        min: 0,
        max: 20,
        step: 1
    });

    $('.tour-spinner').spinner({
        min: 0,
        max: 15,
        step: 1
    });

    $('.timepicker').timepicker({
        timeFormat: 'H:mm',
        interval: 60,
        minTime: '8',
        maxTime: '19:00',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $( "#datepicker" ).value = new Date();


    $( ".tour-spinner" ).change(function () {
        console.log("change");
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#comCheckbox").change(function() {
        if($(this).prop('checked') == true) {
            $('#agent_com').css('display','inline-block');
        } else {
            // console.log("Checked Box deselect");
            $('#agent_com').css('display','none');
        }
    });
});

