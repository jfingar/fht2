<?php
namespace Models\Helpers;
use Libraries\TinyPHP\Application;
use Models\PasswordReset AS PasswordReset_Model;
use Models\Mappers\PasswordReset AS PasswordReset_Mapper;
class Utils
{
    private static $productionExceptionMsg = 'Oops! An error occurred behind the scenes. Please contact the website administrator for more information.';
    
    public static function errMsgHandler(\Exception $e)
    {
        return Application::$env == 'production' ? self::$productionExceptionMsg : $e->getMessage();
    }
    
    /*
     * Return the number of differentials used based on number of scores entered.
     */
    public static function differentialsUsedMap($scoresCount)
    {
        if(!is_int($scoresCount) || $scoresCount < 0){
            throw new \Exception("Provide # of scores as a positive integer to Utils::differentialsUsedMap method");
            return;
        }
        $key = $scoresCount > 20 ? 20 : $scoresCount;
        $usedDiffsMap = array(
            0 => 0,
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 2,
            8 => 2,
            9 => 3,
            10 => 3,
            11 => 4,
            12 => 4,
            13 => 5,
            14 => 5,
            15 => 6,
            16 => 6,
            17 => 7,
            18 => 8,
            19 => 9,
            20 => 10
        );
        return $usedDiffsMap[$key];
    }
    
    public static function sendPasswordResetEmail($email)
    {
        $x = substr(time(),5,4);
        $x .= substr(time(),8);
        $y = md5($x) . substr(time(),4,2);
        $hash = md5($y);
        $passwordResetMapper = new PasswordReset_Mapper();
        $passwordReset = new PasswordReset_Model();
        $passwordReset->setEmail($email);
        $passwordReset->setHash($hash);
        $passwordReset->setExpiration(time() + 3600);
        $passwordResetMapper->save($passwordReset);
        
        $emailContent = "Dear FreeHandicapTracker.net User,<br /><br />";
        $emailContent .= "Please click on the link below to reset your account password. This link will expire approximately 1 hour after reception of this e-mail. <br /><br />";
        $emailContent .= "<a href=\"http://www.freehandicaptracker.net/pw-reset?email=$email&hash=$hash\">http://www.freehandicaptracker.net/pw-reset?email=$email&hash=$hash</a><br /><br />";
        $emailContent .= "Thank you for your continued use of FreeHandicapTracker.net!";
        
        $emailSubject = "FreeHandicapTracker.net Password Reset";
        
        $message = \Swift_Message::newInstance($emailSubject);
        $message->setFrom("support@freehandicaptracker.net", "FreeHandicapTracker.net");
        $message->setTo($email,"Jason Fingar");
        $message->setBody($emailContent,'text/html');
        
        // Smtp
        $transport = \Swift_SmtpTransport::newInstance('smtpout.secureserver.net',25)
        ->setUsername("support@freehandicaptracker.net")
        ->setPassword("s2qq3c5g");
        $mailer = \Swift_Mailer::newInstance($transport);
        $result = $mailer->send($message);
        return $result;
    }
}
