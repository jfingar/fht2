<?php
namespace Models\Mappers;
use Libraries\TinyPHP\Db\MapperBase;
class User extends MapperBase
{
    protected $table_name = 'users';
    protected $model_name = '\Models\User';
    
    protected function setProperties($obj,$row)
    {
        $obj->setId($row['id'])
            ->setEmail($row['email'])
            ->setPassword($row['password'])
            ->setFirstName($row['firstName'])
            ->setLastName($row['lastName'])
            ->setSignupType($row['signupType'])
            ->setSignupDate($row['signupDate']);
    }
    
   protected function getProperties($obj)
   {
       return array(
           'id' => $obj->getId(),
           'email' => $obj->getEmail(),
           'password' => $obj->getPassword(),
           'firstName' => $obj->getFirstName(),
           'lastName' => $obj->getLastName(),
           'signupType' => $obj->getSignupType(),
           'signupDate' => $obj->getSignupDate()
       );
   }
}