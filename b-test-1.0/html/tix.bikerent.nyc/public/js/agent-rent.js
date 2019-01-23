function getPrice(cur,name){

    if(cur.id=='53'||cur.id=='54'||cur.id=='55'||cur.id=='56'||cur.id=='57'||cur.id=='58'){
        $(cur).notify("No service", {position:"right middle",autoHideDelay:2000});
        //console.log("invalid");
        return false;
    }

    //console.log("click: " +cur.id.charAt(0));
    var c = cur.id.charAt(0);
    var curRow = '0';
    if($('#rent_duration').val()=='1 hour'){
        curRow = '0';
    }else if($('#rent_duration').val()=='2 hours'){
        curRow='1';
    }else if($('#rent_duration').val()=='3 hours'){
        curRow='2';
    }else if($('#rent_duration').val()=='5 hours'){
        curRow='3';
    }else if($('#rent_duration').val()=='All Day (8am-8pm)'){
        curRow='4';
    }else if($('#rent_duration').val()=='24 hours'){
        curRow='5';
    }

    //check if the same row
    if(c!=curRow){
        //curRow = c;
        $(cur).notify("Please choose hours first", {position:"right middle",autoHideDelay:2000});
        //console.log('not equal');
        return false;
    }

    for(j=0;j<=5;j++) {
        for (i = 0; i <= bikes.length; i++) {
            var tmp = '#' + j + i;
            //console.log(tmp);
            $(tmp).css('background-color', 'white');
        }
    }

    for(i=0;i<=bikes.length;i++){
        var tmp = '#'+c+i;
        //console.log(tmp);
        $(tmp).css('background-color','#rgb(232, 232, 232);');
    }
    //update this color
    //update bike nums
    var nam = name+'_bike';
    if($(nam).val()<=19){
        $(nam).val(parseInt($(nam).val())+1);
    }

    calculate();
}


$(function() {

    $( ".field" ).keyup(function() {
        //console.log( "Handler for .change() called." );
        calculate();
    });

    $('.ui-spinner-button').click(function () {
        //console.log("Handler for .change() called.");
        calculate();
    });

    $('#basket').click(function () {
        calculate();
    });
    $('#insurance').click(function () {
        calculate();
    });
    $('#dropoff').click(function () {
        calculate();
    });

    for(i=0;i<=bikes.length;i++){
        var tmp = '#'+0+i;
        //console.log(tmp);
        $(tmp).css('background-color','#rgb(232, 232, 232);');
        //$(tmp).notify("Please input valid name", {position:"right middle"});
    }

    $('.duration-title').click(function () {
        //console.log("check duration.");
        $('#rent_duration').val(this.value);
        // console.log("now: "+$('#rent_duration').val());
        //console.log('id: '+this.id);
        var c = this.id.charAt(0);
        for(j=0;j<=5;j++) {
            for (i = 0; i <= bikes.length; i++) {
                var tmp = '#' + j + i;
                //console.log(tmp);
                $(tmp).css('background-color', 'white');
                //$(tmp).notify("Please input valid name", {position:"right middle"});
            }
        }
        for(i=0;i<=bikes.length;i++){
            var tmp = '#'+c+i;
            //console.log(tmp);
            $(tmp).css('background-color','#rgb(232, 232, 232)');
            //$(tmp).notify("Please input valid name", {position:"right middle"});
        }
        calculate();
    });

    $('#rent_duration').change(function() {

        //console.log( "Handler for .change() called." );
        for(j=0;j<=5;j++) {
            for (i = 0; i <= bikes.length; i++) {
                var tmp = '#' + j + i;
                //console.log(tmp);
                $(tmp).css('background-color', 'white');
                //$(tmp).notify("Please input valid name", {position:"right middle"});
            }
        }
        var curRow = '0';
        if($('#rent_duration').val()=='1 hour'){
            curRow = '0';
        }else if($('#rent_duration').val()=='2 hours'){
            curRow='1';
        }else if($('#rent_duration').val()=='3 hours'){
            curRow='2';
        }else if($('#rent_duration').val()=='5 hours'){
            curRow='3';
        }else if($('#rent_duration').val()=='All Day (8am-8pm)'){
            curRow='4';
        }else if($('#rent_duration').val()=='24 hours'){
            curRow='5';
        }

        for(i=0;i<=bikes.length;i++){
            var tmp = '#'+curRow+i;
            //console.log(tmp);
            $(tmp).css('background-color','#rgb(232, 232, 232)');
            //$(tmp).notify("Please input valid name", {position:"right middle"});
        }
        calculate();

    });


    $("#cash_paid_label").keyup(function() {
        var customer = parseFloat($( "#cash_paid_label" ).val());
        var agent = parseFloat($( "#tips_label" ).val());
        console.log("here");
        if(customer>=agent){
            console.log("true");
            $("#rent_cash_change_label").val((customer-agent).toFixed(2)).css('color','green');
        }else{
            console.log("false");
        }
    });


    goBack();

    // $("#comCheckbox").change(function() {
    //     if($(this).prop('checked') == true) {
    //         $('#agent_com').css('display','inline-block');
    //     } else {
    //         // console.log("Checked Box deselect");
    //         $('#agent_com').css('display','none');
    //     }
    // });


});

