<?php
namespace Models\Mappers;
use Libraries\TinyPHP\Db\MapperBase;
class PasswordReset extends MapperBase
{
    protected $table_name = 'password_reset';
    protected $model_name = '\Models\PasswordReset';
    
    protected function setProperties($obj,$row)
    {
        $obj->setId($row['id'])
            ->setEmail($row['email'])
            ->setPassword($row['hash'])
            ->setFirstName($row['expiration']);
    }
    
   protected function getProperties($obj)
   {
       return array(
           'id' => $obj->getId(),
           'email' => $obj->getEmail(),
           'hash' => $obj->getHash(),
           'expiration' => $obj->getExpiration()
       );
   }
}