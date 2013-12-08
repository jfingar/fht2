<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\Helpers\User AS User_Helper;
use Models\User AS User_Model;
use Models\Mappers\User AS User_Mapper;
class LoginTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     * @dataProvider provider
     */
    public function Login($email,$password1)
    {
        $errors = User_Helper::validate($user);
        $this->assertCount(0,$errors,print_r($errors,true));
        $userMapper = new User_Mapper();
        $userMapper->save($user);
        $loginCredentials = array('email' => $email,'password' => $password1);
        return $loginCredentials;
    }
    
    public function provider()
    {
        $numberOfTestRegistrants = 10;
        
        $pdo = Adapter::GetMysqlAdapter();
        
        $firstNameQuery = 'SELECT firstname FROM test_data.first ORDER BY RAND() LIMIT 1';
        $lastNameQuery = 'SELECT lastname FROM test_data.last ORDER BY RAND() LIMIT 1';
        $data = array();
        for($i = 1; $i <= $numberOfTestRegistrants; $i++){
            $statement = $pdo->query($firstNameQuery);
            $result = $statement->fetch();
            $firstName = $result['firstname'];
            
            $statement = $pdo->query($lastNameQuery);
            $result = $statement->fetch();
            $lastName = $result['lastname'];
            
            $emailDomains = array('gmail','aol','hotmail','yahoo');
            $email = substr($firstName,0,2) . $lastName . substr(time(),4,7) . '@' . $emailDomains[rand(0,3)] . '.com';
            
            $password1 = 'yolo';
            $password2 = 'yolo';
            
            
            $data[] = array(
                $firstName,
                $lastName,
                $email,
                $password1,
                $password2
            );
        }
        return $data;
    }
}
