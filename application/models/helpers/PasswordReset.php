<?php
namespace Models\Helpers;
use Models\Mappers\PasswordReset AS PasswordReset_Mapper;
class PasswordReset
{
    /*
     * We only want to allow 1 valid pw reset record per-user at a time.
     * Return boolean
     */
    public static function ValidRecordExists($email)
    {
        $pwResetMapper = new PasswordReset_Mapper();
        $exp = time();
        $result = $pwResetMapper->fetchRow("email = :email AND expiration > :expiration",array(':email' => $email,':expiration' => $exp));
        if(!empty($result)){
            return true;
        }
        return false;
    }
}