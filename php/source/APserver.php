<?php
    class APserver{
        public $sock = NULL;

        public function __construct($addr = "172.40.2.2",$port = 5000){
            $sock = $this->newSocket($addr,$port);
            $this->sock = $sock;
        }

        private function newSocket($addr,$port){
            #ソケットの作成
            if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
                throw new \Exception("socket_create() failed: ".socket_strerror(socket_last_error()));
            }
            #ソケットのオプション
            if ((socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1)) === false) {
                throw new \Exception("socket_set_option() failed: ".socket_strerror(socket_last_error()));
            }
            #ソケットに名前をバインド
            if ((socket_bind($sock, $addr, $port)) === false) {
                throw new \Exception("socket_bind() failed: ".socket_strerror(socket_last_error($sock)));
            }
            #ソケットが受付待ちをする
            if (socket_listen($sock) === false) {
                throw new \Exception("socket_listen() failed: ".socket_strerror(socket_last_error($sock)));
            }
            //var_dump("サーバー起動\n");
            return $sock;
        }
        /*
        *@code Closure
        */
        public function run(Closure $code){
            while ($remote = socket_accept($this->sock)) {
                while ($line = socket_read($remote, 1024)) {
                    $code($remote, $line, $this->sock);
                }
            }
        }
    }
?>