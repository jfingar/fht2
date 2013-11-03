<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\User as User_Mappper;
use Models\Helpers\User as User_Helper;
class CliController extends ControllerBase
{
    public function Test()
    {
        $userMapper = new User_Mappper();
        $user = $userMapper->find(1);
        User_Helper::GetMonthlyHandicapData($user);
    }
}