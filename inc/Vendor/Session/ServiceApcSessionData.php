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

class ServiceApcSessionData extends \Vendor\Common\ServiceSessionData
{
    const SAVE_SESSIONS_TABLE = true;
    function  __construct(){
        //        NSP::$app->registry->set('service_sdata', $this);
    }

    public static function getBySessionId($sname, $key = 'data'){
        if(!apc_exists($sname)){
            throw new \Exception('No session  data for this session is');
        }else{
            $result = apc_fetch($sname, $success);
        }

        if(!$success){
            throw new \Exception('Could\'not fetch sessions');
        }

        return $key ? (!empty($result->{$key}) ? $result->{$key} : NULL) : $result;
    }

    public static function removeBySessionId($sname){
        return apc_clear_cache($sname);
    }

    public static function removeAll(){
        return apc_clear_cache('sessions');
    }

    public static function getAllSessions(){
        return  apc_fetch('sessions');
    }

    public static function saveSession($data){
        // create expires
        $ttl = (int)\Vendor\Common\SessionHandler::$_config['lifetime'];//expirationTime
        $expiry = time() + $ttl;
        $new_session =  array(
                           'name' => $data['name'],
                           'data' => $data['data'],
                           'time' => $expiry,
    );
        // perform the update or insert
        try {
//            apc_add($new_session['name'], $new_session, $ttl);//if not already stored
            apc_store($new_session['name'], $new_session, $ttl);
            self::apcSaveSessionsTable($new_session);
            return true;
        } catch (Exception $e) {
            throw $e;
            return false;
        }
        return true;
    }

    public static function removeExpiredSession(){
        //apc control
        return true;
    }

    public static function createTables(){
        //implements scheme creation
    }

    public static function apcSaveSessionsTable($data){
        if(self::SAVE_SESSIONS_TABLE){
            $sessions = apc_exists('sessions') ? apc_fetch('sessions') : array();
            $sessions[] = $data;
            apc_store('sessions', $sessions, 1000000000000);
        }
    }

}