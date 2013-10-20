var loadingGif = '<img src="/img/loader.gif" alt="Loading..." class="loadingGif" />';
$(document).ready(function(){
    $('body').on('click','.notification-close',function(){
        $('#notification').html("").hide();
    });
    $('#hcp-info').qtip({
        position : {
            my : 'top center',
            at : 'bottom center'
        },
        content : {
            title : 'About Handicap Calculation',
            text : $('#hcp-tooltip-content-wrapper').html()
        },
        style : {
            classes : 'hcp-tooltip'
        },
        hide: {
            fixed : true,
            delay : 500
        }
    });
});
function showLoader(form){
    form.find('input[type="submit"]').hide();
    form.find('.submitContainer').append(loadingGif);
}

function hideLoader(form){
    form.find('.loadingGif').remove();
    form.find('input[type="submit"]').show();
}
google.load("feeds", "1");
function initRssFeed(url,containerID){
    var feed = new google.feeds.Feed(url);
	feed.setResultFormat(google.feeds.Feed.JSON_FORMAT);
	feed.setNumEntries(5);
	feed.load(function(result){
        var feedHtml = "";
        for (var i = 0; i < result.feed.entries.length; i++) {
            var entry = result.feed.entries[i];
            var buildFeed = "<div class='feed-container'><a href='" + entry.link + "'>" + entry.title + "</a><span style='font-weight:normal;font-style:normal;font-size:11px;'>" + entry.contentSnippet + "</span></div><br />";
            feedHtml += buildFeed;
        }
        $("#" + containerID).html(feedHtml);
    });
}

function notify(msg,title){
    $('#notification').html('<div class="notification-header">' + title + '</div>')
    .append(msg)
    .append('<div class="notification-close">Close</div>')
    .show();
    $('#notification').draggable({
        handle : '.notification-header'
    });
}

function refreshStats(){
    $.get('/members-area/get-stats',function(response){
        $('#hcp').text(response.hcp);
        $('#best').text(response.best);
        $('#avg').text(response.avg);
        $('#rounds').text(response.count);
    },'json');
}