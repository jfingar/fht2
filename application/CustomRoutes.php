<?php
/* add Route objects to the array as necessary.
*  format:
*  new Route($url,$controller,$func = "index")
*  Ommitting the $func argument will call the index() function in the controller
*/
use Libraries\TinyPHP\Route;
$customRoutes = array(
    new Route('do-register','RegisterController','doRegister'),
    new Route('login','AuthController','login'),
    new Route('members-area','MembersAreaController','viewScores'),
    new Route('members-area/logout','AuthController','logout'),
    new Route('members-area/scores-csv','MembersAreaController','getCSV'),
    new Route('send-reset-pw-email','IndexController','passwordResetEmail'),
    new Route('pw-reset','IndexController','passwordReset'),
    new Route('save-new-password','IndexController','saveNewPassword'),
    new Route('android/get-user-scores','ServicesController','getUserScores'),
    new Route('android/get-user-data','ServicesController','getUserData'),
    new Route('android/register','ServicesController','register'),
    new Route('android/do-login','ServicesController','doLogin'),
    new Route('android/add-score','ServicesController','addScore'),
    new Route('android/edit-score','ServicesController','editScore'),
    new Route('android/delete-score','ServicesController','deleteScore'),
    new Route('members-area/autocomplete','MembersAreaController','autoComplete')
);