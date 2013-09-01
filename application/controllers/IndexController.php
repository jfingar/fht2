<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Helpers\Utils;
class IndexController extends ControllerBase
{
    protected function index()
    {
        if(isset($_SESSION['id'])){
            header("Location: members-area/view-scores");
        }
        $this->title = "Free Handicap Tracker - The Free and Easy Way to Track Your Golf Handicap Online!";
        $this->addJavascript('js/index.js');
    }

    protected function passwordResetEmail()
    {
        $this->isAjax = true;
        $email = $_POST['email'];
        Utils::sendPasswordResetEmail($email);
    }

    protected function passwordReset()
    {

    }
}