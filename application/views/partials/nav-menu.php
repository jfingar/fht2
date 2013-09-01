<? if(isset($_SESSION['id'])) : ?>
    <div id="nav-menu">
        <a href="view-scores">My Scores</a>
        <a href="my-account">My Account</a>
        <div id="handicap">Current Handicap:</div>
        <div id="hcp"><?= $this->hcp; ?></div>
        <a href="/members-area/logout" id="logout">Logout</a>
        <div class="clear"></div>
    </div>
    <div id="spacer-div-under-nav"></div>
<? endif; ?>
