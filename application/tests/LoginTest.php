<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\Helpers\User AS User_Helper;
class LoginTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     * @dataProvider provider
     */
    public function Login($email,$password)
    {
        $user = User_Helper::authenticate($email, $password);
        $this->assertInstanceOf('\Models\User',$user);
    }
    
    public function provider()
    {
        $data = array(
            array('jfingar@gmail.com','s2qq3c5g')
        );
        return $data;
    }
}
