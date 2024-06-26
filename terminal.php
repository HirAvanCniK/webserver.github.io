<?php
    ob_start();
    $log_file = "terminalInstance.txt";
    session_start();
    require_once('./includes/config.php');
    if(!isset($_SESSION['user'])){
        header('Location: /login.php');
    }
    if(!ssh_access() || !terminal_access()){
        header('Location: /settings.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server</title>
    <link rel="stylesheet" href="static/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
    <link href="https://fonts.cdnfonts.com/css/space-mono" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/xterm@5.3.0/css/xterm.css"/>
    <script src="https://cdn.jsdelivr.net/npm/xterm@5.3.0/lib/xterm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xterm-addon-fit@0.8.0/lib/xterm-addon-fit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xterm-addon-fit@0.8.0/lib/xterm-addon-fit.js.map"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body id="bg">
    <canvas class="bg"></canvas>
    <canvas class="bg"></canvas>
    <canvas class="bg"></canvas>
    <main>
        <div id="background_blurred" class="all hidden"></div>
        <div id="navbar_pc">
            <nav class="navbar top">
                <a href="/" class="link"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link active"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
            </nav>
            <nav class="navbar bottom">
                <a href="settings.php" class="link"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
            </nav>
        </div>
        <div id="navbar_phone">
            <button onclick="toggle_navbar_phone()" class="navbar_phone_button fa-solid fa-bars"></button>
            <nav class="navbar navbar_phone_disable">
                <a href="/" class="link"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link active"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
                <div class="bottom">
                    <a href="settings.php" class="link"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                    <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
                </div>
            </nav>
        </div>
        <article>
            <?php
                $terminal_port = $_SESSION['user']['terminal_port'];
                $server = $_SESSION['user']['server'];
                echo "<label id=\"terminal_port\" style=\"display:none;\">$terminal_port</label>";
                echo "<label id=\"server\" style=\"display:none;\">$server</label>";
            ?>
            <!-- Instance status -->
            <?php
                $log_file = "terminalInstance.txt";
                if(strcmp('', file_get_contents("$log_file")) == 0){
                    echo '<i id="instanceStatus" class="off"></i>';
                }elseif(strcmp('error', file_get_contents("$log_file")) == 0){
                    echo '<i id="instanceStatus" class="error"></i>';
                }else{
                    echo '<i id="instanceStatus" class="on"></i>';
                }
            ?>
            <form method="post" class="terminalInstance">
                <button type="submit" class="btnInstance" name="instance"><i class="fa-solid " aria-hidden="true"></i></button>
                <div id="terminalmsg"></div>
                <?php
                    function isWindows() {
                        $os = strtoupper(PHP_OS);
                        return substr($os, 0, 3) == "WIN";
                    }
                    if(isset($_POST['instance'])){
                        if(strcmp('', file_get_contents("$log_file")) == 0){ // L'instanza del terminale non è aperta
                            $backend_path = './static/js/terminal/backend.js';
                            if(isWindows()){
                                exec("powershell -Command \"Start-Process -FilePath \"node\" -ArgumentList \"$backend_path\" -PassThru | Select-Object -ExpandProperty Id\"", $pid, $exit_code);
                            }else{
                                exec("node $backend_path > /dev/null 2>&1 & echo $!", $output, $exit_code);
                                $pid = !empty($output) ? (int)$output[0] : 0;
                            }
                            if($exit_code != 0){
                                file_put_contents("$log_file", 'error');
                            }else{
                                file_put_contents("$log_file", $pid);
                            }
                            sleep(3);
                        }elseif(strcmp('error', file_get_contents("$log_file")) == 0){
                            file_put_contents("$log_file", '');
                        }else{
                            $pid = file_get_contents("$log_file");
                            if(isWindows()){
                                shell_exec("taskkill /f /pid $pid");
                            }else{
                                shell_exec("kill -9 $pid");
                            }
                            file_put_contents("$log_file", "");
                            sleep(1);
                        }
                        header("Refresh:0");
                    }
                ?>
            </form>
            <div id="terminal"></div>
        </article>
    </main>
    <script type="text/javascript" src="static/js/background.js"></script>
    <script type="text/javascript" src="static/js/script3.js"></script>
    <script type="text/javascript" src="static/js/terminal/frontend.js"></script>
</body>
</html>

