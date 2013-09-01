<div style="padding-bottom: 15px;">
    <h3 style="float: left;">My Scores</h3>
    <div id="export-csv">Export Scores as Excel (CSV) File</div>
    <div id="key-container">
        <div class="key-box" id="most-recent"></div> <div class="key-box-label">Most Recent 20 Rounds</div>
        <div class="key-box" id="used-in-hcp"></div> <div class="key-box-label">Used in Handicap</div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<div id="scores-table-container">
</div>

<a id="delete-all">Delete All Scores</a>
<img class="pagination-arrows" id="arrow-right" src="/img/arrow_right.png" />
<img class="pagination-arrows" id="arrow-left" src="/img/arrow_left.png" />
<div class="clear"></div>
<div id="pagination"></div>
<div class="clear"></div>
<?= $this->returnView('/templates/members-area'); ?>