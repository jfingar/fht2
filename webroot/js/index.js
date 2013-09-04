$(document).ready(function(){
    initRssFeed("http://www.thegolfchannel.com/rss/?FeedID=NewsArchive",'golf-channel-rss');
    initLogin();
    $('#fgt-pswd-modal').dialog({
        title : 'Password Reset',
        autoOpen : false,
        modal : true,
        height : 175,
        width: 500
    });
    $('#fgt-pswd').click(function(){
        $('#fgt-pswd-modal').dialog('open');
    });
    $('#fgt-pswd-form').submit(function(){
        $.ajax({
            url : 'send-reset-pw-email',
            type : 'post',
            data : $(this).serialize(),
            success : function(response){
                
            }
        });
        return false;
    });
});

function initLogin(){
    var loginForm = $('#loginForm');
    loginForm.submit(function(){
        showLoader(loginForm);
        $('.ajaxResponseContainer').hide();
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
                    $('.ajaxResponseContainer').addClass('errors').html(errorString).show();
                }
            }
        });
        return false;
    });
}