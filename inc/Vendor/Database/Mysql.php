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

class Mysql{

    /**
     * @var $_db \PDO
     */
    private $_db;
    protected $primary = 'id';
    protected $table = '';

    function  __construct($config = null){
        $default = array('host' => '192.168.137.11', 'port' => 3306, 'dbname' => 'nsp', 'username' => 'nsp', 'password' => 'nsp');
        $dbconfig = array_merge($default, $config);
        $this->_db = new \PDO(
            "mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']}",
            $dbconfig['username'],
            $dbconfig['password']
        );

        $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return \PDO
     */
    function getAdapter(){
        return $this->_db;
    }

    function findAll($table){
        $stm = $this->_db->prepare("SELECT * FROM `{$table}`");
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getByPrimary($id, $table, $rowKey = null){
        $stm = $this->_db->prepare("SELECT * FROM `{$table}` WHERE {$this->primary} = :id");
        $stm->execute(array(
                           ':id' => $id,
                      ));
        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        return $rowKey ? $result[$rowKey] : $result;
    }


    public function removeByPrimary($id, $table){
        $stm = $stm = $this->_db->prepare("DELETE FROM `{$table}` WHERE {$this->primary} = :id");
        $binds = array(':id' => $id);

        return $stm->execute($binds);
    }

    public function removeAll($table){
        $stm = $stm = $this->_db->prepare("DELETE FROM `{$table}`");

        return $stm->execute();
    }

    public function insert($data, $table){
        $dataKeys = array_keys($data);
        $dataKeysStr = implode(',', $dataKeys);
        $dataKeysBind = array_map(function($el){
                $el = ':' . $el;
            }, $dataKeys);
        $dataKeysBindStr = implode(',', $dataKeys);

        $query = "INSERT INTO `{$table}` ({$dataKeysStr}) VALUES ({$dataKeysBindStr});";
        $stm = $this->_db->prepare($query);
        $binds = array_combine($dataKeysBind, $data);

        return $stm->execute($binds);
    }

    public function updateById($data, $table, $id){
        $valSetArr = array();
        foreach ($data as $col => $val) {
            $valSetArr[] = $col . " = '{$val}'";
        }
        $valSetStr = implode(',', $valSetArr);

        $query = "UPDATE `{$table}` SET {$valSetStr} WHERE {$this->primary} = :id";
        $stm = $this->_db->prepare($query);
        $binds = array(
            ':id' => $id,
        );

        return $stm->execute($binds);
    }

}