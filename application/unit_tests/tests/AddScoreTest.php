<?php
namespace Tests;
use PHPUnit_Framework_TestCase;
use Models\Score AS Score_Model;
use Models\Mappers\Score AS Score_Mapper;
use Models\Helpers\Score AS Score_Helper;
class AddScoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     * @dataProvider provider
     */
    public function AddScore(Score_Model $score)
    {
        $errors = Score_Helper::validate($score);
        $this->assertEmpty($errors,"Errors in score validation found: " . print_r($errors,true));
        
        $scoreMapper = new Score_Mapper();
        $scoreMapper->save($score);
        $this->assertGreaterThan(0,$score->getId(),"Score passed validation but did not save correctly.");
    }
    
    public function provider()
    {
        global $argv;
        $numberOfScoresToEnter = isset($argv[2]) ? $argv[2] : 5;
        
        $data = array();
        
        $golfCourseNames = array('Superstition Springs','Augusta','Apache Creek','Desert Canyon','Eagle Mountain','Troon North','Dove Valley','Medinah','Longbow');
        for($i = 1; $i <= $numberOfScoresToEnter; $i++){
            $score = new Score_Model();
            $score->setCourseName($golfCourseNames[rand(0,8)]);
            $randomDate = date("Y-m-d H:i:s",mt_rand(strtotime("-5 years"),time()));
            $score->setDate($randomDate);
            $score->setHolesPlayed(18);
            
            $rating = floatval(rand(67,73) . '.' . rand(0,9));
            $score->setRating($rating);
            $slope = round($rating * floatval('1.' . rand(65,90)),1);
            $score->setSlope($slope);
            $score->setUserId(1);
            $score->setScore(rand(75,105));
            try{
                Score_Helper::calculateDifferential($score);
            }catch(\Exception $e){
                
            }
            $data[] = array($score);
        }
        return $data;
    }
}
