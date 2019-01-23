$(document).ready(function() {

    $( ".datepicker" ).datepicker({
        //minDate: new Date()-100
    });

    $(".datepicker").datepicker().datepicker("setDate", new Date());


    $( "#datepicker" ).value = new Date();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



});