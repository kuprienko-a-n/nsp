<?php
// Тут всё также tcp://127.0.0.1:8080
ob_start(function($data){
        header('Content-type:text/html; charset=utf-8;');
        return $data;
    });
$socket = stream_socket_client(
    "tcp://192.168.137.11:8082",
    $errno,
    $errstr,
    30,
    STREAM_CLIENT_ASYNC_CONNECT|STREAM_CLIENT_CONNECT
);
if ( ! $socket )
{
    echo "$errstr ($errno)<br />\n";
}
else
{
    fwrite( $socket, "HI" );

    while ( ! feof( $socket ) )
    {
        echo fgets( $socket, 1024 );
    }
    fclose( $socket );
}
