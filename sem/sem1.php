<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 24.11.13
 * Time: 4:33
 */

//sem_release не удаляет семафор который acquire другим процессом, помогает только sem_remove и баг уще кидает на других останвленных процессах
//sem_acquire по данному id затребованный в другом процессе постаит на паузу этот процесс пока семафор каким-либо образом не будет релизнут

$id = sem_get(1, 1, 0666, 0);
sem_acquire($id);
//sem_remove($id);
sem_release($id);