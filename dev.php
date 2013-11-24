<?php
//ini_set('dipslay_errors', 1);
//error_reporting(E_ALL);
////require_once 'a/a.php';
////require_once 'b/b.php';
////require_once 'autoload.php';
//require_once 'autoloadClass.php';
//
//use Vendor\A\A as A;
//use Vendor\B\A as B;
//use Vendor\Dev as Dev;
////use A\A;
////use B\A;//no alias : Fatal error: Cannot use B\A as A because the name is already in use in /home/drupal/websites/nsp/index.php on line 9????
//
//echo 'INIT:';
//$a = new A();
//$b = new B();
//$dev1 = new Dev\Dev();
//$dev2 = new Dev\Dev();
//echo '<br> Next:';
////Dev\Change::change($dev); - autoload start working and throw exception???
//
//
//function change($object){
//    $object = 'changed';
//}
//
////Dev\Change::change($dev1);
////change($dev2);
//
//
////echo "<br>Result:" . $dev1 . "<br />";
////echo "<br>Result:" . $dev2;
///**in function/methids objects by copy!!!!!!!!**/
//$new = $dev2;
//$new->a = 'new';
//
//Dev\Dev::render('dev2', $dev2);
//Dev\Dev::render('new', $new);
//
///**by copying objects changes!!!!!!!!**/
//
//$array = array(1,2,3,4);
//$new = $array;
//$new = array(1);
//
//Dev\Dev::render('array', $array);
//Dev\Dev::render('new', $new);

/**by copying array not!!!!!!!!**/

class A{
    function init(){
        $this->run();
    }

    function run(){
        echo 'Hello from class A';
    }
}

class B extends  A{
    function init(){
        parent::init();
    }

    function run(){
        echo 'Hello from class B';
    }
}

$b = new B();
$b->init();//Hello from class B

function test_exception($var = NULL){
    if(is_null($var)){
        throw new \Exception('My exception test');
    }
}

try{
    test_exception();
}catch (\Exception $e){
    echo $e->getMessage();
}

var_dump('after error !!!!!))))');//it's happened


class Calendar {
    public $year = 2001;
    public function &getYear() {
        return $this->year;
    }
}

$obj = new Calendar;
$a = &$obj->getYear();  // 2001
$obj->year = 2010;      // 2010
apc_add('ref', $a, 60);
$ref = apc_fetch('ref');
$ref++;
echo $ref;              // 2011

