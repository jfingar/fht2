$(document).ready(function(){
    initAccountUpdate();
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
    refreshStats();
});

function initAccountUpdate(){
    var memberDataForm = $('#memberDataForm');
    memberDataForm.submit(function(){
        showLoader(memberDataForm);
        memberDataForm.find('.ajaxResponseContainer').hide();
        $.ajax({
            url : '/members-area/save-member-data',
            type : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success : function(errors){
                hideLoader(memberDataForm);
                if(!errors.length){
                    notify("Your account has been updated.","Account Updated");
                }else{
                    hideLoader(memberDataForm);
                    var errorString = '';
                    for(var i in errors){
                        errorString += '<div>' + errors[i] + '</div>';
                    }
                    memberDataForm.find('.ajaxResponseContainer').addClass('errors').html(errorString).show();
                }
            }
        });
        return false;
    });
}