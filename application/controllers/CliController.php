<?php
namespace Controllers;
use Libraries\TinyPHP\ControllerBase;
use Libraries\TinyPHP\Db\Adapter;
class CliController extends ControllerBase
{
    /*
     * Imports all data from production to development db
     */
    public function DevDataImport()
    {
        // fetch remote data
        $dsn = 'mysql:host=192.241.225.99;dbname=freehandicaptracker';
        $remoteDb = new PDO($dsn,'jfingar','@d0dbM45st3R$#');
        
        $sql = "SELECT * FROM freehandicaptracker.users";
        $statement = $remoteDb->query($sql);
        $allUsersRows = $statement->fetchAll();
        
        $sql = "SELECT * FROM freehandicaptracker.scores";
        $statement = $remoteDb->query($sql);
        $allUsersRows = $statement->fetchAll();
        
        $sql = "SELECT * FROM freehandicaptracker.password_reset";
        $statement = $remoteDb->query($sql);
        $allUsersRows = $statement->fetchAll();
        
        // clear out all data from all local tables
        $localDb = Adapter::GetMysqlAdapter();
        
        $sql = "TRUNCATE TABLE freehandicaptracker.users";
        $localDb->exec($sql);
        
        $sql = "TRUNCATE TABLE freehandicaptracker.scores";
        $localDb->exec($sql);
        
        $sql = "TRUNCATE TABLE freehandicaptracker.password_reset";
        $localDb->exec($sql);
        
        // import data
        foreach($allUsersRows as $row){
            $sql = "INSERT INTO freehandicaptracker.users
                    SET ";
        }
    }
    
    public function dataImporter()
    {
        
    }
}