<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\User AS User_Model;
use Models\Mappers\User AS User_Mapper;
use Models\Mappers\Score AS Score_Mapper;
use Models\Helpers\User AS User_Helper;
class AddScoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     */
    public function GetScores()
    {
    	$userId = isset($argv[2]) ? $argv[2] : 1;
    	$userMapper = new User_Mapper();
    	$user = $userMapper->find($userId);
    	
    	$this->assertInstanceOf('Models\User',$user);
    	
    	$orderBy = 'date';
    	$dir = 'DESC';
    	
    	$scoreMapper = new Score_Mapper();
    	$collection = $scoreMapper->fetchAll("user_id = :user_id ORDER BY $orderBy $dir",array(':user_id' => $user->getId()));
    	$usedScoreIds = User_Helper::getScoreIdsUsedInHandicap($user);
    	$mostRecentTwentyScoreIds = User_Helper::getLastTwentyScores($user);
    	$scores = $scoreMapper->toArray($collection);
    	foreach($scores as &$row){
    		if(in_array($row['id'],$usedScoreIds)){
    			$row['usedInHcp'] = 'used';
    		}
    		if(in_array($row['id'],$mostRecentTwentyScoreIds)){
    			$row['lastTwenty'] = 'lastTwenty';
    		}
    		$row['formattedDate'] = date("m/d/Y",strtotime($row['date']));
    	}
    	// print_r($scores);
    }
}
