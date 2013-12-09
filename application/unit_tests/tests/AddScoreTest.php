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
        $numberOfScoresToEnter = 5;
        
        $data = array();
        
        $golfCourseNames = array('Superstition Springs','Augusta','Apache Creek','Desert Canyon','Eagle Mountain','Troon North','Dove Valley','Medinah','Longbow');
        for($i = 1; $i <= $numberOfScoresToEnter; $i++){
            $score = new Score_Model();
            $score->setCourseName($golfCourseNames[rand(0,8)]);
            $score->setDate(date("Y-m-d"));
            $score->setHolesPlayed(18);
            $score->setRating(71.6);
            $score->setSlope(118);
            $score->setUserId(1);
            $score->setTees('Black');
            $score->setScore(rand(75,110));
            try{
                Score_Helper::calculateDifferential($score);
            }catch(\Exception $e){
                
            }
            $data[] = array($score);
        }
        return $data;
    }
}
