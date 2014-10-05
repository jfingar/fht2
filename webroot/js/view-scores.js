/** sort parameters **/
var sortField = 'date';
var sortDir = 'DESC';

/** Pagination params **/
var rowsPerPage = 10;
var currentPage = 1;
var totalPages;

/** container (array) for score objects **/
var scores;

/** main container for table (cache as jQuery object) **/
var scoresTableContainer;

/** Html & Templates Cache **/
var scoresTable;
var scoresTableHeadings;
var addScoreRow;
var addScoreRowActive;
var scoreRow;
var editScoreRow;

$(document).ready(function(){
    /** Cache html & templates **/
    scoresTableContainer = $('#scores-table-container');
    scoresTable = $('#scores-table-template').html();
    scoresTableHeadings = $('#scores-table-headings-template').html();
    addScoreRow = $('#add-score-template').html();
    addScoreRowActive = $('#add-score-active-template').html();
    scoreRow = $('#score-template').html();
    editScoreRow = $('#edit-score-template').html();
    
    /** bind events **/
    $('body').on('click','.sortable',function(){sortTable($(this));});
    $('body').on('click','.row-icon.delete',function(){deleteScore($(this));});
    $('body').on('click','.row-icon.edit',function(){editScore($(this));});
    $('body').on('click','.row-icon.cancelSave',function(){cancelSave($(this));});
    $('body').on('click','.row-icon.save',function(){saveScore($(this));});
    $('body').on('click','.add-score',function(){addScore();});
    $('#delete-all').click(function(){deleteAllScores();});
    $('.pagination-arrows').click(function(){nav($(this));});
    $('#export-csv').click(function(){exportCsv();});
    
    /** bind datepicker widget **/
    $('body').on('focus','.formattedDate',function(){
        $(this).datepicker();
    });
    
    /** Kickoff main score load process **/
    fetchUserScores(true);

    // adTrigger();
    refreshStats();
    
    $('#get-alternate-user-hcp').click(function(){
        notify($('#alternate-user-lookup-content-wrapper').html(), "Alternate User Handicap Lookup");
    });
    
    $('body').on('submit', '#alternate-user-lookup-content form', function(){
        $('#alt-user-lookup-response').html("").hide();
        $.ajax({
            type : $(this).attr('method'),
            dataType : 'json',
            data : $(this).serialize(),
            url : $(this).attr('action'),
            success : function(response){
                if(response.length){
                    $('#alt-user-lookup-response').html("<div id=\"alt-lookup-response-label\">User \"" + $("#alternate-user-email").val() + "\"<br />current Hanidcap Index:</div><div id=\"alt-lookup-response-hcp\">" + response[0] + "</div>").show();
                }else{
                    $('#alt-user-lookup-response').html("<div class=\"errors\" style=\"padding: 6px;\">User handicap not available, or user not found.</div>").show();
                }
            }
        });
        return false;
    });
});

function initAutocomplete(){
    $('#add-score-active .score-input.courseName').autocomplete({
        source : function(request,response){
            $.ajax({
                url : '/members-area/auto-complete',
                data : {searchTerm : request.term},
                dataType : 'json',
                type : 'get',
                success : function(data){
                    if(data.length){
                        var suggestionData = [];
                        for(var i in data){
                            var courseName = data[i].courseName;
                            var slope = data[i].slope;
                            var rating = data[i].rating;
                            var suggestionObj = {
                                label : courseName + " ::: Slope " + slope + " ::: Rating " + rating,
                                value : courseName,
                                slope : slope,
                                rating : rating
                            };
                            suggestionData.push(suggestionObj);
                        }
                        response(suggestionData);
                    }
                }
            });
        },
        select : function(event, ui){
            $("#add-score-active").find('input[name="slope"]').val(ui.item.slope);
            $("#add-score-active").find('input[name="rating"]').val(ui.item.rating);
        }
    });
}

function initTooltip(){
     $('#differential .tooltip').qtip({
        position : {
            my : 'bottom center',
            at : 'top center'
        },
        content : {
            title : 'About Handicap Differential',
            text : $('#differential-tooltip-content-wrapper').html()
        }
    });
}

function adTrigger(){
    $.post('/members-area/ad-trigger',function(response){
        if(response.showAd){
            $('#adModal').dialog('open');
        }
    },'json');
}

function exportCsv(){
    window.location.href = '/members-area/get-csv?orderBy=' + sortField + '&dir=' + sortDir;
}

function deleteAllScores(){
    if(!scores.length){
        notify("No scores found to delete!","Delete All Scores Failed:");
        return;
    }
    var cfm = confirm("Are you sure? This will permanently erase all of your saved scores!");
    if(cfm){
        $.post('/members-area/delete-all-scores',function(){
            fetchUserScores(true);
            refreshStats();
        });
    }
}

function addScore(){
    resetAll();
    var activeRow = $($.parseHTML(addScoreRowActive));
    $('.add-score').replaceWith(activeRow);
    activeRow.find('.score-input.courseName').focus();
    initAutocomplete();
}

function sortTable(obj){
    if(obj.attr('id') == sortField){
        sortDir = sortDir == 'DESC' ? 'ASC' : 'DESC';
    }
    sortField = obj.attr('id');
    currentPage = 1;
    fetchUserScores();
}

function fetchUserScores(isPageLoad){
    $.get('/members-area/get-scores',{sortField : sortField, sortDir : sortDir},function(response){
        scores = response;
        totalPages = Math.ceil(scores.length / rowsPerPage) == 0 ? 1 : Math.ceil(scores.length / rowsPerPage);
        renderScoresView();
        if(isPageLoad){
            $('#fade-in-container').fadeIn("slow");
        }
    },'json');
}

