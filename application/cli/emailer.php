<?php
use Libraries\TinyPHP\Application;
use Controllers\CliController;
chdir("../../webroot");
require_once "../application/libraries/TinyPHP/Application.php";
Application::run('cli',true);

new CliController('UpdatedSiteEmail');