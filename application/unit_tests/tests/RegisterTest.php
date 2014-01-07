<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\Helpers\User AS User_Helper;
use Models\User AS User_Model;
use Models\Mappers\User AS User_Mapper;
use Libraries\TinyPHP\Db\Adapter;

class RegisterTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     * @dataProvider provider
     */
    public function Register($firstName,$lastName,$email,$password1,$password2)
    {
        $signupDate = date("Y-m-d H:i:s");
        echo "Attempting to register a new user with the following data:\r\n";
        echo "$firstName | $lastName | $email | $password1  | $password2 | website |  $signupDate \r\n";
        
        $user = new User_Model();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($password1);
        $user->setPassword2($password2);
        $user->setSignupType('website');
        $user->setEmail($email);
        $user->setSignupDate($signupDate);
        
        $errors = User_Helper::validate($user);
        $this->assertCount(0,$errors,print_r($errors,true));
        if(!count($errors)){
            echo "No validation errors found\r\n";
        }
        $userMapper = new User_Mapper();
        $userMapper->save($user);
        echo "User registered successfully\r\n\r\n";
    }
    
    public function provider()
    {
        $numberOfTestRegistrants = 1;
        
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
            $email = substr($firstName,0,2) . $lastName . rand(1,9999) . '@' . $emailDomains[rand(0,3)] . '.com';
            
            $password1 = function(){
                $str = '';
                $availableChars = 'abcdefghijklmnopqrstuvwxyz&#$@1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                for($i = 0; $i <= rand(4,10); $i++){
                    $str .= $availableChars[rand(0,75)];
                }
                return $str;
            };
            $password2 = $password1;
            
            
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
