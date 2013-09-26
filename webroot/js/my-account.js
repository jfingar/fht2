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
    $('#delete-account').click(function(){
        if(confirm("Are you sure you want to delete your account? All of your scores and account data will be permanently erased!")){
            $.ajax({
                url : '/members-area/delete-account',
                success : function(){
                    window.location.href = '/index';
                }
            });
        }
    });
});