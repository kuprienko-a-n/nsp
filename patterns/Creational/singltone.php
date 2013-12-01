<?php
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 04.12.13
 * Time: 1:55
 */
class Singltone
{
    private static $instance;

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static();
        }
        return self::$instance;
    }

    final private function __construct(){}

    public function __sleep(){
        return false;
    }

    final function __clone(){
        return false;
    }
}

class B extends Singltone
{

}

$b1 = B::getInstance();
$b2 = B::getInstance();

var_dump($b1 === $b2);
var_dump(get_class($b2));