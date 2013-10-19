<html>
    <head>
        <title>Password Reset Fixed</title>
    </head>
    <body>
        <div style="width: 600px;font-family: 'Arial','Helvetica',sans-serif">
            <img src="http://freehandicaptracker.net/img/e-mail-header.jpg" alt="FreeHandicapTracker.net" />
            <div style="margin: 10px 0px 10px 0px;">Dear <?= $this->user->getFirstName(); ?>,</div>
            <div>
                You are receiving this e-mail because you recently tried to reset the password for your account at <a href="http://www.freehandicaptracker.net">FreeHandicapTracker.net</a>
                <br /><br />
                When the new site was launched, the reset-password link contained in the automated reset-password email was still pointed at the beta site, which had recently been taken down. My apologies for this issue.
                <br /><br />
                The password-reset feature is now fixed, and you should be able to use the "Forgot Password" link on the site successfully now.
            </div>
            <div style="margin: 10px 0px 10px 0px;">Sincerely,</div>
            <div><a href="http://www.freehandicaptracker.net">FreeHandicapTracker.net</a> webmaster</div>
        </div>
    </body>
</html>