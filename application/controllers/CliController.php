<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\PasswordReset;
use Models\Mappers\User;
use Libraries\TinyPHP\Mail;
use \Exception;
class CliController extends ControllerBase
{
    public function init()
    {
        $this->suppressLayout = true;
        $this->suppressView = true;
    }
    public function PwResetMessupEmail()
    {
        $pwResetMapper = new PasswordReset();
        $rows = $pwResetMapper->fetchAll();
        $userMapper = new User();
        foreach($rows as $row){
            $this->user = $userMapper->fetchRow("email = ?",array($row));
            $userEmailAddress = $this->user->getEmail();
            $emailContent = $this->returnView('emails/pw-reset-messup');
            $emailSubject = "FreeHandicapTracker.net password reset fixed";
            $mail = new Mail();
            $mail->setSubject($emailSubject);
            $mail->setFrom("support@freehandicaptracker.net","FreeHandicapTracker");
            $mail->addRecipient($userEmailAddress);
            $mail->setBody($emailContent);
            try{
                $mail->send();
                echo "mail sent to: " . $userEmailAddress . "\r\n";
            }catch(Exception $e){
                echo $e->getMessage();
            }
            sleep(5);
        }
    }
}