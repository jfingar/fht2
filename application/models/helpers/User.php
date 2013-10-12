<?php
namespace Models\Helpers;
use Models\User AS User_Model;
use Models\Mappers\User AS User_Mapper;
use Models\Mappers\Score AS Score_Mapper;
use Libraries\TinyPHP\Validate\EmailAddress AS EmailValidator;
class User
{
    public static function getHandicap(User_Model $user)
    {
        $handicap = 'N/A';
        $scoreMapper = new Score_Mapper();
        $resultSet = $scoreMapper->fetchAll("user_id = :user_id ORDER BY date DESC LIMIT 20", array(':user_id' => $user->getId()));
        if(!empty($resultSet)){
            $diffs = array();
            foreach($resultSet as $score){
                $diffs[] = $score->getDifferential();
            }
            sort($diffs);
            $diffsCount = count($diffs);
            $diffsUseCount = Utils::differentialsUsedMap($diffsCount);
            $usedDiffs = array_slice($diffs,0,$diffsUseCount);
            $handicap = round((array_sum($usedDiffs) / $diffsUseCount) * .96,1);
            if($handicap <= 0){
                $handicap = 'Scratch';
            }
        }
        return $handicap;
    }
    
    public static function getBestScore(User_Model $user)
    {
        $bestScore = 'N/A';
        $scoreMapper = new Score_Mapper();
        $score = $scoreMapper->fetchRow("user_id = :user_id ORDER BY score ASC", array(':user_id' => $user->getId()));
        if($score){
            $bestScore = $score->getScore();
        }
        return $bestScore;
    }
    
    public static function getAverageScore(User_Model $user)
    {
        $avg = 'N/A';
        $scoreMapper = new Score_Mapper();
        $resultSet = $scoreMapper->fetchAll("user_id = :user_id", array(':user_id' => $user->getId()));
        if(!empty($resultSet)){
            $sumScores = 0;
            foreach($resultSet as $score){
                $sumScores += $score->getScore();
            }
            $avg = round($sumScores / count($resultSet));
        }
        return $avg;
    }
    
    public static function getRoundsPlayedCount(User_Model $user)
    {
        $scoreMapper = new Score_Mapper();
        $resultSet = $scoreMapper->fetchAll("user_id = :user_id", array(':user_id' => $user->getId()));
        $roundsPlayed = count($resultSet);
        return $roundsPlayed;
    }
    
    public static function authenticate($email,$password)
    {
        try{
            $userMapper = new User_Mapper();
            $user = $userMapper->fetchRow("email = :email AND password = :password",array(':email' => $email,':password' => md5($password)));
        }catch(\Exception $e){
            throw $e;
        }
        return $user;
    }
    
    /*
    * Return an array of errors.
    * If the return array is empty, we can assume that the user object is valid.
    */
    public static function validate(User_Model $user)
    {
        $errors = array();
        $isUpdate = false;
        
        if($user->getId()){
           // user has an Id, this is an update
            $isUpdate = true;
        }
        
        if(!$user->getFirstName()){
            $errors[] = 'Please enter a valid First Name';
        }
        
        if(!$user->getLastName()){
            $errors[] = 'Please enter a valid Last Name';
        }
        
        $emailValidator = new EmailValidator();
        $emailValidator->setValidateMx(true);
        if(!$user->getEmail() || !$emailValidator->isValid($user->getEmail())){
            $errors[] = 'Please enter a valid Email Address';
        }
        
        if(!$isUpdate){
            if(!$user->getPassword()){
                $errors[] = 'Please enter a password into Password Field 1';
            }
            if(!$user->getPassword2()){
                $errors[] = 'Please enter a password into Password Field 2';
            }
        }
        
        if($user->getPassword() != $user->getPassword2()){
            $errors[] = 'Password Field 1 and Password Field 2 do not match.';
        }
        
        if(self::emailExists($user->getEmail(),$user->getId())){
            $errors[] = 'That Email Address already has an active account. Forgot Password?';
        }
                
        return $errors;
    }
    
    /*
     * Return boolean:
     * Does the e-mail already exist in the database?
     * (if this is an update, 2nd param will not be null. Use to ignore current user's email)
     */
    public static function emailExists($email,$userID)
    {
        $userMapper = new User_Mapper();
        $userWithExistingEmail = $userMapper->fetchRow("email = :email",array(':email' => $email));
        if($userWithExistingEmail){
            if(!$userID || ($userID && $userWithExistingEmail->getId() != $userID)){
                return true;
            }
        }
        return false;
    }
    
    public static function getLastTwentyScores(User_Model $user)
    {
        $lastTwentyScores = array();
        $userId = $user->getId();
        $scoreMapper = new Score_Mapper();
        $result = $scoreMapper->fetchAll("user_id = :user_id ORDER BY date DESC LIMIT 20",array(':user_id' => $userId));
        if(!empty($result)){
            foreach($result as $score){
               $lastTwentyScores[] = $score->getId(); 
            }
        }
        return $lastTwentyScores;
    }
    
    public static function getScoreIdsUsedInHandicap(User_Model $user)
    {
        $scoreIds = array();
        $scoreMapper = new Score_Mapper();
        $result = $scoreMapper->fetchAll("user_id = :user_id ORDER BY date DESC LIMIT 20",array(':user_id' => $user->getId()));
        $diffs = array();
        if(!empty($result)){
            foreach($result as $k => $score){
                $diffs[$k] = $score->getDifferential();
            }
            array_multisort($diffs,SORT_ASC,$result);
            $scoresCount = count($result);
            $scoresUsedCount = Utils::differentialsUsedMap($scoresCount);
            $usedScores = array_slice($result,0,$scoresUsedCount);
            foreach($usedScores as $score){
                $scoreIds[] = $score->getId();
            }
        }
        return $scoreIds;
    }
}