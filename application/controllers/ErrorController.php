<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\User AS User_Mapper;
use Models\Helpers\User AS User_Helper;
class ErrorController extends ControllerBase
{
    protected function init()
    {
        header(' ',true,404);
        if(!isset($_SESSION['id'])){
            header("Location: index");
            exit();
        }else{
            $userMapper = new User_Mapper();
            $this->user = $userMapper->find($_SESSION['id']);
            $this->hcp = User_Helper::getHandicap($this->user);
            $this->addStylesheet('/css/members-area.css');
        }
    }

    protected function errorPage(){
        $this->addStylesheet('/css/members-area.css');
        $this->title = '404, Page Not Found!';
    }
}