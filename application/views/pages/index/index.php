<div class="form-wrapper-container">
    <form class="standardForm" id="loginForm" action="login" method="post">
        <div class="form-heading">Login</div>
        <div>
            <label>Email Address</label>
            <input name="email" id="email" type="text" class="text-input-1" />
        </div>
        <div>
            <label>Password</label>
            <input name="password" id="password" type="password" class="text-input-1" />
        </div>
        <div id="loginSubmitContainer" class="submitContainer">
            <input type="submit" value="Login" class="submit-input-1" />
        </div>
        <div class="ajaxResponseContainer hidden">
        </div>
        <ul class="form-opts">
            <li><a href="register">Register for an account</a></li>
            <li><a id="fgt-pswd">Help! I forgot my password!</a></li>
        </ul>
    </form>
</div>
<div id="homepage-right">
    <h1>Free Handicap Tracker makes it easy to keep track of your golf handicap. If you are not yet a member, <a href="register">Register For A Free Account</a>. If you are a member, log in anytime to enter your golf scores!</h1>
    <div id="androidAnnounce">
        <a id="androidImageLink" href="http://play.google.com/store/apps/details?id=net.freehandicaptracker.app">
            <img src="img/android.png" alt="Handicap Tracker App For Android" />
        </a>
        <div id="androidAnnounceText">
            Check out the Handicap Tracker App for your Android phone or device! The app uses your FreeHandicapTracker.net account information to keep your handicap and scores up-to-date on both the app and the website. This is a <strong><a href="http://play.google.com/store/apps/details?id=net.freehandicaptracker.app">FREE DOWNLOAD</a></strong> from the Google Play app store for a limited time only!
        </div>
        <a id="androidDownloadBadge" href="http://play.google.com/store/apps/details?id=net.freehandicaptracker.app">
          <img alt="Get it on Google Play" src="http://www.android.com/images/brand/get_it_on_play_logo_small.png" />
        </a>
        <div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
<hr />
<div id="golf-headlines-container">
    <h3>PGA Tour News and Updates</h3>
    <div id="golf-channel-rss">
        <img src="img/loader.gif" alt="Loading..." />
    </div>
</div>
<div id="twitter-feed">
	<a class="twitter-timeline"  href="https://twitter.com/jason0781/pga-tour-players" data-widget-id="254962210307182593">Tweets from @jason0781/pga-tour-players</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
<div class="clear"></div>
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
<div id="fgt-pswd-modal">
    <p class="fgt-pwd-directions">Please enter your Email address, and we will send you a link to reset your password.</p>
    <form id="fgt-pswd-form">
        <div class="fgt-pwd-input-container">
            <label for="fgt-pswd-email">Email:</label> <input type="text" name="email" id="fgt-pswd-email" />
        </div>
        <div>
            <input id="fgt-pwd-submit" type="submit" value="Send" />
        </div>
    </form>
</div>