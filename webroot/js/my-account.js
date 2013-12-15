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
    $.get('/members-area/get-monthly-graph-data',function(response){
    	if(response.length > 0){
    		response = response[0];
	        var container = [];
	        var counter = 0;
	        var startingDate = '';
	        for(var i in response){
	            var hcpDatePair = [i,response[i]];
	            container.push(hcpDatePair);
	            if(counter === 0){
	                startingDate = i;
	            }
	            counter++;
	        }
	        $.jqplot('hcp-graph',[container],{
	            title : 'Handicap Index History (past year)',
	            axes : {
	                xaxis : {
	                    renderer : $.jqplot.DateAxisRenderer,
	                    tickOptions : {formatString : '%b %Y'},
	                    min : startingDate,
	                    tickInterval : '1 month'
	                },
	                yaxis : {
	                	tickOptions : {
	                		formatString : '%.1f'
	                	}
	                }
	            },
	            highlighter: {
	                showTooltip : true
	            },
	            series : [{
	            	pointLabels : {
	            		show : true            		
	            	}
	            }]
	        });
    	}
    },'json');
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