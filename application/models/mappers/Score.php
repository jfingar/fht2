<?php
namespace Models\Mappers;
use Libraries\TinyPHP\Db\MapperBase;
class Score extends MapperBase
{
    protected $table_name = 'scores';
    protected $model_name = '\Models\Score';
    
    protected function setProperties($obj,$row)
    {
        $obj->setId($row['id'])
            ->setUserId($row['user_id'])
            ->setScore($row['score'])
            ->setSlope($row['slope'])
            ->setRating($row['rating'])
            ->setCourseName($row['courseName'])
            ->setDifferential($row['differential'])
            ->setDate($row['date'])
            ->setHolesPlayed($row['holesPlayed'])
            ->setTees($row['tees']);
    }
    
   protected function getProperties($obj)
   {
       return array(
           'id' => $obj->getId(),
           'user_id' => $obj->getUserId(),
           'score' => $obj->getScore(),
           'slope' => $obj->getSlope(),
           'rating' => $obj->getRating(),
           'courseName' => $obj->getCourseName(),
           'differential' => $obj->getDifferential(),
           'date' => $obj->getDate(),
           'holesPlayed' => $obj->getHolesPlayed(),
           'tees' => $obj->getTees()
       );
   }
}