<?php
namespace Models;
class PasswordReset
{
    private $id;
    private $email;
    private $hash;
    private $expiration;
    
    public function setId($val)
    {
        $this->id = $val;
        return $this;
    }
	
    public function getId()
    {
        return $this->id;
    }

    public function setEmail($val)
    {
        $this->email = $val;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function setHash($val)
    {
        $this->hash = $val;
        return $this;
    }
    
    public function getHash()
    {
        return $this->hash;
    }
    
    public function setExpiration($val)
    {
        $this->expiration = $val;
        return $this;
    }
    
    public function getExpiration()
    {
        return $this->expiration;
    }
}