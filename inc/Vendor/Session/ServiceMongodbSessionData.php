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

class ServiceMongodbSessionData extends \Vendor\Common\ServiceSessionData
{
    function getScheme(){
        return "{data:'', time:''}";
    }

    function  __construct(){
//        NSP::$app->registry->set('service_sdata', $this);
    }

    public static function getBySessionId($sname, $key = 'data'){
        $result = self::_getMongodbDatabaseSessions()
            ->findOne(array('_id' => $sname));

        return $key ? (!empty($result->{$key}) ? $result->{$key} : NULL) : $result;
    }

    public static function removeBySessionId($sname){
        self::_getMongodbDatabaseSessions()->remove(array('_id' => $sname));
        return true;
    }

    public static function removeAll(){
        self::_getMongodbDatabaseSessions()->remove();
    }

    //
/*For just find()
 * object(MongoCursor)#12 (0) {
}
array(2) {
  ["_id"]=>
  object(MongoId)#11 (1) {
  ["$id"]=>
    string(24) "51a38dc1bd56c0f35a6f24fb"
  }
  [0]=>
  array(3) {
    ["name"]=>
    string(32) "am07rddinqgmq116ve577afvq3qugh3p"
    ["data"]=>
    string(0) ""
    ["time"]=>
    int(1369676753)
  }
}
array(2) {
  ["_id"]=>
  object(MongoId)#14 (1) {
  ["$id"]=>
    string(24) "51a38dcabd56c0b55aaf06d4"
  }
  [0]=>
  array(3) {
    ["name"]=>
    string(32) "am07rddinqgmq116ve577afvq3qugh3p"
    ["data"]=>
    string(0) ""
    ["time"]=>
    int(1369676762)
  }
}*/
    public static function getAllSessions(){
        $data = array();
        $sessionsMongodbCursor = self::_getMongodbDatabaseSessions()->find();

        foreach ($sessionsMongodbCursor as $k => $v) {
           $data[] = $v;
        }

        return $data;
    }

    public static function saveSession($data){
        // create expires
        $expiry = time() + (int)\Vendor\Common\SessionHandler::$_config['lifetime'];
        $new_session = array(
                           '_id' => $data['_id'],
                           'data' => $data['data'],
                           'time' => $expiry,
        );
        // perform the update or insert
        try {
            $result = self::_getMongodbDatabaseSessions()->save($new_session);
            return $result['ok'] == 1;
        } catch (Exception $e) {
            throw $e;
            return false;
        }
        return true;
    }

    public static function removeExpiredSession(){
        self::_getMongodbDatabaseSessions()->remove(array('time' => array('$lt' => time())));

        return true;
    }


    public static function createTables(){
        //implements scheme creation
    }

    private static function _getMongodbDatabase(){
        try{
            $database = self::$config['database'];
            return self::getSessionsDbAdapter()->{$database};
        }catch (\Exception $e){
            throw new \Exception('Can\'t connect to the MongoDB server.');
        }
    }

    private static function _getMongodbDatabaseSessions(){
        try{
            $collection = self::$config['table'];
            return  self::_getMongodbDatabase()->selectCollection($collection);
        }catch (\Exception $e){
            throw new \Exception('No such sessions collections found');
        }
    }

    /********TEMP FUNCTIONS********/
}