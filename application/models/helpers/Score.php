<?php
namespace Models\Helpers;
use Models\Score AS Score_Model;
class Score
{
    public static function calculateDifferential(Score_Model $score)
    {
        if(!$score->getScore() || !$score->getRating() || !$score->getSlope()){
            throw new \Exception("Score, Rating, and Slope must be set in order to calculate differential");
            return;
        }
        $differential = (($score->getScore() - $score->getRating()) * 113) / $score->getSlope();
        $score->setDifferential($differential);
    }
    
    /*
    * Return an array of errors.
    * If the return array is empty, we can assume that the user object is valid.
    */
    public static function validate(Score_Model $score)
    {
        $errors = array();
        if(!$score->getHolesPlayed() || !is_int($score->getHolesPlayed())){
            $errors[] = 'Please Enter The Number of Holes Played';
        }
        if($score->getHolesPlayed() > 18){
            $errors[] = 'You cannot enter more than 18 holes per round';
        }
        if(!$score->getCourseName()){
            $errors[] = 'Please Enter The Name of the Golf Course';
        }
        if(!$score->getDate()){
            $errors[] = 'Please Enter The Date That The Round Was Played';
        }
        if(!$score->getScore() || !is_int($score->getScore())){
            $errors[] = 'Please Enter A Valid Score For Your Round';
        }
        if($score->getScore() < $score->getHolesPlayed()){
            $errors[] = 'You couldn\'t have scored that low!';
        }
        if(!$score->getRating() || !is_float($score->getRating())){
            $errors[] = 'Please Enter A Valid Rating For Your Round';
        }
        if(!$score->getSlope() || !is_int($score->getSlope())){
            $errors[] = 'Please Enter A Valid Slope For Your Round';
        }
        if($score->getSlope() < $score->getRating()){
            $errors[] = 'Slope should be higher than rating!';
        }
        return $errors;
    }
}