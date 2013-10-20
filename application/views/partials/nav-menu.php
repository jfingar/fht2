<? if(isset($_SESSION['id'])) : ?>
    <div id="nav-menu">
        <a href="view-scores">My Scores</a>
        <a href="my-account">My Account</a>
        <div class="stat-label"><img class="tooltip" id="hcp-info" src="/img/information.png" alt="" /> Current Handicap:</div>
        <div id="hcp" class="stat-container"></div>
        <div class="stat-label">Best Score:</div>
        <div id="best" class="stat-container"></div>
        <div class="stat-label">Average Score:</div>
        <div id="avg" class="stat-container"></div>
        <div class="stat-label">Rounds:</div>
        <div id="rounds" class="stat-container"></div>
        <a href="/members-area/logout" id="logout">Logout</a>
        <div class="clear"></div>
    </div>
    <div id="spacer-div-under-nav"></div>
<? endif; ?>
