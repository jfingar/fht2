<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\Helpers\User AS User_Helper;
use Models\User AS User_Model;
use Models\Mappers\User AS User_Mapper;
class UserTest extends PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $firstName = 'Joe';
        $lastName = 'Schmoe';
        $email = 'jschmoee34h533@yahoo.com';
        $password1 = 'yolo';
        $password2 = 'yolo';
        
        $user = new User_Model();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($password1);
        $user->setPassword2($password2);
        $user->setSignupType('website');
        $user->setEmail($email);
        $user->setSignupDate(date("Y-m-d H:i:s"));

        $errors = User_Helper::validate($user);
        $this->assertCount(0,$errors,print_r($errors,true));
        $userMapper = new User_Mapper();
        $userMapper->save($user);
        $loginCredentials = array('email' => $email,'password' => $password1);
        return $loginCredentials;
    }
    
    /**
     * @depends testRegister
     */
    public function testLogin(array $loginCredentials)
    {
        $this->assertInstanceOf('Models\User',User_Helper::authenticate($loginCredentials['email'],$loginCredentials['password']));
    }
}
