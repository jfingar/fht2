<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\PasswordReset AS PasswordReset_Model;
use Models\Mappers\PasswordReset AS PasswordReset_Mapper;
use Models\Helpers\PasswordReset AS PasswordReset_Helper;
use Models\Mappers\User AS User_Mapper;
use Libraries\TinyPHP\Mail;
use Models\Helpers\User;
use \Exception;
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
        $errors = array();
        try{
            if(!$email){
                throw new Exception("Please enter your Email address.");
            }
            if(!User::emailExists($email, null)){
                throw new Exception("Email address not found. Please register for a new account.");
            }
            if(PasswordReset_Helper::ValidRecordExists($email)){
                throw new Exception("There is already a pending password reset for this account. Please double-check your Email inbox, and also check your spam folder. If you did not receive the Email, please contact us at support@freehandicaptracker.net");
            }
            $hash = PasswordReset_Helper::GenerateResetPasswordHash();

            $passwordResetMapper = new PasswordReset_Mapper();
            $passwordReset = new PasswordReset_Model();
            $passwordReset->setEmail($email);
            $passwordReset->setHash($hash);
            $passwordReset->setExpiration(time() + 3600);
            $passwordResetMapper->save($passwordReset);

            $this->email = $email;
            $this->hash = $hash;

            $emailContent = $this->returnView('emails/reset-password');
            $emailSubject = "FreeHandicapTracker.net Password Reset";

            $mail = new Mail();
            $mail->setSubject($emailSubject);
            $mail->setFrom("support@freehandicaptracker.net");
            $mail->addRecipient($email);
            $mail->setBody($emailContent);
            $mail->send();
        }catch(Exception $e){
            $errors[] = $e->getMessage();
        }
        echo json_encode($errors);
    }

    protected function passwordReset()
    {
        $this->title = "Free Handicap Tracker - Reset Your Password";
        $this->addJavascript('/js/pw-reset.js');
        $email = $_GET['email'];
        $hash = $_GET['hash'];
        if(!PasswordReset_Helper::Validate($email,$hash)){
           $this->invalidPwReset = true;
        }
    }
    
    protected function saveNewPassword()
    {
        $this->isAjax = true;
        $email = $_POST['email'];
        $hash = $_POST['hash'];
        $pw1 = $_POST['pw1'];
        $pw2 = $_POST['pw2'];
        
        $errors = array();
        try{
            if(!trim($pw1) || !trim($pw2)){
                throw new Exception("Please enter a new password in both fields.");
            }
            if($pw1 != $pw2){
                throw new Exception("Passwords do not match. Please type them in again.");
            }
            if(!PasswordReset_Helper::Validate($email,$hash)){
                throw new Exception("Invalid Email Address or Hash Value.");
            }
            $userMapper = new User_Mapper();
            $user = $userMapper->fetchRow("email = :email", array(":email" => $email));
            $user->setPassword($pw1);
            $userMapper->save($user);
            
            // delete password reset record
            $pwResetMapper = new PasswordReset_Mapper();
            $pwResetObjects = $pwResetMapper->fetchAll("email = :email",array(":email" => $email));
            foreach($pwResetObjects as $pwReset){
                $pwResetMapper->delete($pwReset);
            }
        }catch(Exception $e){
            $errors[] = $e->getMessage();
        }
        echo json_encode($errors);
    }
}