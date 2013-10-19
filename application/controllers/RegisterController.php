<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\User as User_Model;
use Models\Helpers\User as User_Helper;
use Models\Mappers\User as User_Mapper;
use \Exception;
class RegisterController extends ControllerBase
{
    
    protected function init()
    {
        if(isset($_SESSION['id'])){
            header("Location: members-area/view-scores");
        }
    }
    
    protected function index()
    {
        $this->title = "Free Handicap Tracker - Register For A Free Account";
        $this->addJavascript('js/register.min.js');
    }
    
    protected function doRegister()
    {
        $this->isAjax = true;
        $json = array('status' => false);
        $firstName = ucfirst(strtolower($_POST['firstName']));
        $lastName = ucfirst(strtolower($_POST['lastName']));
        $user = new User_Model();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($_POST['password1']);
        $user->setPassword2($_POST['password2']);
        $user->setSignupType('website');
        $user->setEmail($_POST['email']);

        $errors = User_Helper::validate($user);
        if(!$_POST['password1'] || !$_POST['password2']){
            $errors[] = "Please select a password and enter it into both password fields.";
        }

        if(!empty($errors)){
            $json['errors'] = $errors;
        }else{
            $userMapper = new User_Mapper();
            $userMapper->save($user);
            $json['status'] = true;
            $_SESSION['id'] = $user->getId();
        }
        echo json_encode($json);
    }
}