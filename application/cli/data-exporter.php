<?php
$dsn = 'mysql:dbname=freehandicaptrac;host=54.218.99.150';
$db = new PDO($dsn,'jfingar','s2qq3c5g');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

$sql = "SELECT *
        FROM freehandicaptrac.scores
        WHERE iGolferID = 1";

$sth = $db->query($sql);
$result = $sth->fetchAll();
print_r($result);
try{
    $dsn2 = 'mysql:dbname=freehandicaptracker;host=localhost';
    $db2 = new PDO($dsn2,'root','');
    $db2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    $db2->setAttribute(PDO::ATTR_ERRMODE,2);

    $sql = "TRUNCATE TABLE freehandicaptracker.scores";
    $db2->exec($sql);

    foreach($result as $row){
        $sql = "INSERT INTO freehandicaptracker.scores
                SET user_id = '1',
                    score = '{$row['iScore']}',
                    slope = '{$row['dCourseSlope']}',
                    rating = '{$row['dCourseRating']}',
                    courseName = '{$row['cCourse']}',
                    differential = '{$row['dDiff']}',
                    date = '{$row['date']}',
                    holesPlayed = '18',
                    tees = ''";
        $db2->exec($sql);
    }
}catch(Exception $e){
    echo $e->getMessage();
}