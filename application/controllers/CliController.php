<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\User AS User_Mapper;
use Libraries\TinyPHP\Validate\EmailAddress AS EmailValidator;
use Libraries\TinyPHP\Mail;

class CliController extends ControllerBase
{
    public function init()
    {
        $this->suppressLayout = true;
        $this->suppressView = true;
    }
    public function UpdatedSiteEmail()
    {
        // last mail sent to: marcv68@yahoo.com

        $userMapper = new User_Mapper();
        $allUsers = $userMapper->fetchAll("id = 1");
       //  $remainingUsers = array_slice($allUsers,???);
        foreach($allUsers as $user){
            $this->user = $user;
            $userEmailAddress = $user->getEmail();
            $emailValidator = new EmailValidator();
            $emailValidator->setValidateMx(true);
            if($emailValidator->isValid($userEmailAddress)){
                $emailContent = $this->returnView('emails/updated-site');
                $emailSubject = "FreeHandicapTracker.net new and improved site";
                $mail = new Mail();
                $mail->setSubject($emailSubject);
                $mail->setFrom("support@freehandicaptracker.net");
                $mail->addRecipient($userEmailAddress);
                $mail->setBody($emailContent);
                try{
                    $mail->send();
                }catch(Exception $e){
                    echo $e->getMessage();
                }
                echo "mail sent to: " . $userEmailAddress . "\r\n";
                sleep(5);
            }else{
                echo "invalid Email Address: " . $userEmailAddress . "\r\n";
            }
        }
    }
}