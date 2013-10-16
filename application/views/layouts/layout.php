<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= $this->title; ?></title>
	<?= $this->getJavascripts(); ?>
	<?= $this->getStylesheets(); ?>
        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript" src="http://s.sharethis.com/loader.js"></script>
</head>
<body>
    <div id="notification"></div>
    <div id="banner">
        <img id="banner-logo" src="/img/bannerlogo.png" alt="Free Handicap Tracker" />
        <img id="putting-green" src="/img/putting-green.png" alt="Golf Handicap Calculator" />
        <h2 id="slogan">
            The Free &amp; Easy Way To Track Your Golf Handicap Online!
        </h2>
    </div>
	<div id="container">
            <?= $this->returnView('partials/nav-menu'); ?>
            <?= $this->content; ?>
            <div class="clear"></div>
	</div>
    <div id="footer">
        Please <a href="mailto:support@freehandicaptracker.net">contact the website owner</a> with any questions or comments regarding usage of this site. Thank you for visiting!
    </div>
    <script type="text/javascript">stLight.options({publisher: "cecdced8-07c2-4546-8e59-20306ef31079", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    <script>
    var options={ "publisher": "cecdced8-07c2-4546-8e59-20306ef31079", "position": "left", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ["facebook", "twitter", "googleplus"]}};
    var st_hover_widget = new sharethis.widgets.hoverbuttons(options);
    </script>
</body>
</html>