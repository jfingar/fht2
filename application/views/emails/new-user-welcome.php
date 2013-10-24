<html>
    <head>
        <title>Welcome new FreeHandicapTracker.net user!</title>
    </head>
    <body>
        <div style="width: 600px;font-family: 'Arial','Helvetica',sans-serif">
            <img src="http://freehandicaptracker.net/img/e-mail-header.jpg" alt="FreeHandicapTracker.net" />
            <div style="margin: 10px 0px 10px 0px;">Dear <?= $this->user->getFirstName(); ?>,</div>
            <div>
                Thank you for creating an account at <a href="http://www.freehandicaptracker.net">FreeHandicapTracker.net</a>!
            </div>
            <div style="margin: 10px 0px 10px 0px;">
                If you signed up through the <a href="https://play.google.com/store/apps/details?id=net.freehandicaptracker.app">Android Application</a>, thank you! Don't forget to also checkout the web site - it has a lot more useful features and information regarding your handicap and scores.
            </div>
            <div style="margin: 10px 0px 10px 0px;">Sincerely,</div>
            <div><a href="http://www.freehandicaptracker.net">FreeHandicapTracker.net</a> webmaster</div>
        </div>
    </body>
</html>