<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\Mappers\Score AS Score_Mapper;
class DeleteScoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     */
    public function DeleteScore()
    {
    	// set user id from which to delete score
    	$userId = 1;
    	
    	// get random score to delete
    	$scoreMapper = new Score_Mapper();
    	$score = $scoreMapper->fetchRow("user_id = :userId ORDER BY RAND()",array(':userId' => $userId));
    	
    	if(!$score){
    		echo "User " . $userId . " has no scores to delete.";
    		return;
    	}
    	
    	$chosenScoreId = $score->getId();
    	
    	$scoreMapper->delete($score);
    	
    	$deletedScore = $scoreMapper->find($chosenScoreId);
    	$this->assertFalse($deletedScore,"Score was not deleted!!!");    	
    }
}