function goBack(){
    //check go back this page
    var curRow = 0;
    if($('#rent_duration').val()=='1 hour'){
        curRow = 0;
    }else if($('#rent_duration').val()=='2 hours'){
        curRow=1;
    }else if($('#rent_duration').val()=='3 hours'){
        curRow=2;
    }else if($('#rent_duration').val()=='5 hours'){
        curRow=3;
    }else if($('#rent_duration').val()=='All Day (8am-8pm)'){
        curRow=4;
    }else if($('#rent_duration').val()=='24 hours'){
        curRow=5;
    }

    for(j=0;j<=5;j++) {
        for (i = 0; i <= bikes.length; i++) {
            var tmp = '#' + j + i;
            //console.log(tmp);
            $(tmp).css('background-color', 'white');
            //$(tmp).notify("Please input valid name", {position:"right middle"});
        }
    }

    for(i=0;i<=bikes.length;i++){
        var tmp = '#'+curRow+i;
        //console.log(tmp);
        $(tmp).css('background-color','#rgb(232, 232, 232)');
        //$(tmp).notify("Please input valid name", {position:"right middle"});
    }


}

var bikes = ["#adult_bike", "#child_bike", "#tandem_bike", "#road_bike", "#mountain_bike", "#basket_bike","#trailer_bike", "#seat_bike"];
function calculate(){
    var s = 0;
    if($('#rent_duration').val()=='1 hour'){
        s = 0;
    }else if($('#rent_duration').val()=='2 hours'){
        s=1;
    }else if($('#rent_duration').val()=='3 hours'){
        s=2;
    }else if($('#rent_duration').val()=='5 hours'){
        s=3;
    }else if($('#rent_duration').val()=='All Day (8am-8pm)'){
        s=4;
    }else if($('#rent_duration').val()=='24 hours'){
        s=5;
    }

    console.log("#"+s+'1');
    var total = 0;
    var bikeNum = 0;
    for(i=1;i<=bikes.length;i++){
        total += parseFloat($(bikes[i-1]).val()*$("#"+s+i).val());
        bikeNum += parseInt($(bikes[i-1]).val());
    }

    if($('#insurance').prop('checked')==true){
        total += bikeNum*2;
    }
    if($('#dropoff').prop('checked')==true){
        total += bikeNum*5;
    }
    console.log("rate: "+rate);
    var tax =1.08875;
    $("#rent_total_label").val(total.toFixed(2)).css('color','green');
    $("#rent_tips_label").val((total*tax*rate).toFixed(2)).css('color','green');

    // $("#rent_tips_label").val((total*0.2995).toFixed(2)).css('color','green');
    $("#rent_tax").val((total*0.08875).toFixed(2)).css('color','green');
    $("#rent_total_after_tax").val((parseFloat(total)*tax).toFixed(2)).css('color','green');
    $("#agent_deposit").val(($("#rent_total_after_tax").val()*rate).toFixed(2)).css('color','green');
    $("#payment_due_in_store").val(($("#rent_total_after_tax").val()-$("#agent_deposit").val()).toFixed(2)).css('color','green');


}

function ccSubmitCheck(){
    if(!checkName()) return false;
    if(!checkEmail()) return false;
    if(!checkBikeNum()) return false;
    if(!checkValid()) return false;

    var floatRegex = /^(0\.[1-9]|[1-9][0-9]{0,2}(\.[0-9]{0,2})?)$/;

    if(!$('#rent_total_label').val().match(floatRegex)){
        $('#rent_total_label').notify("Please input valid price", {position: "right middle"});
        return false;
    }else{
        // location.href = "/var/www/html/tix.bikerent.nyc/resources/views/bigbike/agent/contact.blade.php";
        $("#cc-hidden").click();
        return false;

    }
}


