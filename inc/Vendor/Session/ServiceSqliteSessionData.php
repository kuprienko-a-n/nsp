<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/23/13
 * Time: 7:21 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Vendor\Session;
use \Vendor\NSP\NSP;

class ServiceSqliteSessionData extends \Vendor\Common\ServiceSessionData
{
    function  __construct(){
//        NSP::$app->registry->set('service_sdata', $this);
    }

    public static function getBySessionId($sname, $key = 'data'){
        $stm = NSP::$app->registry->get('db_session')->getAdapter()->prepare("SELECT * FROM `sessions` WHERE name = :name");
        $stm->execute(array(':name' => $sname));
        $result = $stm->fetch();

        return $key ? $result[$key] : $result;
    }

    public static function removeBySessionId($sname){
        $stm = $stm = NSP::$app->registry->get('db_session')->getAdapter()->prepare("DELETE FROM `sessions` WHERE name = :name");

        return $stm->execute(array(':name' => $sname));
    }

    public static function removeAll(){
        $stm = $stm = NSP::$app->registry->get('db_session')->getAdapter()->prepare("DELETE FROM `sessions`");

        return $stm->execute();
    }

    public static function getAllSessions(){
        $stm = NSP::$app->registry->get('db_session')->getAdapter()->prepare("SELECT * FROM `sessions`");
        $stm->execute();

        return $stm->fetchAll();
    }

    public static function saveSession($data){
        $name = 'session1';//
        $query = "INSERT OR REPLACE INTO `sessions` (name, data, time) VALUES(:name, :data, :time);";
        $stm = NSP::$app->registry->get('db_session')->getAdapter()->prepare($query);
        return $stm->execute(array(
                           ':name' => $data['name'],
                           ':data' => $data['data'],
                           ':time' => time(),
                      ));
    }

    public static function removeExpiredSession(){
        $stm = $stm = NSP::$app->registry->get('db_session')->getAdapter()->prepare("DELETE FROM `sessions` WHERE time < :time");

        return $stm->execute(array(':name' => time()));
    }

    /********TEMP FUNCTIONS********/
    public static function createTables(){
        $dbAdapter = $stm = NSP::$app->registry->get('db_session')->getAdapter();
        //$dbAdapter->exec("DROP table IF EXISTS sessions");
        $dbAdapter->exec("CREATE TABLE IF NOT EXISTS sessions (
                    name TEXT PRIMARY KEY,
                    data TEXT,
                    time INTEGER)");

//                    id INTEGER PRIMARY KEY AUTOINCREMENT,
        //$r = $dbAdapter->exec('INSERT INTO sessions (name, data, time) VALUES ("session1", "session1 data", 11111111)');
    }
}