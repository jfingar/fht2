<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\User AS User_Mapper;
use Libraries\TinyPHP\Validate\EmailAddress AS EmailValidator;
use Libraries\TinyPHP\Mail;
use \Exception;
class CliController extends ControllerBase
{
    public function init()
    {
        $this->suppressLayout = true;
        $this->suppressView = true;
    }
    public function UpdatedSiteEmail()
    {
        $userMapper = new User_Mapper();
        $allUsers = $userMapper->fetchAll();
        $remainingUsers = array_slice($allUsers,176);
        foreach($remainingUsers as $user){
            $this->user = $user;
            $userEmailAddress = $user->getEmail();
            $emailValidator = new EmailValidator();
            $emailValidator->setValidateMx(true);
            if($emailValidator->isValid($userEmailAddress)){
                $emailContent = $this->returnView('emails/updated-site');
                $emailSubject = "FreeHandicapTracker.net new and improved site";
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
            }else{
                echo "invalid Email Address: " . $userEmailAddress . "\r\n";
            }
        }
    }
}