function cashSubmitCheck(){
    if(!checkName()) return false;
    if(!checkEmail()) return false;
    if(!checkBikeNum()) return false;
    if(!checkValid()) return false;

    var floatRegex = /^(0\.[1-9]|[1-9][0-9]{0,2}(\.[0-9]{0,2})?)$/;
    // console.log("pre checked");
    if(!$('#rent_tips_label').val().match(floatRegex)){
        $('#rent_tips_label').notify("Please input valid price", {position: "bottom center"});
        return false;
    }

    var agent_price = parseFloat($('#rent_tips_label').val());
    var total_price = (parseFloat($('#rent_total_after_tax').val())*rate).toFixed(2);
    // console.log("pre checked 2");

    if(agent_price>total_price){

        // console.log("fail checked agent: "+agent_price+" ,total: "+total_price);

        $('#rent_tips_label').notify("Can not be more than $"+total_price, {position: "bottom center"});
        return false;
    }else{
        console.log("all checked");
        $("#cash-hidden").click();
        return false;

        // return true;
    }
}


function checkName(){
    if($('#rent_customer').val().length<=0){
        console.log("no name");
        $('#rent_customer').notify("Please input valid name", {position:"bottom center"});
        return false;
    }else if($('#rent_customer_last').val().length<=0){
        $('#rent_customer_last').notify("Please input valid name", {position:"bottom center"});
        return false;
    }
    else{
        return true;
    }
}

function checkBikeNum(){

    if($('#adult_bike').val()==0 && $('#child_bike').val()==0 && $('#tandem_bike').val()==0 && $('#road_bike').val()==0 &&
        $('#mountain_bike').val()==0){
        $('#adult_bike_label').notify("Bike number can't be 0", {position:"top center"});
        return false;
    }else{
        return true;
    }

}

function checkValid(){
    var numReg = /^\d+$/;
    var timeReg = /([01]\d|2[0-3]):([0-5]\d)/;
    var dateReg = /^\d{2}[/]\d{2}[/]\d{4}$/;


    if(!$('#adult_bike').val().match(numReg)||!$('#child_bike').val().match(numReg)||!$('#tandem_bike').val().match(numReg)
        ||!$('#road_bike').val().match(numReg) ||!$('#mountain_bike').val().match(numReg)||!$('#trailer_bike').val().match(numReg)
        ||!$('#seat_bike').val().match(numReg)){


        $('#road_bike').notify("Please input valid number", {position: "top right"});

        return false;
    }else if(!$('#rent_date').val().match(dateReg)){
        $('#rent_date_label').notify("Please input valid date", {position: "top right"});
        return false;
    } else if(!$('#rent_time').val().match(timeReg)){
        $('#rent_time_label').notify("Please input valid time", {position: "top right"});
        return false;
    }else{

        return true;
    }
}

function checkEmail(){
    if($('#rent_email').val().trim().length<=0){
        $('#rent_email').notify("Please input valid email", {position: "top right"});
        return false;
    }
    return true;
}
// $(function() {
//     $('.btn-default').value('#00').css('bacgkound-color','white');
//
//
// });

function myfuncCash() {
    console.log("here");
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

    document.getElementById("nameCash").innerHTML = "<b>Customer Name:</b> " + first_name + " " + last_name;
    document.getElementById("emailCash").innerHTML = "<b>Email:</b> " + rent_email;
    document.getElementById("dateCash").innerHTML = "<b>Date:</b> " + rent_date;
    document.getElementById("timeCash").innerHTML = "<b>Time:</b> " + rent_time;
    document.getElementById("durationCash").innerHTML = "<b>Rent Duration:</b> " + strUser;

    document.getElementById("adultCash").innerHTML = "<b>Adult Bikes:</b> " + adult_bike;
    document.getElementById("childCash").innerHTML = "<b>Child Bikes:</b> " + child_bike;
    document.getElementById("tandemCash").innerHTML = "<b>Tandem Bikes:</b> " + tandem_bike;
    document.getElementById("roadCash").innerHTML = "<b>Road Bikes:</b> " + road_bike;
    document.getElementById("mountainCash").innerHTML = "<b>Mountain Bikes:</b> " + mountain_bike;
    document.getElementById("trailerCash").innerHTML = "<b>Trailer for Bikes:</b> " + trailer_bike;
    document.getElementById("seatCash").innerHTML = "<b>Seat for Bikes:</b> " + seat_bike;
    document.getElementById("basketCash").innerHTML = "<b>Basket for Bikes:</b> " + basket_bike;

    document.getElementById("totalCash").innerHTML = "<b>Total Price after Tax: </b>" + "$" + total_tax;

    // $("#myModal").toggle();
}


