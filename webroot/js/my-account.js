$(document).ready(function(){
    var ogFirstName = $('#firstName').val();
    var ogLastName = $('#lastName').val();
    var ogEmail = $('#email').val();
    
    $('#firstName, #lastName, #email').keyup(function(){
        if($('#firstName').val() == ogFirstName && $('#lastName').val() == ogLastName && $('#email').val() == ogEmail){
            $('#member-data-submit').hide();
        }else{
            $('#member-data-submit').show();
        }
    });
});