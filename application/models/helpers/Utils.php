<?php
namespace Models\Helpers;
use Libraries\TinyPHP\Application;
class Utils
{
    private static $productionExceptionMsg = 'Oops! An error occurred behind the scenes. Please contact the website administrator for more information.';
    
    public static function errMsgHandler(\Exception $e)
    {
        return Application::$env == 'production' ? self::$productionExceptionMsg : $e->getMessage();
    }
    
    /*
     * Return the number of differentials used based on number of scores entered.
     */
    public static function differentialsUsedMap($scoresCount)
    {
        if(!is_int($scoresCount) || $scoresCount < 0){
            throw new \Exception("Provide # of scores as a positive integer to Utils::differentialsUsedMap method");
            return;
        }
        $key = $scoresCount > 20 ? 20 : $scoresCount;
        $usedDiffsMap = array(
            0 => 0,
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 2,
            8 => 2,
            9 => 3,
            10 => 3,
            11 => 4,
            12 => 4,
            13 => 5,
            14 => 5,
            15 => 6,
            16 => 6,
            17 => 7,
            18 => 8,
            19 => 9,
            20 => 10
        );
        return $usedDiffsMap[$key];
    }
}
