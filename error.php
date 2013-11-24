<?php
//error_reporting(E_ALl | E_STRICT);
//ini_set('display_errors', 1);
//
//$shmid = shop_open(ftok(__FILE__, 'e'), 'c', 0644, 1024);
//
//die;

$test;

function fact($n){
    if($n == 1){
        return 1;
    }
    return fact($n - 1) * $n;
}

function feb($n){
    static $cache;

    if($n == 1 || $n == 2){
        return 1;
    }

    if(!isset($cache[$n])){
        $cache[$n] = feb($n - 1) + feb($n - 2);
    }

    return $cache[$n];
}

echo fact(5);
die;

/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/22/13
 * Time: 4:44 AM
 * To change this template use File | Settings | File Templates.
 */
include_once 'autoloadClass.php';

$appl = new \Vendor\Application\Application();
//should be init before possible mistakes
set_error_handler(array($appl, 'handleError'), error_reporting());
set_exception_handler(array($appl, 'handleException'));
//
echo $test;
//register error handler

//check different Exception
//trigger exception
try{
    \Vendor\Error\Service::checkErrorWork(\Vendor\Error\Service::SERVICE_ERROR_MY);
}
//variant - 1
catch(\Vendor\Error\MyException $e){
    echo '1 ' . $e->getMessage();
}
catch(\Vendor\Error\MyExceptionOther $e){
    echo '2 ' . $e->getMessage();
}
catch(Exception $e){
    echo '3' . $e->getMessage();
}

//variant - 2
//catch(\Exception $e){
//    switch(get_class($e)){
//        case  'Exception':
//            echo '1 ' . $e->getMessage();
//            break;
//        case 'Vendor\Error\MyException':
//            echo '2 ' . $e->getMessage();
//            break;
//        case 'Vendor\Error\MyExceptionOther':
//            echo '3 ' . $e->getMessage();
//            break;
//        default:
//            echo '4 default';
//    }
//}


