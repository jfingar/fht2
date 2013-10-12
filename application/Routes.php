<?php
/* add Route objects to the array as necessary.
*  format:
*  new Route($url,$controller,$func = "index")
*  Ommitting the $func argument will call the index() function in the controller
*/
use Libraries\TinyPHP\Route;
$aRoutes = array(
    new Route('index','IndexController'),
    new Route('register','RegisterController'),
    new Route('do-register','RegisterController','doRegister'),
    new Route('login','AuthController','login'),
    new Route('members-area','MembersAreaController','viewScores'),
    new Route('members-area/logout','AuthController','logout'),
    new Route('members-area/view-scores','MembersAreaController','viewScores'),
    new Route('members-area/save-score','MembersAreaController','saveScore'),
    new Route('members-area/get-scores','MembersAreaController','getScores'),
    new Route('members-area/delete-score','MembersAreaController','deleteScore'),
    new Route('members-area/scores-csv','MembersAreaController','getCSV'),
    new Route('members-area/get-stats','MembersAreaController','getStats'),
    new Route('members-area/delete-all-scores','MembersAreaController','deleteAllScores'),
    new Route('send-reset-pw-email','IndexController','passwordResetEmail'),
    new Route('pw-reset','IndexController','passwordReset'),
    new Route('save-new-password','IndexController','saveNewPassword'),
    new Route('members-area/my-account','MembersAreaController','myAccount'),
    new Route('members-area/delete-account','MembersAreaController','deleteAccount'),
    new Route('members-area/save-member-data','MembersAreaController','saveMemberData'),
    new Route('members-area/ad-trigger','MembersAreaController','adTrigger')
);