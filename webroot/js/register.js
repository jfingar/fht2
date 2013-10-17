$(document).ready(function(){
    initRegister();
    initRssFeed("http://www.thegolfchannel.com/rss/?FeedID=NewsArchive",'golf-channel-rss');
    $('#tandc-modal').dialog({
        autoOpen : false,
        modal : true,
        width : 400
    });
    $('#tancd-link').click(function(){
        $('#tandc-modal').dialog('open');
    });
});

function initRegister(){
    var registerForm = $('#registerForm');
    registerForm.submit(function(){
        showLoader(registerForm);
        $('.ajaxResponseContainer').hide();
        $.ajax({
            url : 'do-register',
            type : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success : function(response){
                if(response.status){
                    window.location.href = 'members-area/view-scores';
                }else{
                    hideLoader(registerForm);
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