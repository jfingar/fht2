<?php
namespace Models;
class Score
{
    private $id;
    private $score;
    private $slope;
    private $rating;
    private $courseName;
    private $differential;
    private $user_id;
    private $date;
    private $holesPlayed;
    private $tees;
	
    public function setId($val)
    {
        $this->id = $val;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setScore($val)
    {
        $this->score = (int) $val;
        return $this;
    }
    
    public function getScore()
    {
        return $this->score;
    }
    
    public function setSlope($val)
    {
        $this->slope = (int) $val;
        return $this;
    }
    
    public function getSlope()
    {
        return $this->slope;
    }
    
    public function setRating($var)
    {
        $this->rating = (float) $var;
        return $this;
    }
    
    public function getRating()
    {
        return $this->rating;
    }
    
    public function setCourseName($var)
    {
        $this->courseName = (string) $var;
        return $this;
    }
    
    public function getCourseName()
    {
        return $this->courseName;
    }
    
    public function setDifferential($var)
    {
        $this->differential = (float) $var;
        return $this;
    }
    
    public function getDifferential()
    {
        return $this->differential;
    }
    
    public function setUserId($var)
    {
        $this->user_id = $var;
        return $this;
    }
    
    public function getUserId()
    {
        return $this->user_id;
    }
    
    public function setDate($var)
    {
        $this->date = $var;
        return $this;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setHolesPlayed($var)
    {
        $this->holesPlayed = (int) $var;
        return $this;
    }
    
    public function getHolesPlayed()
    {
        return $this->holesPlayed;
    }
    
    public function setTees($var)
    {
        $this->tees = $var;
        return $this;
    }
    
    public function getTees()
    {
        return $this->tees;
    }

}