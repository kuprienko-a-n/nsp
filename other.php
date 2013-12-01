<?php
$i= 10;
//var_dump($i++);//10
//var_dump($i);//11
//var_dump(10 + $i++ + ++$i); die;//32
var_dump($i + ++$i); die;//22
var_dump($i + $i++); die;//21
var_dump($i + $i++ + ++$i); die;//33
// при совместном использовании ++ и + результат будет неопределенным из документации
$a = 1;
echo ++$a + $a++; // может вывести 4 или 5


var_dump($i++ + ++$i); die;//22

ini_set('display_errors', 1);
$f = function(){
    $cl = 0;
    return function () use (&$cl){
    	var_dump($cl++);
    };
};
$c = $f();

$c();
$c();

die;
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 01.12.13
 * Time: 2:36
 */

ini_set('dipslay_errors', 1);
error_reporting(E_ALL);

$a = new stdClass();
$b = $a;
$a->g = 10;
xdebug_debug_zval('a');
xdebug_debug_zval('b');
/*
 a:
(refcount=2, is_ref=0),
object(stdClass)[1]
  public 'g' => (refcount=1, is_ref=0),int 10
b:
(refcount=2, is_ref=0),
object(stdClass)[1]
  public 'g' => (refcount=1, is_ref=0),int 10
*/
$c = new stdClass();
$d = &$c;
$c->g = 10;
var_dump('<br/>');
xdebug_debug_zval('c');
xdebug_debug_zval('d');
/*
 a:
(refcount=2, is_ref=0),
object(stdClass)[1]
  public 'g' => (refcount=1, is_ref=0),int 10
b:
(refcount=2, is_ref=0),
object(stdClass)[1]
  public 'g' => (refcount=1, is_ref=0),int 10
*/
var_dump('<br/>');
$t = 10;
$k = $t;
xdebug_debug_zval('t');
xdebug_debug_zval('k');
/*
t:
(refcount=2, is_ref=0),
object(stdClass)[3]
k:
(refcount=2, is_ref=0),
object(stdClass)[3]
 * */
var_dump('<br/>');
$f = 11;
$h = &$f;
$n = $f;
xdebug_debug_zval('f');
xdebug_debug_zval('h');
xdebug_debug_zval('n');
/*
 f:
(refcount=2, is_ref=1),int 11
h:
(refcount=2, is_ref=1),int 11
n:
(refcount=1, is_ref=0),int 11
*/
//
//$after_tags = 1000;
//
//$r = floor((0.1+0.7)*10);
//var_dump($r);
//$r2 = floor(bcadd('0.1','0.7', 1)*10);
//var_dump($r2);
//var_dump(bcadd('0.1','0.7'));