<script type="text/template" id="scores-table-template">
    <table id="scores-table">
    </table>
</script>

<script type="text/template" id="scores-table-headings-template">
    <tr class="scores-table-headings">
        <th class="sortable" id="courseName">Course Name <img class="sortArrows" src="/img/sort_neutral_green.png" /></th>
        <th class="sortable" id="date">Date Played <img class="sortArrows" src="/img/sort_down_green.png" /></th>
        <th class="sortable" id="score">Score <img class="sortArrows" src="/img/sort_neutral_green.png" /></th>
        <th class="sortable" id="slope">Slope <img class="sortArrows" src="/img/sort_neutral_green.png" /></th>
        <th class="sortable" id="rating">Rating <img class="sortArrows" src="/img/sort_neutral_green.png" /></th>
        <th class="sortable" id="differential"><img class="tooltip" src="/img/information.png" alt="" /> Differential <img class="sortArrows" src="/img/sort_neutral_green.png" /></th>
        <th class="sortable" id="holesPlayed">Holes Played <img src="/img/sort_neutral_green.png" /></th>
        <th class="sortable" id="tees">Tees <img class="sortArrows" src="/img/sort_neutral_green.png" /></th>
        <th colspan="2" style="width: 58px;">&nbsp;</th>
    </tr>
</script>

<script type="text/template" id="differential-tooltip-content-wrapper">
    <div id="differential-tooltip-content" style="font-size: 16px; line-height: 22px;">
        <div style="margin-bottom: 10px;">Differentials are used to calculate your handicap index. They are a measure of how well you played based on your score relative to par, as well as the difficulty of the course (slope &amp; rating)</div>
        <div style="margin-bottom: 10px;">Your handicap differential is calculated using the following formula:</div>
        <div style="font-weight: bold;">((score - rating) * 113) / slope</div>
    </div>
</script>

<script type="text/template" id="add-score-template">
    <tr class="add-score">
        <td colspan="8"><a id="add-score-link">Add A New Score</a></td>
        <td colspan="2"><img class="row-icon add" src="/img/add.png" alt="Add a new score" /></td>
    </tr>
</script>

<script type="text/template" id="score-template">
    <tr class="score {{usedInHcp}} {{lastTwenty}}">
        <td>{{courseName}}</td>
        <td>{{formattedDate}}</td>
        <td>
            <div class="score-box">{{score}}</div>
            <input name="id" type="hidden" class="score-input" value="{{id}}" />
        </td>
        <td>{{slope}}</td>
        <td>{{rating}}</td>
        <td>{{differential}}</td>
        <td>{{holesPlayed}}</td>
        <td>{{tees}}</td>
        <td class="td-center"><img class="row-icon edit" src="/img/edit.png" title="Edit" /></td>
        <td class="td-center"><img class="row-icon delete" src="/img/x.png" title="Delete" /></td>
    </tr>
</script>

<script type="text/template" id="edit-score-template">
    <tr class="edit-score">
        <td><input name="courseName" type="text" class="score-input courseName" value="{{courseName}}" /></td>
        <td><input name="formattedDate" type="text" class="score-input formattedDate" value="{{formattedDate}}" /></td>
        <td>
            <input name="score" type="text" class="score-input" value="{{score}}" />
            <input name="id" type="hidden" class="score-input" value="{{id}}" />
        </td>
        <td><input name="slope" type="text" class="score-input" value="{{slope}}" /></td>
        <td><input name="rating" type="text" class="score-input" value="{{rating}}" /></td>
        <td>{{differential}}</td>
        <td><input name="holesPlayed" type="text" class="score-input" value="{{holesPlayed}}" /></td>
        <td><input name="tees" type="text" class="score-input" value="{{tees}}" /></td>
        <td class="td-center"><img class="row-icon save" src="/img/save.png" title="Save Score" /></td>
        <td class="td-center"><img class="row-icon cancelSave" src="/img/cancel_save.png" title="Cancel" /></td>
    </tr>
</script>

<script type="text/template" id="add-score-active-template">
    <tr id="add-score-active">
        <td><input name="courseName" type="text" class="score-input courseName" /></td>
        <td><input name="formattedDate" type="text" class="score-input formattedDate" /></td>
        <td><input name="score" type="text" class="score-input" /></td>
        <td><input name="slope" type="text" class="score-input" /></td>
        <td><input name="rating" type="text" class="score-input" /></td>
        <td>&nbsp;</td>
        <td><input name="holesPlayed" type="text" class="score-input" /></td>
        <td><input name="tees" type="text" class="score-input" /></td>
        <td class="td-center"><img class="row-icon save" src="/img/save.png" title="Save Score" /></td>
        <td class="td-center"><img class="row-icon cancelSave" src="/img/cancel_save.png" title="Cancel" /></td>
    </tr>
</script>