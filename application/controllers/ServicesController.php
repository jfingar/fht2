<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\Score;
class ServicesController extends ControllerBase
{
    protected function init()
    {
        $this->isAjax = true;
    }
    
    protected function getUserScores()
    {
        $id = intval($_REQUEST['golferid']);
        $response = array();
        $scoreMapper = new Score();
        $resultSet = $scoreMapper->fetchAll("user_id = :userId ORDER BY date DESC", array(':userId' => $id));
        foreach($resultSet as $score){
            $response[] = array(
                'scoreid' => $score->getId(),
                'course' => $score->getCourseName(),
                'date' => date("Y-m-d",strtotime($score->getDate())),
                'score' => $score->getScore(),
                'slope' => $score->getSlope(),
                'rating' => $score->getRating()
            );
        }
        echo json_encode($response);
    }
}