<?php
namespace Models;
class User
{
    private $id;
    private $email;
    private $password;
    private $password2;
    private $firstName;
    private $lastName;
    private $signupType;
    	
    public function setId($val)
    {
        $this->id = $val;
        return $this;
    }
	
    public function getId()
    {
        return $this->id;
    }

    public function setEmail($var)
    {
        $this->email = $var;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function setPassword($var)
    {
        $var = md5($var);
        $this->password = $var;
        return $this;
    }
	
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword2($var)
    {
        $var = md5($var);
        $this->password2 = $var;
        return $this;
    }
	
    public function getPassword2()
    {
        return $this->password2;
    }
    
    public function setFirstName($var)
    {
        $this->firstName = $var;
        return $this;
    }
	
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function setLastName($var)
    {
        $this->lastName = $var;
        return $this;
    }
	
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function setSignupType($var)
    {
        $this->signupType = $var;
        return $this;
    }
	
    public function getSignupType()
    {
        return $this->signupType;
    }
}