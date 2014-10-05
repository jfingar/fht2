<div class="members-area-top">
    <h1 class="members-area-heading">
        Add New &amp; View Existing Scores
    </h1>
    <div id="key-container">
        <div class="key-box" id="most-recent"></div> <div class="key-box-label">Most Recent 20 Rounds</div>
        <div class="key-box" id="used-in-hcp"></div> <div class="key-box-label">Used in Handicap</div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<div id="long-ad">
    <script type="text/javascript"><!--
        google_ad_client = "ca-pub-0606881367275935";
        /* long-ad */
        google_ad_slot = "5764990759";
        google_ad_width = 970;
        google_ad_height = 90;
        //-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>

<div id="fade-in-container">
    <div id="scores-table-container">
    </div>

    <a id="delete-all" class="groove-border-btn">Delete All Scores</a>
    <div id="export-csv" class="groove-border-btn">Export Scores as Excel (CSV) File</div>
    <img class="pagination-arrows" id="arrow-right" src="/img/arrow_right.png" />
    <img class="pagination-arrows" id="arrow-left" src="/img/arrow_left.png" />
    <div class="clear"></div>
    <a id="get-alternate-user-hcp">Alternate User Handicap Lookup</a>
    <div id="pagination"></div>
    <div class="clear"></div>
</div>
<?= $this->returnView('/templates/members-area'); ?>