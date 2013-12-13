<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Models\Mappers\User AS User_Mapper;
use Models\Helpers\User AS User_Helper;
use Models\Score AS Score_Model;
use Models\Mappers\Score AS Score_Mapper;
use Models\Helpers\Score AS Score_Helper;
use Models\Helpers\Utils;
use \Exception;
class MembersAreaController extends ControllerBase
{
    protected function init()
    {
        if(!isset($_SESSION['id'])){
            header("Location: /index");
            return;
        }
        $userMapper = new User_Mapper();
        $this->user = $userMapper->find($_SESSION['id']);
        if(!$this->user){
            die("User Not Found! You need to reset your session or just click <a href=\"/members-area/logout\">Here</a> to Logout.");
        }
        $this->addStylesheet('/css/members-area.css');
        if(!isset($_SESSION['showIntro'])){
            $_SESSION['showIntro'] = true;
        }
    }

    protected function index()
    {
        $this->view = '/pages/members-area/view-scores';
        $this->viewScores();
    }
    
    protected function viewScores()
    {
        $this->title = "Free Handicap Tracker - The Free and Easy Way to Track Your Golf Handicap Online!";
        $this->addJavascript('/js/mustache.min.js');
        $this->addJavascript('/js/view-scores.min.js');
    }
    
    protected function myAccount()
    {
        $this->title = "Free Handicap Tracker - Account Settings";
        $this->addJavascript('/js/jqPlot/jquery.jqplot.min.js');
        $this->addJavascript('/js/my-account.min.js');
        $this->addJavascript('/js/jqPlot/plugins/jqplot.dateAxisRenderer.min.js');
        $this->addJavascript('/js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js');
        $this->addJavascript('/js/jqPlot/plugins/jqplot.pointLabels.js');
        $this->addStylesheet('/css/jqPlot/jquery.jqplot.min.css');
    }
    
    protected function adTrigger()
    {
        $this->isAjax = true;
        $response = array();
        if($_SESSION['showIntro']){
            $_SESSION['showIntro'] = false;
            $response['showAd'] = true;
        }
        echo json_encode($response);
    }
    
    protected function saveScore()
    {
        $this->isAjax = true;        
        $scoreMapper = new Score_Mapper();
        if(isset($_POST['id'])){
            $score = $scoreMapper->find($_POST['id']);
        }else{
            $score = new Score_Model();
            $score->setUserId($this->user->getId());
        }
        
        $date = $_POST['formattedDate'] ? date("Y-m-d 00:00:00",strtotime($_POST['formattedDate'])) : null;
        $score->setCourseName($_POST['courseName']);
        $score->setDate($date);
        $score->setHolesPlayed($_POST['holesPlayed']);
        $score->setScore($_POST['score']);
        $score->setRating($_POST['rating']);
        $score->setSlope($_POST['slope']);
        $score->setTees($_POST['tees']);
        
        $errors = Score_Helper::validate($score);
        
        if(empty($errors)){
            try{
                Score_Helper::calculateDifferential($score);
                if($score->getUserId() == $this->user->getId()){
                    $scoreMapper->save($score);
                }
            }catch(Exception $e){
                $errors = Utils::errMsgHandler($e);
            }
        }
        echo json_encode($errors);
    }
    
    protected function getScores()
    {
        $this->isAjax = true;
        $orderBy = $_GET['sortField'];
        $dir = $_GET['sortDir'];
        
        $scoreMapper = new Score_Mapper();
        $collection = $scoreMapper->fetchAll("user_id = :user_id ORDER BY $orderBy $dir",array(':user_id' => $this->user->getId()));
        $usedScoreIds = User_Helper::getScoreIdsUsedInHandicap($this->user);
        $mostRecentTwentyScoreIds = User_Helper::getLastTwentyScores($this->user);
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
        echo json_encode($scores);
    }
    
    protected function deleteScore()
    {
        $this->isAjax = true;
        $scoreMapper = new Score_Mapper();
        $score = $scoreMapper->find($_POST['id']);
        if($score && $score->getUserId() == $this->user->getId()){
            $scoreMapper->delete($score);
        }
    }
    
    protected function deleteAllScores()
    {
        $this->isAjax = true;
        $scoreMapper = new Score_Mapper();
        $userId = $this->user->getId();
        try{
            $scoreMapper->delete(null,"user_id = $userId");
        }catch(Exception $e){
            echo Utils::errMsgHandler($e);
        }
    }
    
    protected function deleteAccount()
    {
        $userMapper = new User_Mapper();
        $userMapper->delete($this->user);
        session_unset();
    }
    
    protected function saveMemberData()
    {
        $this->isAjax = true;
        $userMapper = new User_Mapper;
        $firstName = ucfirst(strtolower($_POST['firstName']));
        $lastName = ucfirst(strtolower($_POST['lastName']));
        $user = $userMapper->find($this->user->getId());
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($_POST['email']);
        
        $updatePW = false;
        if(trim($_POST['pw1']) || trim($_POST['pw2'])){
            $updatePW = true;
            $user->setPassword($_POST['pw1']);
            $user->setPassword2($_POST['pw2']);
        }

        $errors = User_Helper::validate($user,$updatePW);
        if(empty($errors)){
            try{
                User_Helper::updateAccountInfo($user,$updatePW);
            }catch(Exception $e){
                $errors[] = Utils::errMsgHandler($e);
            }
        }
        echo json_encode($errors);
    }
    
    protected function getCsv()
    {
        $this->suppressLayout = true;
        $this->view = 'partials/scores-csv';
        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=Scores.csv');
        $orderBy = $_GET['orderBy'];
        $dir = $_GET['dir'];
        $scoreMapper = new Score_Mapper();
        $this->scores = $scoreMapper->fetchAll("user_id = :user_id ORDER BY $orderBy $dir",array(':user_id' => $this->user->getId()));       
    }
    
    protected function getStats()
    {
        $this->isAjax = true;
        $stats = array();
        $stats['hcp'] = User_Helper::getHandicap($this->user);
        $stats['best'] = User_Helper::getBestScore($this->user);
        $stats['count'] = User_Helper::getRoundsPlayedCount($this->user);
        $stats['avg'] = User_Helper::getAverageScore($this->user);
        echo json_encode($stats);
    }
    
    protected function autoComplete()
    {
        $this->isAjax = true;
        $response = Score_Helper::autoComplete($this->user->getId(),$_GET['searchTerm']);
        echo json_encode($response);
    }
    
    protected function getMonthlyGraphData()
    {
        $this->isAjax = true;
        $handicapSet = User_Helper::GetMonthlyHandicapData($this->user);
        if(!empty($handicapSet)){
        	$handicapSet = array($handicapSet);
        }
        echo json_encode($handicapSet);
    }
}
