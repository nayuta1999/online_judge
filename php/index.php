<?php

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    die("socket_create() failed: ".socket_strerror(socket_last_error()));
}

if (socket_connect($sock, '172.40.2.2', 5000) === false) {
    die("socket_connect() failed: ".socket_strerror(socket_last_error()));
}

$buf = "#include <stdio.h>\nint main(void){printf(\"Helloworld\");return 0;}";
socket_write($sock, $buf, strlen($buf));
echo socket_read($sock, 1024);
/*
$buf = "bar\n";
socket_write($sock, $buf, strlen($buf));
echo socket_read($sock, strlen($buf));
*/
socket_close($sock);

?>