<?php
/*
 * Data importer will import existing data to localhost db by default.
 * Passing the command-line argument "go-live" will cause the data to be
 * imported into the new prod db on digital ocean.
 */

$live = isset($argv[1]) && $argv[1] == 'go-live' ? true : false;

$dsnLocal = "mysql:dbname=freehandicaptracker;host=localhost";
$dsnCurrentProd = "mysql:dbname=freehandicaptrac;host=54.218.99.150";
$dsnNewProd = "mysql:dbname=freehandicaptracker;host=192.241.225.99";

$localDb = new PDO($dsnLocal,'root','');
$localDb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
$localDb->setAttribute(PDO::ATTR_ERRMODE,2);

$currentProdDb = new PDO($dsnCurrentProd,'jfingar','s2qq3c5g');
$currentProdDb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
$currentProdDb->setAttribute(PDO::ATTR_ERRMODE,2);

$newProdDb = new PDO($dsnNewProd,'jfingar','@d0dbM45st3R$#');
$newProdDb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
$newProdDb->setAttribute(PDO::ATTR_ERRMODE,2);

// truncate users & scores tables
$truncateUsersString = "TRUNCATE TABLE freehandicaptracker.users";
$truncateScoresString = "TRUNCATE TABLE freehandicaptracker.scores";
if($live){
    echo "Truncating Production users table\r\n";
    $newProdDb->exec($truncateUsersString);
    echo "Truncating Production scores table\r\n";
    $newProdDb->exec($truncateScoresString);
}else{
    echo "Truncating local users table\r\n";
    $localDb->exec($truncateUsersString);
    echo "Truncating local scores table\r\n";
    $localDb->exec($truncateScoresString);
}

// pull existing live data
$sql = "SELECT *
        FROM freehandicaptrac.users";
$statement = $currentProdDb->query($sql);
echo "Pulling all users rows from AWS db server\r\n";
$existingUsers = $statement->fetchAll();

$sql = "SELECT S.*
        FROM freehandicaptrac.scores S
        JOIN freehandicaptrac.users U
        ON U.iGolferID = S.iGolferID";
$statement = $currentProdDb->query($sql);
echo "Pulling all scores rows from AWS db server\r\n";
$existingScores = $statement->fetchAll();

// populate users table
echo "Begin populating users table\r\n";
foreach($existingUsers as $k => $existingUserRow){
    $signupType = $existingUserRow['eSignup'] ? $existingUserRow['eSignup'] : 'website';
    $prepared = array(
        ':id' => $existingUserRow['iGolferID'],
        ':email' => $existingUserRow['cEmail'],
        ':password' => $existingUserRow['cPW'],
        ':firstName' => $existingUserRow['cNameF'],
        ':lastName' => $existingUserRow['cNameL'],
        ':signupType' => $signupType
    );
    $sql = "INSERT INTO freehandicaptracker.users
            SET id = :id,
                email = :email,
                password = :password,
                firstName = :firstName,
                lastName = :lastName,
                signupType = :signupType";
    if($live){
        $statement = $newProdDb->prepare($sql);
        echo "Inserting row " . ($k + 1) . " of " . count($existingUsers) . " into Digital Ocean users table\r\n";
        $statement->execute($prepared);
    }else{
        $statement = $localDb->prepare($sql);
        echo "Inserting row " . ($k + 1) . " of " . count($existingUsers) . " into local users table\r\n";
        $statement->execute($prepared);
    }
}
echo "Finished populating users table\r\n";

// populate scores table
echo "Begin populating scores table\r\n";
foreach($existingScores as $k => $existingScoresRow){
    $slope = $existingScoresRow['dCourseSlope'] ? $existingScoresRow['dCourseSlope'] : 113;
    $rating = $existingScoresRow['dCourseRating'] ? $existingScoresRow['dCourseRating'] : 70.0;
    $prepared = array(
        ':userId' => $existingScoresRow['iGolferID'],
        ':score' => $existingScoresRow['iScore'],
        ':slope' => $slope,
        ':rating' => $rating,
        ':courseName' => $existingScoresRow['cCourse'],
        ':differential' => $existingScoresRow['dDiff'],
        ':date' => $existingScoresRow['date'],
        ':holesPlayed' => 18,
        ':tees' => ''
    );
    $sql = "INSERT INTO freehandicaptracker.scores
            SET user_id = :userId,
                score = :score,
                slope = :slope,
                rating = :rating,
                courseName = :courseName,
                differential = :differential,
                date = :date,
                holesPlayed = :holesPlayed,
                tees = :tees";
    if($live){
        $statement = $newProdDb->prepare($sql);
        echo "Inserting row " . ($k + 1) . " of " . count($existingScores) . " into Digital Ocean scores table\r\n";
        $statement->execute($prepared);
    }else{
        $statement = $localDb->prepare($sql);
        echo "Inserting row " . ($k + 1) . " of " . count($existingScores) . " into local scores table\r\n";
        $statement->execute($prepared);
    }
}
echo "Finished populating scores table\r\n";
echo "Script complete\r\n";