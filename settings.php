<?php
	ob_start();
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: /login.php');
    }
    require_once('./includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="static/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
    <link href="https://fonts.cdnfonts.com/css/space-mono" rel="stylesheet">
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
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
            </nav>
            <nav class="navbar bottom">
                <a href="settings.php" class="link active"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
            </nav>
        </div>
        <div id="navbar_phone">
            <button onclick="toggle_navbar_phone()" class="navbar_phone_button fa-solid fa-bars"></button>
            <nav class="navbar navbar_phone_disable">
                <a href="/" class="link"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
                <div class="bottom">
                    <a href="settings.php" class="link active"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                    <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
                </div>
            </nav>
        </div>
        <article>
            <form id="profile" method="POST">
                <header>
                    <h1>Hello <?php echo $_SESSION['user']['username']; ?></h1>
                    <h4 class="subtitle">Be careful when changing these settings!</h4>
                    <div id="download_div">
                        <br>
                        <a id="download_btn" href="./includes/backend.js" download>Download 'backend.js'!</a>
                        <br>
                        <i>or run this in your webserver</i>
                        <br>
                        <code id="download_code">wget
                            <?php
                                echo $_SERVER['HTTP_REFERER'] . "includes/backend.js -O ";
                                if($_SESSION['user']['webserver_home_directory']){
                                    echo trim($_SESSION['user']['webserver_home_directory']);
                                }else{
                                    echo "[webserver_home_directory]/";
                                }
                            ?>terminal/backend.js</code>
                        <br>
                    </div>
                </header>
                <div class="setting">
                    <div>
                        <span class="title">Username</span>
                        <br>
                        <span class="description">The user name displayed throughout the site</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="username" value="<?php echo $_SESSION['user']['username']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Email</span>
                        <br>
                        <span class="description">The e-mail for possible contact from the service</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Network Information</span>
                        <br>
                        <span class="description">Want to speedtest your server connection on the home page?, (the speedtest takes about 30 seconds)</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <?php
                            if($_SESSION['user']['get_network_information'] != null && strcmp($_SESSION['user']['get_network_information'], "on") == 0){
                                echo '<input type="checkbox" class="checkbox" name="get_network_information" disabled checked>';
                            }else{
                                echo '<input type="checkbox" class="checkbox" name="get_network_information" disabled>';
                            }
                        ?>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Server</span>
                        <br>
                        <span class="description">The domain of the server to which this service is to connect</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="server" value="<?php echo $_SESSION['user']['server']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">SSH Port</span>
                        <br>
                        <span class="description">The port of the server</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="number" min="0" max="65535" name="ssh_port" value="<?php echo $_SESSION['user']['ssh_port']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">SSH Username</span>
                        <br>
                        <span class="description">The username used log into the SSH server</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="ssh_username" value="<?php echo $_SESSION['user']['ssh_username']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">SSH Password</span>
                        <br>
                        <span class="description">The password used to log into the SSH server</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="ssh_password" value="<?php echo $_SESSION['user']['ssh_password']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Terminal port</span>
                        <br>
                        <span class="description">The websocket port for the terminal</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="number" min="0" max="65535" name="terminal_port" value="<?php echo $_SESSION['user']['terminal_port']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Terminal executable file path</span>
                        <br>
                        <span class="description">The path of node executable file of terminal</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="terminal_backend_path" value="<?php echo $_SESSION['user']['terminal_backend_path']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Terminal log file path</span>
                        <br>
                        <span class="description">The path of log file of terminal</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="terminal_instance_path" value="<?php echo $_SESSION['user']['terminal_instance_path']; ?>" disabled>
                    </div>
                </div>
                <div class="setting">
                    <div>
                        <span class="title">Webserver Home directory</span>
                        <br>
                        <span class="description">The path of the home directory of your webserver</span>
                    </div>
                    <div class="value">
                        <i onclick="edit(this)" class="fa-solid fa-pen edit"></i>
                        <input type="text" name="webserver_home_directory" value="<?php echo $_SESSION['user']['webserver_home_directory']; ?>" disabled>
                    </div>
                </div>
                <footer>
                    <a onclick="reset()" class="btn reset">Reset</a>
                    <button type="submit" class="btn apply" onclick="apply()">Apply</button>
                </footer>
                <?php
                    $db = connect();
                    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['server']) && isset($_POST['ssh_port']) && isset($_POST['ssh_username']) && isset($_POST['ssh_password']) && isset($_POST['terminal_port']) && isset($_POST['terminal_backend_path']) && isset($_POST['terminal_instance_path']) && isset($_POST['webserver_home_directory'])){
                        if(!preg_match($REGEX_USERNAME, $_POST['username']) || !preg_match($REGEX_EMAIL, $_POST['email'])){
                            err(1);
                        }else{
                            if(exec_query($db, "UPDATE users SET username = ?  WHERE id = ?", "si", array($_POST['username'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET email = ?  WHERE id = ?", "si", array($_POST['email'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET server = ?  WHERE id = ?", "si", array(strcmp($_POST['server'], "")==0 ? null : $_POST['server'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET ssh_port = ?  WHERE id = ?", "si", array($_POST['ssh_port'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET ssh_username = ?  WHERE id = ?", "si", array(strcmp($_POST['ssh_username'], "")==0 ? null : $_POST['ssh_username'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET ssh_password = ?  WHERE id = ?", "si", array(strcmp($_POST['ssh_password'], "")==0 ? null : $_POST['ssh_password'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET terminal_port = ?  WHERE id = ?", "si", array($_POST['terminal_port'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET terminal_backend_path = ?  WHERE id = ?", "si", array(strcmp($_POST['terminal_backend_path'], "")==0 ? null : $_POST['terminal_backend_path'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET terminal_instance_path = ?  WHERE id = ?", "si", array(strcmp($_POST['terminal_instance_path'], "")==0 ? null : $_POST['terminal_instance_path'], $_SESSION['user']['id'])) === false) err(4);
                            else if(exec_query($db, "UPDATE users SET webserver_home_directory = ?  WHERE id = ?", "si", array(strcmp($_POST['webserver_home_directory'], "")==0 ? null : $_POST['webserver_home_directory'], $_SESSION['user']['id'])) === false) err(4);
                            if(isset($_POST['get_network_information']) && strcmp($_POST['get_network_information'], "on") == 0){
                                if(exec_query($db, "UPDATE users SET get_network_information = ?  WHERE id = ?", "si", array('on', $_SESSION['user']['id'])) === false) err(4);
                            }
                            else{
                                if(exec_query($db, "UPDATE users SET get_network_information = null  WHERE id = ?", "i", array($_SESSION['user']['id'])) === false) err(4);
                            }
                            $array = exec_query_catch_output($db, "SELECT * FROM users WHERE HEX(username) = HEX(?)", 's', array($_POST['username']));
                            $_SESSION['user'] = $array[0];
                            header('Location: /settings.php');
                        }
                    }
                ?>
            </form>
        </article>
    </main>
    <script type="text/javascript" src="static/js/background.js"></script>
    <script src="./static/js/script6.js"></script>
    <!-- <script src="./static/js/page_exit.js"></script> -->
</body>
</html>
