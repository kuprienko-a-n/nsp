<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/20/13
 * Time: 6:00 AM
 * To change this template use File | Settings | File Templates.
 */
function __autoload($class_name){
  list($vendor, $namespace, $class) = explode('\\', $class_name);
  if($vendor && $namespace && $class){
    $filename = 'inc' . DIRECTORY_SEPARATOR . $vendor . DIRECTORY_SEPARATOR . $namespace . DIRECTORY_SEPARATOR . $class . '.php';

    require_once $filename;
  }
}


