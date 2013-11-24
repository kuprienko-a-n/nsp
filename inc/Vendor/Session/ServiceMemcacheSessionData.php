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
use \Vendor\Common;

class ServiceMemcacheSessionData extends Common\ServiceSessionData
{
    const SAVE_SESSIONS_TABLE = TRUE;
    function  __construct(){
        //NSP::$app->registry->set('service_sdata', $this);
    }

    public static function getBySessionId($sname, $key = 'data'){
        $result = Common\ServiceSessionData::getSessionsDbAdapter()->get($sname);

        if(!$result){
            throw new \Exception('Could\'not fetch sessions');
        }

        return $key ? (!empty($result->{$key}) ? $result->{$key} : NULL) : $result;
    }

    public static function removeBySessionId($sname){
        return Common\ServiceSessionData::getSessionsDbAdapter()->delete($sname);
    }

    public static function removeAll(){
        return Common\ServiceSessionData::getSessionsDbAdapter()->flush();
    }

    public static function getAllSessions(){
        return  unserialize(Common\ServiceSessionData::getSessionsDbAdapter()->get('sessions'));
    }

    public static function saveSession($data){
        /** @var $m \Memcache() */
        //$m = Common\ServiceSessionData::getSessionsDbAdapter();
        // create expires
        $ttl = (int)\Vendor\Common\SessionHandler::$_config['lifetime'];//expirationTime
        $expiry = time() + $ttl;
        $new_session =  array(
                           'name' => $data['name'],
                           'data' => $data['data'],
                           'time' => $expiry,
        );
        try {
            Common\ServiceSessionData::getSessionsDbAdapter()->set($new_session['name'], $new_session, false, $ttl);
            self::memcacheSaveSessionsTable($new_session);
            return TRUE;
        } catch (Exception $e) {
            throw $e;
            return FALSE;
        }
        return TRUE;
    }

    public static function removeExpiredSession(){
        //apc control
        return TRUE;
    }

    public static function createTables(){
        //implements scheme creation
    }

    public static function memcacheSaveSessionsTable($data){
        if(self::SAVE_SESSIONS_TABLE){
            $sessions =  Common\ServiceSessionData::getSessionsDbAdapter()->get('sessions');
            $sessions = $sessions ? unserialize($sessions) : array();
            $sessions[] = $data;
            return Common\ServiceSessionData::getSessionsDbAdapter()->set('sessions', serialize($sessions), false, 360000);
        }
    }

}