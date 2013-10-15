$(document).ready(function(){
    initAccountUpdate();
    $('.deleteAcctLinkContainer').click(function(){
        if(confirm("Are you sure you want to delete your account? All of your scores and account data will be permanently erased!")){
            $.ajax({
                url : '/members-area/delete-account',
                success : function(){
                    window.location.href = '/index';
                }
            });
        }
    });
    $("#pw1, #pw2").val("");
    $('.changePwLinkContainer').click(function(){
        var pwContainer = $('.changePwContainer');
        if(pwContainer.is(':visible')){
            pwContainer.slideUp();
            $('#pw1, #pw2').val("");
        }else{
            pwContainer.slideDown();
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
                    $('#pw1, #pw2').val("");
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