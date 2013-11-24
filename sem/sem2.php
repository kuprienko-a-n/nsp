<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 24.11.13
 * Time: 4:33
 */
$id = sem_get(1);
//sem_acquire($id);
echo 'After sem';
sem_remove($id);
//sem_release($id);

//<?php
//$SEMKey = "123456" ;
//
//## Get Semaphore id
//$seg = sem_get( $SEMKey, 2, 0666, -1) ;
//
//if ( $argv[1]=="remove" ) {
//    sem_remove($seg);
//}
//
//echo "Try to acquire ..."
//sem_acquire($seg);
//echo "Acquired...\n" ;
//
//echo "Press Any Key to continue...\n";
//$fh = fopen("php://stdin", "r");
//$a = fgets( $fh);
//fclose($fh);
//
//sem_release($seg);
//?>

