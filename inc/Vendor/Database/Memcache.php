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

class Memcache{

    /**
     * @var \Memcache
     */
    private $_db;

    function  __construct($config = NULL){
        if(!isset($config['connection'])){
            throw new \Exception('memcache config is not set');
        }

        $this->_db = new \Memcache();
        $this->_db->connect($config['connection']['host'], $config['connection']['port']);
    }

    function getAdapter(){
        return $this->_db;
    }
}