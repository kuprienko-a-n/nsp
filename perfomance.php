<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: Andrei_Kuprienka
     * Date: 5/24/13
     * Time: 6:12 AM
     * To change this template use File | Settings | File Templates.
     */

$x = range(1, 100000);

$start1 = microtime(1);
$x2 = array_map(
    function ($v) {
        return $v + 1;
    }, $x
);
$end1 = microtime(1);
$finish1 = $end1 - $start1;

////Time: 0.4395
////Memory: 22179776
////---------------------------------------
//
$x2 = array();
foreach ($x as $v) {
    $x2[] = $v + 1;
}

$finish2 = microtime(1) - $end1;

var_dump($finish1, $finish2, $finish1/$finish2);

////Time: 0.0764
////Memory: 22174788
////---------------------------------------
//
//function tr($v)
//{
//    return $v + 1;
//}
//
//$x2 = array();
//foreach ($x as $v){
//    $x2[] = tr($v);
//}