<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 4:43 AM
 * To change this template use File | Settings | File Templates.
 */
include 'autoloadClass.php';

class MyClousure{

    const member = 'const';

//    public $member = 'var';
    /**
     * @var Closure
     */
    public $member;

    function __construct(){
        $this->member  = function($input = 10){
            echo 'From var: ' . gettype($input) . ':' . ($input * 10) . PHP_EOL;
        };
    }

    function member(){
        echo 'from function: <br>';
    }

    function executeCallback(Closure $callback, $args){
        $callback($args);
    }

}

    ob_start(function($buffer){
        return  'From buffer: <br/>' . nl2br($buffer);
    });


$clousure = new MyClousure();

echo '----$clousure->member()----; : ' . PHP_EOL;
$clousure->member();
echo '-------$clousure::member();-------- : ' . PHP_EOL;
$clousure::member();
echo '-----$clousure::member; : -------' . PHP_EOL;
echo $clousure::member;
echo '-----$clousure::member();----- : ' . PHP_EOL;
$clousure::member();
echo '-----$clousure->member;----- : ' . PHP_EOL;
var_dump($clousure->member);
echo '-----call_user_func($clousure->member, 10)----- : ' . PHP_EOL;
call_user_func($clousure->member, 10);
echo '-----$clousure_func = $clousure->member; $clousure_func()----- : ' . PHP_EOL;
$clousure_func = $clousure->member;
$clousure_func(10);
echo '-----$clousure->__invoke()----- : ' . PHP_EOL;
$clousure->member->__invoke(10);

?><hr>////////////////////////////////////////////////////<?php
$clousure->executeCallback(function($input) use ($clousure){
        var_dump($input);
        var_dump($clousure);
        $clousure = NULL;
        var_dump($clousure);
    },
10);

var_dump($clousure);
?><hr>////////////////////////////////////////////////////<br><?php
function getClosure(){
    $ext_arg = 'Before';

    $internal_clousure = function($int_arg) use($ext_arg) {
        echo '$int_arg:' . $int_arg . PHP_EOL .  '$ext_arg:' . $ext_arg . PHP_EOL;
    };

    $ext_arg = 'After';

    return $internal_clousure;
}

$clousure = getClosure();
$clousure('setArg');
getClosure()->__invoke('invoke_Arg');
?><hr>////////////////////////////////////////////////////<br><?php

$array = range(1, 10);
$comp_array = array_map(function($el){
    return $el . 'upt';
}, $array);
var_dump($comp_array);

$odd_array = array_filter($array, function($el){
    return $el%2 == 0;
});
?><hr>////////////////////////////////////////////////////<br><?php
//set_error_handler(function(){
//        echo 'fatal';
//        //var_dump(func_get_args());
//}, error_reporting());

$dontsee = 'Before';
function cl_core(){
    $see = 'Before';
    $int_cl_top = function($int) use ($see){
        var_dump($int);
    };

    return $int_cl_top;
}
cl_core()->__invoke(10);

?><hr>////////////////////////////////////////////////////<br><?php
//$factorial = function($number) use ($factorial){ - error undefined $factorial -> need &
$factorial = function($number) use (&$factorial){
    //static $values;
    if($number == 1 || $number == 0){
        return 1;
    }

    return $factorial($number - 1) * $number;
};

$factorialstatic = function($number) use (&$factorialstatic){
    static $values;
    if($number == 1 || $number == 0){
        return 1;
    }
    if(isset($values[$number])){
        return $values[$number];
    }else{
        return $values[$number] = $factorialstatic($number - 1) * $number;
    }
};
ini_set('xdebug.max_nesting_level', 0);
set_time_limit(0);
$start1 = microtime(1);
var_dump($factorial(100));
$end1 = microtime(1);
$final1 = $end1 - $start1;
$factorialstatic(3);
//echo $clousure->member;

ob_end_flush();