<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= $this->title; ?></title>
	<?= $this->getJavascripts(); ?>
	<?= $this->getStylesheets(); ?>
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
	</div>
    <div id="footer">
        Please <a href="mailto:jfingar@gmail.com">contact the website owner</a> with any questions or comments regarding usage of this site. Thank you for visiting!
    </div>
</body>
</html>