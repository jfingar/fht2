$(document).ready(function(){
    initSaveNewPassword();
});

function initSaveNewPassword(){
    var pwResetForm = $('#resetPwForm');
    pwResetForm.submit(function(){
        showLoader(pwResetForm);
        pwResetForm.find('.ajaxResponseContainer').hide();
        $.ajax({
            url : 'save-new-password',
            type : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success : function(errors){
                hideLoader(pwResetForm);
                if(errors.length){
                    var errorString = '';
                    for(var i in errors){
                        errorString += '<div>' + errors[i] + '</div>';
                    }
                    pwResetForm.find('.ajaxResponseContainer').addClass('errors').html(errorString).show();
                }else{
                    pwResetForm.find('.ajaxResponseContainer').addClass('success').html("<div>Your password has been reset. Please click <a href=\"/index\">here</a> to login.</div>").show();
                }
            }
        });
        return false;
    });
}