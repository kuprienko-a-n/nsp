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

class Apc{

    private $_db;

    function  __construct($config = NULL){
        $this->_db = NULL;
    }

    function getAdapter(){
        return $this->_db;
    }
}