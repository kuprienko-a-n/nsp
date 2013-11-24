<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/23/13
 * Time: 7:21 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Vendor\Common;
use \Vendor\NSP\NSP;

abstract class ServiceSessionData
{
    public static $config = array(
        'database' => 'nps',   // name of sessions database
        'table'    => 'sessions',   // name of sessions collection
    );

    public static function getSessionsDbAdapter(){
        return NSP::$app->registry->get('db_session')->getAdapter();
    }

    abstract public static function getBySessionId($sname, $key = 'data');

    abstract public static function removeBySessionId($sname);

    abstract public static function removeAll();

    abstract public static function getAllSessions();

    abstract public static function saveSession($data);

    abstract public static function removeExpiredSession();

}