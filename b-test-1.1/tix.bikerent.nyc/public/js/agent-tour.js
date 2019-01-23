function getPrice(cur,name){

    console.log("click: " +cur.id.charAt(0));
    var c = cur.id.charAt(0);
    var curRow = '0';
    if($('#tour_type').val()=='public(2h)'){
        curRow = '0';
    }else if($('#tour_type').val()=='private(2h)'){
        curRow='1';
    }else if($('#tour_type').val()=='private(3h)'){
        curRow='2';
    }

    //check if the same row
    if(c!=curRow){
        //curRow = c;
        $(cur).notify("Please choose tour type first", {position:"right middle",autoHideDelay:2000});
        //console.log('not equal');
        return false;
    }

    for(j=0;j<3;j++) {
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
    var nam = name+'_tour';
    if($(nam).val()<=19){
        $(nam).val(parseInt($(nam).val())+1);
    }

    calculate();
}


$(function() {

    $( ".field" ).keyup(function() {
        console.log( "Handler for .change() called." );
        calculate();
    });

    $('.ui-spinner-button').click(function () {
        console.log("Handler for .change() called.");
        calculate();
    });


    for(i=0;i<=bikes.length;i++){
        var tmp = '#'+0+i;
        console.log(tmp);
        $(tmp).css('background-color','#rgb(232, 232, 232);');
        //$(tmp).notify("Please input valid name", {position:"right middle"});
    }

    $('.tour-title').click(function () {
        console.log("check hour.");
        $('#tour_type').val(this.value);
        // console.log("now: "+$('#rent_duration').val());
        console.log('id: '+this.id);
        var c = this.id.charAt(0);
        for(j=0;j<=2;j++) {
            for (i = 0; i <= bikes.length; i++) {
                var tmp = '#' + j + i;
                console.log(tmp);
                $(tmp).css('background-color', 'white');
                //$(tmp).notify("Please input valid name", {position:"right middle"});
            }
        }
        for(i=0;i<=bikes.length;i++){
            var tmp = '#'+c+i;
            console.log(tmp);
            $(tmp).css('background-color','#rgb(232, 232, 232);');
            //$(tmp).notify("Please input valid name", {position:"right middle"});
        }
        calculate();
    });

    $("#cash_paid_label").keyup(function() {
        var customer = parseFloat($( "#cash_paid_label" ).val());
        var agent = parseFloat($( "#tour_tips" ).val());
        console.log("here");
        if(customer>=agent){
            console.log("true");
            $("#cash_change_label").val((customer-agent).toFixed(2)).css('color','green');
        }else{
            console.log("false");
        }
    });

    $('#tour_type').change(function() {

        //console.log( "Handler for .change() called." );
        for(j=0;j<=2;j++) {
            for (i = 0; i <= bikes.length; i++) {
                var tmp = '#' + j + i;
                //console.log(tmp);
                $(tmp).css('background-color', 'white');
                //$(tmp).notify("Please input valid name", {position:"right middle"});
            }
        }
        var curRow = '0';
        if($('#tour_type').val()=='public(2h)'){
            curRow = '0';
        }else if($('#tour_type').val()=='private(2h)'){
            curRow='1';
        }else if($('#tour_type').val()=='private(3h)'){
            curRow='2';
        }

        for(i=0;i<=bikes.length;i++){
            var tmp = '#'+curRow+i;
            //console.log(tmp);
            $(tmp).css('background-color','#rgb(232, 232, 232)');
            //$(tmp).notify("Please input valid name", {position:"right middle"});
        }
        calculate();
    });

    goBack();


});


function goBack(){
    //check go back this page
    var curRow = 0;
    if($('#tour_type').val()=='public(2h)'){
        curRow = 0;
    }else if($('#tour_type').val()=='private(2h)'){
        curRow=1;
    }else if($('#tour_type').val()=='private(3h)'){
        curRow=2;
    }

    for(j=0;j<=2;j++) {
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

var bikes = ["#adult_tour","#child_tour"];
function calculate(){
    var s = 0;
    if($('#tour_type').val()=='public(2h)'){
        s = 0;
    }else if($('#tour_type').val()=='private(2h)'){
        s=1;
    }else if($('#tour_type').val()=='private(3h)'){
        s=2;
    }

    console.log("#"+s+'1');
    var total = 0;
    var bikeNum = 0;
    for(i=1;i<=bikes.length;i++){
        console.log("adults: "+$(bikes[i-1]).val());
        total += parseFloat($(bikes[i-1]).val()*$("#"+s+i).val());
        bikeNum += parseInt($(bikes[i-1]).val());
    }

    var tax = 1.08875;
    $("#tour_total").val(total).css('color','green');
    // $("#tour_tips").val((total*0.2995).toFixed(2)).css('color','green');
    $("#tour_tips").val((total*tax*rate).toFixed(2)).css('color','green');

    $("#tour_tax").val((total*0.08875).toFixed(2)).css('color','green');
    $("#tour_total_after_tax").val((total*tax).toFixed(2)).css('color','green');
    // console.log("");
    $("#agent_deposit").val(($("#tour_total_after_tax").val()*rate).toFixed(2)).css('color','green');
    $("#payment_due_in_store").val(($("#tour_total_after_tax").val()-$("#agent_deposit").val()).toFixed(2)).css('color','green');

}

function ccSubmitCheck(){
    if(!checkName()) return false;
    if(!checkEmail()) return false;
    if(!checkBikeNum()) return false;
    if(!checkValid()) return false;


    var floatRegex = /^(0\.[1-9]|[1-9][0-9]{0,2}(\.[0-9]{0,2})?)$/;
    // console.log("price: "+$('#tour_total').val().replace('$',''));
    if(!$('#tour_total').val().match(floatRegex)){
        $('#tour_total').notify("Please input valid price", {position: "right middle"});
        return false;
    }else{
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
    // console.log("price: "+$('#tour_total').val().replace('$',''));

    if(!$('#tour_tips').val().match(floatRegex)){

        $('#tour_tips').notify("Please input valid price", {position: "bottom center",autoHideDelay:2000});
        return false;
    }

    var agent_price = parseFloat($('#rent_tips_label').val());
    var total_price = (parseFloat($('#rent_total_label').val())*rate).toFixed(2);

    if(agent_price>total_price){
        $('#rent_tips_label').notify("Can not be more than $"+total_price, {position: "bottom center",autoHideDelay:2000});
        return false;
    }else{
        return true;
    }
}

function checkName(){
    if($('#tour_customer_first').val().length<=0){
        $('#tour_customer_first').notify("Please input valid name", {position:"bottom center",autoHideDelay:2000});
        return false;
    }else if($('#tour_customer_last').val().length<=0){
        $('#tour_customer_last').notify("Please input valid name", {position:"bottom center",autoHideDelay:2000});
    } else{
        return true;
    }
}

function checkBikeNum(){

    if($('#adult_tour').val()==0 && $('#child_tour').val()==0){
        $('#child_tour_label').notify("Tour number can't be 0", {position:"right bottom",autoHideDelay:2000});
        return false;
    }else{
        return true;
    }
}

function checkValid(){
    var numReg = /^\d+$/;
    var dateReg = /^\d{2}[/]\d{2}[/]\d{4}$/;


    if(!$('#adult_tour').val().match(numReg)||!$('#child_tour').val().match(numReg)){

        $('#child_tour_label').notify("Please input valid number", {position: "right bottom",autoHideDelay:2000});

        return false;
    }else if(!$('#tour_date').val().match(dateReg)){
        $('#tour_date').notify("Please input valid date", {position: "top center",autoHideDelay:2000});
        return false;
    } else{
        return true;
    }
}


function checkEmail(){
    if($('#tour_email').val().trim().length<=0){
        $('#tour_email').notify("Please input valid email", {position: "top right"});
        return false;
    }
    return true;
}