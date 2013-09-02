<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Helpers\Utils;
use Models\Helpers\User as User_Helper;
class AuthController extends ControllerBase
{
    protected function init()
    {
        $this->isAjax = true;
    }
    
    protected function login()
    {
        $json = array('status' => false);
        $email = $_POST['email'];
        $password = $_POST['password'];
        try{
            $user = User_Helper::authenticate($email, $password);
            if($user){
                $_SESSION['id'] = $user->getId();
                $json['status'] = true;
            }else{
                $json['errors'][] = 'Incorrect Email Address or Password.';
            }
        }catch(\Exception $e){
            $json['errors'][] = Utils::errMsgHandler($e);
        }
        echo json_encode($json);
    }
    
    protected function logout()
    {
        unset($_SESSION['id']);
        header("Location: /index");
    }
}