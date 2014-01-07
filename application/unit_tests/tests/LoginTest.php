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
        echo "Attempting to login with email " . $email . " and Password " . $password . "\r\n";
        $user = User_Helper::authenticate($email, $password);
        $this->assertInstanceOf('\Models\User',$user);
        if($user instanceof \Models\User){
            echo "Authenticated successfully\r\n";
        }
    }
    
    public function provider()
    {
        $data = array(
            array('jfingar@gmail.com','s2qq3c5g')
        );
        return $data;
    }
}
