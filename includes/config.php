<?php
    $REGEX_USERNAME = "/^[a-zA-Z0-9_\-]{7,30}$/i";
    $REGEX_PASSWORD = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*()])[A-Za-z0-9!@#$%^&*()]{8,}$/i";
    $REGEX_EMAIL = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/i";

    $PYTHON = "py";

    function connect(){
        return new mysqli("localhost", "root", "irvanni", "webserver"); // Hostname, Username, Password, Database
    }

    function err($p){
        switch($p){
            case 1:
                echo '<h3 class="error">Invalid parameters!</h3>';
                break;
            case 2:
                echo '<h3 class="error">User not found!</h3>';
                break;
            case 3:
                echo '<h3 class="error">Username/Email already registered!</h3>';
                break;
            case 4:
                echo '<h3 class="error">Database error!</h3>';
                break;
            default:
                echo '<h3 class="error">Error!</h3>';
        }
    }

    function exec_query($db, $query, $types = null, $params = null){
        try{
            $stmt = $db->prepare($query);
            if($types != null && $params != null){
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $stmt->close();
            return true;
        }catch(Exception $e){
            return $e;
        }
    }

    function exec_query_catch_output($db, $query, $types = null, $params = null){
        try{
            $stmt = $db->prepare($query);
            if($types != null && $params != null){
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $arr = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $arr;
        }catch(Exception $e){
            return $e;
        }
    }

    function ssh_connect(){
        $ssh = ssh2_connect($_SESSION['user']['server'], $_SESSION['user']['ssh_port']);
        if(!$ssh){
            return false;
        }else{
            ssh2_auth_password($ssh, $_SESSION['user']['ssh_username'], $_SESSION['user']['ssh_password']);
            return $ssh;
        }
    }

    function ssh_exec($ssh, $cmd){
        ssh2_exec($ssh, $cmd);
    }

    function ssh_exec_catch_output($ssh, $cmd){
        $stream = ssh2_exec($ssh, $cmd);
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        return stream_get_contents($stream_out);
    }

    function ssh_access(){
        return isset($_SESSION['user']['server']) && isset($_SESSION['user']['ssh_port']) && isset($_SESSION['user']['ssh_username']) && isset($_SESSION['user']['ssh_password']);
    }

    function terminal_access(){
        return isset($_SESSION['user']['terminal_port']) && isset($_SESSION['user']['terminal_backand_path']) && isset($_SESSION['user']['terminal_instance_path']);
    }

    // https://www.w3schools.com/php/php_ref_ftp.asp
    class FTP{
        public $conn;
        public function __construct($url){
            $this->conn = ftp_connect($url);
        }
        public function __call($func,$a){
            if(strstr($func,'ftp_') !== false && function_exists($func)){
                array_unshift($a,$this->conn);
                return call_user_func_array($func,$a);
            }else{
                die("$func is not a valid FTP function");
            }
        }
    }
?>