function nav(obj){
    if(currentPage >= totalPages && obj.attr('id') == 'arrow-right'){
        return;
    }
    if(obj.attr('id') == 'arrow-left' && currentPage == 1){
        return;
    }
    if(obj.attr('id') == 'arrow-left'){
        currentPage--;
    }else{
        currentPage++;
    }
    renderScoresView();
}

function renderScoresView(){
    scoresTableContainer.html("");
    scoresTableContainer.append(scoresTable);
    scoresTableContainer.find('#scores-table').append(scoresTableHeadings);
    scoresTableContainer.find('#scores-table').append(addScoreRow);
    var rowsHtml = '';
    var upperRange = currentPage * rowsPerPage;
    var lowerRange = upperRange - rowsPerPage;
    var pageScores = scores.slice(lowerRange,upperRange);
    for(var i in pageScores){
        rowsHtml += Mustache.render(scoreRow,pageScores[i]);
    }
    scoresTableContainer.find('#scores-table').append(rowsHtml);
    refreshSortArrows();
    refreshNavArrows();
    initTooltip();
}

function refreshSortArrows(){
    scoresTableContainer.find('.sortable .sortArrows').each(function(){
        $(this).attr('src','/img/sort_neutral_green.png');
    });
    var arrow_src = sortDir == 'DESC' ? '/img/sort_down_green.png' : '/img/sort_up_green.png';
    scoresTableContainer.find('#' + sortField + ' .sortArrows').attr('src',arrow_src);
}

function refreshNavArrows(){
    $('.pagination-arrows').css('opacity','0.5');
    if(scores.length <= rowsPerPage){
        $('.pagination-arrows').css('opacity','0.5');
    }else{
        if(currentPage == 1){
            $('#arrow-right').css('opacity','1');
        }else if(currentPage > 1 && (currentPage * rowsPerPage) >= scores.length){
            $('#arrow-left').css('opacity','1');
        }else{
            $('.pagination-arrows').css('opacity','1');
        }
    }
    if(scores.length <= ((currentPage - 1) * rowsPerPage)){
        nav($('#arrow-left'));
    }
    $('#pagination').text("Page " + currentPage + "/" + totalPages);
}

function deleteScore(obj){
    var i = obj.parents('tr').index() - 2;
    i = (rowsPerPage * (currentPage - 1)) + i;
    var cfmMsg = 'Are you sure you want to delete this score?\r\n(' + scores[i].score + ' at ' + scores[i].courseName + ' on ' + scores[i].formattedDate + ')';
    var proceed = confirm(cfmMsg);
    if(proceed){
        var scoreId = obj.parents('tr').find('input[name="id"]').val();
        $.post('/members-area/delete-score',{id : scoreId},function(){
            fetchUserScores();
            refreshStats();
        });
    }
}

function editScore(obj){
    resetAll();
    var row = obj.parents('tr');
    var i = row.index() - 2;
    i = (rowsPerPage * (currentPage - 1)) + i;
    row.replaceWith(Mustache.render(editScoreRow,scores[i]));
}

function resetAll(){
    if($('#add-score-active').length){
        cancelSave($('#add-score-active').find('.cancelSave'));
    }
    $('.edit-score').each(function(){
        cancelSave($(this).find('.cancelSave'));
    });
}

function cancelSave(obj){
    if(obj.parents('#add-score-active').length){
        $('#add-score-active').replaceWith(addScoreRow);
    }else{
        var row = obj.parents('tr');
        var i = row.index() - 2;
        i = (rowsPerPage * (currentPage - 1)) + i;
        row.replaceWith(Mustache.render(scoreRow,scores[i]));
    }
}

function saveScore(obj){
    var row = obj.parents('tr');
    if(!validateScoreData(row)){
        return;
    }
    var scoreData = row.find('.score-input').serialize();
    $.post('/members-area/save-score',scoreData,function(response){
        if(response.length){
            errString = '';
            for(var i in response){
                errString += response[i] + "\r\n";
            }
            alert(errString);
            return;
        }
        fetchUserScores();
        refreshStats();
        notify("Your score has been saved.","Score Saved");
    },'json');
}

function validateScoreData(row){
    row.find('.score-input').each(function(){
        $(this).css('border','2px ridge #CCC');
    });
    var highlightBorder = function(obj){obj.css('border','2px solid red');};
    var courseName = row.find('input[name="courseName"]');
    var formattedDate = row.find('input[name="formattedDate"]');
    var score = row.find('input[name="score"]');
    var slope = row.find('input[name="slope"]');
    var rating = row.find('input[name="rating"]');
    var holesPlayed = row.find('input[name="holesPlayed"]');
    
    var errors = [];
    if(!courseName.val()){
        errors.push("Please enter a valid course name.");
        highlightBorder(courseName);
    }
    if(!formattedDate.val()){
        errors.push("Please enter a valid date.");
        highlightBorder(formattedDate);
    }
    if(!score.val()){
        errors.push("Please enter a valid score.");
        highlightBorder(score);
    }
    if(!slope.val()){
        errors.push("Please enter a valid slope.");
        highlightBorder(slope);
    }
    if(!rating.val()){
        errors.push("Please enter a valid rating.");
        highlightBorder(rating);
    }
    if(!holesPlayed.val()){
        errors.push("Please enter the number of holes played.");
        highlightBorder(holesPlayed);
    }
    if(holesPlayed.val() > 18 || holesPlayed.val() < 13){
        errors.push("Rounds must be between 13 and 18 holes to be eligible for handicap.");
        highlightBorder(holesPlayed);
    }
    if(errors.length){
        errString = '<ul class="score-errors">';
        for(var i in errors){
            errString += '<li>' + errors[i] + '</li>';
        }
        errString += '</ul>';
        notify(errString,"Error Saving Score:");
        return false;
    }
    return true;
}