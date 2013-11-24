<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/23/13
 * Time: 7:20 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Vendor\Database;
use \Vendor\NSP\NSP;

class Sqlite{

    const SQLITE_DB_NAME = 'nsp.sqlite3';
    const SQLITE_DB_PATH = 'db/sqlite';
    const SQLITE_DB = 'db/sqlite/nsp.sqlite3';

    private $_db;

    function  __construct($config = NULL){
        $this->_db = new \PDO('sqlite:' . self::SQLITE_DB);
//        NSP::$app->registry->set('db', $this->_db);
        $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    function getAdapter(){
        return $this->_db;
    }
}