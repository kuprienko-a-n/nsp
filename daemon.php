<?php
// Форкаем процесс
$pid = pcntl_fork();
if ($pid == -1) {
    // Ошибка
    die('could not fork'.PHP_EOL);
} else if ($pid) {
    // Родительский процесс, убиваем
    die('die parent process'.PHP_EOL);
} else {
    // Новый процесс, запускаем главный цикл
//    while(true) {
//
//    }
}
// Отцепляемся от терминала
posix_setsid();

//function bkg($executable, $args){
//    $childPid = pcntl_fork();
//    if ($childPid == 0) {
//        posix_setsid();
//        fclose(STDOUT); // в манах говорится, что необходимо закрыть поток стд. вывода
//        fclose(STDERR); // и ошибок
//        $pid = getmypid();
//        $STDOUT = fopen("log." . $pid .  ".out", "wb");
//        echo 'out to log.out, my pid is ' . $pid . PHP_EOL;
//        pcntl_exec($executable, $args);
//    } elseif($childPid != -1) {
//        $pid = getmypid();
//        echo 'i am still parent, out to cli, my pid is ' . $pid . PHP_EOL;
//    }
//}

//function daemon()
//{
//    checkPid();
//    $pid =  pcntl_fork();
//
//    if ($pid < 0)
//        die('error call fork()'.PHP_EOL);
//
//    if ($pid)
//        exit();
//
//    echo 'start process pid=', posix_getpid(), PHP_EOL;
//
//    $sid = posix_setsid();
//    if ($sid < 0) exit;
//
//    global $pidFilename;
//    file_put_contents($pidFilename, posix_getpid());
//
//    fclose(STDOUT);
//    fclose(STDIN);
//    fclose(STDERR);
//}