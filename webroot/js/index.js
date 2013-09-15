$(document).ready(function(){
    initRssFeed("http://www.thegolfchannel.com/rss/?FeedID=NewsArchive",'golf-channel-rss');
    initLogin();
    initPwReset();
    $('#fgt-pswd-modal').dialog({
        title : 'Password Reset',
        autoOpen : false,
        modal : true,
        width: 500
    });
    $('#fgt-pswd').click(function(){
        $('#fgt-pswd-modal').dialog('open');
    });
});

function initLogin(){
    var loginForm = $('#loginForm');
    loginForm.submit(function(){
        showLoader(loginForm);
        loginForm.find('.ajaxResponseContainer').hide();
        $.ajax({
            url : 'login',
            type : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success : function(response){
                if(response.status){
                    window.location.href = '/members-area/view-scores';
                }else{
                    hideLoader(loginForm);
                    var errorString = '';
                    for(var i in response.errors){
                        errorString += '<div>' + response.errors[i] + '</div>';
                    }
                    loginForm.find('.ajaxResponseContainer').addClass('errors').html(errorString).show();
                }
            }
        });
        return false;
    });
}

function initPwReset(){
    var pwResetForm = $('#pwResetForm');
    pwResetForm.submit(function(){
        showLoader(pwResetForm);
        pwResetForm.find('.ajaxResponseContainer').hide();
        $.ajax({
            url : 'send-reset-pw-email',
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
                    // display success msg
                }
            }
        });
        return false;
    });
}