<?php
use Libraries\TinyPHP\Application;
use Controllers\CliController;
require_once "../libraries/TinyPHP/Application.php";
chdir("../../webroot");
Application::run('development',true);