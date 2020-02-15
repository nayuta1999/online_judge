<?php
    require_once('./source/APserver.php');
    $server = new APserver();
    $server -> run(function($remote, $line, $sock){
        $i = file_put_contents("./test.c",$line,FILE_APPEND);
        system("gcc test.c");
        $return_var = system("./a.out");
        var_dump($return_var);
        if($return_var === "Helloworld"){
            socket_write($remote,"AC");
        }
        else{
            socket_write($remote, "WA");
            socket_write($remote,$return_var);
        }
        file_put_contents("./test.c","");
        file_put_contents("a.out","");
    })
?>