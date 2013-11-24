<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 6/5/13
 * Time: 7:27 PM
 * To change this template use File | Settings | File Templates.
 */

$var  = 0;

//$clouser = function(){
//    $counter = 0;
//    var_dump(++$counter);
//};
//$clouser();//1
//$clouser();//1
//$clouser();//1
///////////////////////////////////////////
//$clouser = function() use ($var){
//    var_dump(++$var);
//};
//$clouser();//1
//$clouser();//1
//$clouser();//1
//////////////////////////////////////////
//function createClousure(){
//    $counter = 0;
//
//    return function() use($counter){
//        var_dump(++$counter);
//    };
//};
//$clouser = createClousure();
//
//$clouser();//1
//$clouser();//1
//$clouser();//1
//////////////////////////////////////////

//function createClousure($var){
//    return function() use ($var){
//        var_dump(++$var);
//    };
//};
//$clouser = createClousure($var);
//
//$clouser();//1
//$clouser();//1
//$clouser();//1
//////////////////////////////////////////

//function createClousure(){
//    $var = 0;
//    return function() use ($var){
//        var_dump(++$var);
//    };
//};
//$clouser = createClousure();
//
//$clouser();//1
//$clouser();//1
//$clouser();//1

//------------!!!!!!!---------------

function createCounter(){
    $var = 0;
    return function() use (&$var){
        var_dump(++$var);
    };
};
$createCounter = createCounter();

$createCounter();//1
$var = 0;
$createCounter();//2
$var = 0;
$createCounter();//3

////////////////////////////////////////////
//$var = 0;
//$clouser = function () use(&$var) {
//    var_dump(++$var);
//};
//
//$clouser();//1
//$clouser();//2
//$clouser();//3
////||
//$clouser();//1
//$var = 0;
//$clouser();//1
//$var = 0;
//$clouser();//1

