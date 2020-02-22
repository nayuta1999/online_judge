<?php
    require_once('./source/APserver.php');
    $server = new APserver();
    $server -> run(function($remote, $line, $sock){
        $file_string = substr($line,strpos($line,"#"),strlen($line));
        $i = file_put_contents("./test.c",$file_string,FILE_APPEND);
        system("gcc test.c");
        $return_var = system("./a.out");
        if(strcmp($return_var,"Hello world\n")){
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