<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\User as User_Model;
use Models\Helpers\User as User_Helper;
use Models\Mappers\User as User_Mapper;
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
        
        $user = new User_Model();
        $user->setFirstName($_POST['firstName']);
        $user->setLastName($_POST['lastName']);
        $user->setPassword($_POST['password1']);
        $user->setPassword2($_POST['password2']);
        $user->setSignupType('website');
        $user->setEmail($_POST['email']);
        
        $errors = User_Helper::validate($user);
        
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