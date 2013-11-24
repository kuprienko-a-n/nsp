<?php
//ob_start(function($buffer){
//        return $buffer;
//    });
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/23/13
 * Time: 5:13 AM
 * To change this template use File | Settings | File Templates.
 */

define('NSP_ROOT', __DIR__);
include_once 'autoloadClass.php';

$appl = new \Vendor\Application\Application();
$appl->run(\Vendor\Application\Application::DEBUG_MODE_ON);
//ob_end_flush();
?>


