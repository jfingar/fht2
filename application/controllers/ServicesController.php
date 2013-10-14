<?php
/*
 * Android Web Service Endpoints:
 * 
 *   http://freehandicaptracker.net/android/add-score
 *   http://freehandicaptracker.net/android/get-user-data
 *   http://freehandicaptracker.net/android/do-login
 *   http://freehandicaptracker.net/android/register
 *   http://freehandicaptracker.net/android/get-user-scores
 *   http://freehandicaptracker.net/android/edit-score
 *   http://freehandicaptracker.net/android/delete-score
 */
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\Score AS Score_Mapper;
use Models\Score AS Score_Model;
use Models\Helpers\Score AS Score_Helper;
use Models\Mappers\User AS User_Mapper;
use Models\User AS User_Model;
use Models\Helpers\User AS User_Helper;
use \Exception;
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
        $scoreMapper = new Score_Mapper();
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
    
    protected function getUserData()
    {
        $id = intval($_REQUEST['golferid']);
        $response = array();
        
        $userMapper = new User_Mapper();
        $user = $userMapper->find($id);
        
        if($user){
            $response['handicap'] = User_Helper::getHandicap($user);
            $response['firstname'] = $user->getFirstName();
            $response['scoresCount'] = User_Helper::getRoundsPlayedCount($user);
            $response['avgScore'] = User_Helper::getAverageScore($user);
            $response['bestScore'] = User_Helper::getBestScore($user);
        }
        echo json_encode($response);
    }
    
    protected function register()
    {
        $response = array();
        
        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        $email = $_REQUEST['email'];
        $pw1 = $_REQUEST['pw1'];
        $pw2 = $_REQUEST['pw2'];
        
        $user = new User_Model();
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setEmail($email);
        $user->setPassword($pw1);
        $user->setPassword2($pw2);
        $user->setSignupType('app');
        
        $errors = User_Helper::validate($user);
        if(empty($errors)){
            $userMapper = new User_Mapper();
            $userMapper->save($user);
            $response['golferID'] = $user->getId();
        }else{
            $response['errors'] = $errors;
        }
        
        echo json_encode($response);
    }
    
    protected function doLogin()
    {
        $email = $_REQUEST['email'];
        $pw = $_REQUEST['pw'];
        $response = array(
            'loginStatus' => false
        );
        
        $user = User_Helper::authenticate($email, $pw);
        if($user){
            $response['loginStatus'] = true;
            $response['golferid'] = $user->getId();
        }
                
        echo json_encode($response);
    }
    
    protected function addScore()
    {
        $response = array(
            'addScoreStatus' => false
        );
        $id = $_REQUEST['golferid'];
        $course = $_REQUEST['course'];
        $date = $_REQUEST['date'] ? date("Y-m-d",strtotime($_REQUEST['date'])) : null;
        $strokes = $_REQUEST['score'];
        $rating = $_REQUEST['rating'];
        $slope = $_REQUEST['slope'];
        
        $score = new Score_Model();
        $score->setUserId($id);
        $score->setCourseName($course);
        $score->setRating($rating);
        $score->setSlope($slope);
        $score->setDate($date);
        $score->setScore($strokes);
        $score->setHolesPlayed(18);
        
        if($score->getRating() && $score->getScore() && $score->getSlope()){
            Score_Helper::calculateDifferential($score);
            $score->setDifferential($score->getDifferential());
        }
        
        $errors = Score_Helper::validate($score);
        if(!empty($errors)){
            foreach($errors as $err){
                $response[] = $err;
            }
        }else{
            $scoreMapper = new Score_Mapper();
            try{
                $scoreMapper->save($score);
                $response['addScoreStatus'] = true;
            }catch(Exception $e){
                $response[] = $e->getMessage();
            }
        }
        echo json_encode($response);
    }
    
    protected function editScore()
    {
        $response = array(
            'status' => false
        );
        
        $id = $_REQUEST['golferid'];
        $scoreid = $_REQUEST['scoreid'];
        $course = $_REQUEST['course'];
        $date = $_REQUEST['date'] ? date("Y-m-d",strtotime($_REQUEST['date'])) : null;
        $strokes = $_REQUEST['score'];
        $rating = $_REQUEST['rating'];
        $slope = $_REQUEST['slope'];
        
        $scoreMapper = new Score_Mapper();
        $score = $scoreMapper->find($scoreid);
        if($score){
            $score->setCourseName($course);
            $score->setDate($date);
            $score->setScore($strokes);
            $score->setRating($rating);
            $score->setSlope($slope);
            if($score->getUserId() == $id){
                $errors = Score_Helper::validate($score);
                if(!empty($errors)){
                    $response['errors'] = $errors;
                }else{
                    $scoreMapper->save($score);
                    $response['status'] = true;
                }
            }
        }
        echo json_encode($response);
    }
    
    protected function deleteScore()
    {
        $golferid = $_REQUEST['golferid'];
        $scoreid = $_REQUEST['scoreid'];
        $scoreMapper = new Score_Mapper();
        $userMapper = new User_Mapper();
        $user = $userMapper->find($golferid);
        $score = $scoreMapper->find($scoreid);
        if($user->getId() == $score->getUserId()){
            $scoreMapper->delete($score);
        }
    }
}