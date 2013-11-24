<?php
// Создаём сокет, биндим и слушаем
// В случае если мы хотим создать интернет сокет (а мы хотим!)
// Мы должны прописать путь соединения примерно такой
// "tcp://127.0.0.1:8080/" что значит мы биндим порт 8080 на локалхосте
$socket = stream_socket_server(
    "tcp://192.168.137.11:8082",
    $errno,
    $errstr,
    STREAM_SERVER_BIND | STREAM_SERVER_LISTEN
);

if ( ! $socket )
{
    echo "$errstr ( $errno )\n";
}
else
{
    // Поступающее соединение от клиента принимаем
    while ( $conn = stream_socket_accept($socket) )
    {
        $data = 'Московское время' . date('H:i:s')  . PHP_EOL;
        fwrite( $conn, $data );
        fclose( $conn );
    }
    fclose($socket);
}