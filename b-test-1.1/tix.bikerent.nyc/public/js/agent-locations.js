$(document).ready(function(){
    $('#itemImage').change(function(){
        var src = $(this).find('option:selected').attr('data-img');
        $('img#changeImage').attr('src',src);
    });
});