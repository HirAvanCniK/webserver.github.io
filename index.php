<?php
	ob_start();
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: /login.php');
    }
    require_once('./includes/config.php');
    if(!ssh_access()){
        header('Location: /settings.php');
    }
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
    <?php
        $ssh = ssh_connect();
        $home_directory = $_SESSION['user']['webserver_home_directory'];
        if(!$ssh){
            $ssh_server = $_SESSION['user']['server'];
            $ssh_port = $_SESSION['user']['ssh_port'];
            echo "<script type='text/javascript'>alert(`Couldn't connect to server '$ssh_server' on port '$ssh_port'`)</script>";
            $services = array();
            $main_directories = array();
        }else{
            ssh_exec($ssh, "cd $home_directory");
        }
    ?>
</head>
<body id="bg">
    <canvas class="bg"></canvas>
    <canvas class="bg"></canvas>
    <canvas class="bg"></canvas>
    <main>
        <div id="background_blurred" class="all hidden"></div>
        <div id="background_blurred" class="secondary hidden"></div>
        <form method="POST" id="add_main_dir" class="hidden">
            <i class="fa-solid fa-circle-xmark close" onclick="add_main_dir()"></i>
            <br><br>
            <h1 class="title">Add Main Dir</h1>
            <br>
            <label for="" class="add_main_dir_label">Choose a color</label>
            <br><br>
            <div id="colorpicker">
                <img style="display:none;" id="colorpickerimage" src="static/img/ColorPicker.jpeg">
                <canvas id="canvascolorpicker" width="225"></canvas>
                <label for="rgb">RGB</label>
                <input type="text" name="new_main_dir_rgbcolor" id="rgbinput" oninput="changeRGBcolor()">
                <br>
                <label for="hex">HEX</label>
                <input type="text" name="new_main_dir_hexcolor" id="hexinput" oninput="changeHEXcolor()">
            </div>
            <br><br>
            <label for="" class="add_main_dir_label">Choose an icon</label>
            <br><br>
            <div id="select_icon">
                <input type="text" class="hidden" id="icon" name="new_main_dir_icon">
                <b class="visible_icon" onclick="toggle_select_menu_icon()">Select Icon</b>
                <br>
                <ul id="add_main_dir_select_icon" style="display: none">
                    <li>
                        <input type="text" placeholder="Search Icon" class="search_icon" oninput="search_icon()">
                    </li>
                </ul>
            </div>
            <br><br>
            <label for="" class="add_main_dir_label">Choose a name</label>
            <br><br>
            <input type="text" name="new_main_dir_name" id="main_dir_name">
            <br><br>
            <button type="submit" id="btn-create-main-dir">Create a Main Directory</button>
            <?php
                if(isset($_POST['new_main_dir_hexcolor']) && isset($_POST['new_main_dir_icon']) && isset($_POST['new_main_dir_name'])){
                    $db = connect();
                    exec_query($db, "INSERT INTO main_directories (username, main_path, color, icon) VALUES (?, ?, ?, ?)", "ssss", array($_SESSION['user']['username'], $home_directory.$_POST['new_main_dir_name'], $_POST['new_main_dir_hexcolor'], $_POST['new_main_dir_icon']));
                    ssh_exec($ssh, "mkdir $home_directory".$_POST['new_main_dir_name']);
                }
            ?>
        </form>
        <div id="navbar_pc">
            <nav class="navbar top">
                <a href="/" class="link active"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
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
                <a href="/" class="link active"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
                <div class="bottom">
                    <a href="settings.php" class="link"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                    <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
                </div>
            </nav>
        </div>
        <article>
            <div id="main_directories">
                <h1 class="title">Main directories</h1>
                <div>
                    <?php
                        $db = connect();
                        $array = exec_query_catch_output($db, "SELECT * FROM main_directories WHERE HEX(username) = HEX(?)", "s", array($_SESSION['user']['username']));
                        if($array){
                            foreach($array as $row){
                                $path = $row['main_path'];
                                $color = $row['color'];
                                $icon = $row['icon'];
                                $name = basename($path);
                                $numberOfElements = intval(ssh_exec_catch_output($ssh, "ls -l $path | wc -l"))-1;
                                $size = explode("\t", ssh_exec_catch_output($ssh, "du -sh $path"))[0] . "B";
                                echo "<div class='main_dir' style='box-shadow: 0 0 10px 1px $color;' onclick='location.href=`explorer.php?path=$path`'>";
                                echo    "<i class='main_dir_icon fa-solid $icon' style='color: $color;'></i>";
                                echo    "<b>";
                                echo        "<i class='main_dir_title'>$name</i>";
                                echo        "<br><br>";
                                echo        "<i class='main_dir_elements'>$numberOfElements Elements</i>";
                                echo        "\t•\t";
                                echo        "<i class='main_dir_weight'>$size</i>";
                                echo    "</b>";
                                echo    "<hr style='border-top: 2px solid $color;'>";
                                echo "</div>";
                            }
                        }
                    ?>
                    <!-- <div class="main_dir" style="box-shadow: 0 0 10px 1px goldenrod;" onclick="location.href='explorer.php?path=/Photos/'">
                        <i class="main_dir_icon fa-solid fa-photo-film" style="color: goldenrod;"></i>
                        <b>
                            <i class="main_dir_title">Photos</i>
                            <br><br>
                            <i class="main_dir_elements">16 Elements</i>
                            •
                            <i class="main_dir_weight">2GB</i>
                        </b>
                        <hr style="border-top: 2px solid goldenrod;">
                    </div>
                    <div class="main_dir" style="box-shadow: 0 0 10px 1px springgreen;" onclick="location.href='explorer.php?path=/Games/'">
                        <i class="main_dir_icon fa-solid fa-gamepad" style="color: springgreen;"></i>
                        <b>
                            <i class="main_dir_title">Games</i>
                            <br><br>
                            <i class="main_dir_elements">5 Elements</i>
                            •
                            <i class="main_dir_weight">11GB</i>
                        </b>
                        <hr style="border-top: 2px solid springgreen;">
                    </div> -->
                    <div class="main_dir" style="box-shadow: 0 0 10px 1px white;" onclick="add_main_dir()">
                        <i class="fa-solid fa-plus add-icon" style="color:white;"></i>
                    </div>
                </div>
            </div>
            <div id="services">
                <h1 class="title">Services status</h1>
                <div id="services2">
                    <?php
                        $output = base64_encode(ssh_exec_catch_output($ssh, "systemctl list-units --type=service"));
                        $services = json_decode(str_replace("'", '"', exec("$PYTHON get_all_services.py $output")), true);
                        foreach($services as $name => $arr){
                            $state = $arr['sub'];
                            $description = $arr['description'];
                            echo '<div class="service">';
                            echo    '<b class="status_on_off"></b>';
                            echo    "<h3 class='serviceName'>$name</h3>";
                            echo    "<ul>";
                            echo        "<li>Status <b class='status_on_off_text'>$state</b></li>";
                            echo        "<li>Description <b class='description'>$description</b></li>";
                            echo    "</ul>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
            <div id="dashboard">
                <h1 class="title">Dashboard</h1>
                <div id="memory">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                        <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                        <circle cx="16" cy="16" r="15.9155" class="progress-bar__progress js-progress-bar"/>
                    </svg>
                    <div class="memory_occuped">
                        <h1><i>13</i>GB/<i>160</i>GB</h1>
                        <h1><i id="mem_percent_used">8</i>%/<i>100</i>%</h1>
                    </div>
                </div>
                <div class="db_element cpu">
                    <h2>CPU</h2>
                    <ul>
                        <li>Temperature <b><?php echo trim(ssh_exec_catch_output($ssh, "sensors | grep Core | awk -F' ' '{print $3}' | awk '{sum += $1; count++} END {print sum / count}'")) ?></b>°C</li>
                        <li>Speed <b><?php echo trim(ssh_exec_catch_output($ssh, "grep -m 1 \"cpu MHz\" /proc/cpuinfo | awk '{print $4}'")) ?></b> MHz</li>
                        <li>Usage <b><?php echo trim(ssh_exec_catch_output($ssh, "top -b -n 1 | tail -n +8 | awk -F' ' '{print $9}' | awk '{sum += $1} END {print sum}'")) ?></b>%</li>
                    </ul>
                </div>
                <div class="db_element ram">
                    <h2>RAM</h2>
                    <ul>
                        <li>Maximum <b><?php echo trim(ssh_exec_catch_output($ssh, "free -h | tail -n +2 | head -n 1 | awk -F' ' '{print $2}'")) ?></b></li>
                        <li>Usage <b><?php echo trim(ssh_exec_catch_output($ssh, "top -b -n 1 | tail -n +8 | awk -F' ' '{print $10}' | awk '{sum += $1} END {print sum}'")) ?></b>%</li>
                    </ul>
                </div>
                <div class="db_element connection">
                    <?php
                        if($_SESSION['user']['get_network_information'] != null && strcmp($_SESSION['user']['get_network_information'], "on") == 0){
                            $network = explode("\n", ssh_exec_catch_output($ssh, "speedtest-cli --simple"));
                            $network_ping = explode(" ", $network[0]);
                            $network_download = explode(" ", $network[1]);
                            $network_upload = explode(" ", $network[2]);
                        }else{
                            $network_ping = array("", "N/A", "");
                            $network_download = array("", "N/A", "");
                            $network_upload = array("", "N/A", "");
                        }
                    ?>
                    <h2>Network</h2>
                    <ul>
                        <li>Ping <b><?php echo $network_ping[1] ?></b> <?php echo $network_ping[2] ?></li>
                        <li>Download <b><?php echo $network_download[1] ?></b> <?php echo $network_download[2] ?></li>
                        <li>Upload <b><?php echo $network_upload[1] ?></b> <?php echo $network_upload[2] ?></li>
                    </ul>
                </div>
            </div>
        </article>
    </main>
    <script type="text/javascript" src="static/js/background.js"></script>
    <script type="text/javascript" src="static/js/script1.js"></script>
    <script type="text/javascript" src="static/js/color-picker.js"></script>
    <script>
        $(function() {
            var selectmenu = document.getElementById("add_main_dir_select_icon");
            fetch("all-icons.php")
                .then((response) => response.text())
                .then((content) => {
                    const icons = content.split("<br>");
                    icons.pop();
                    icons.forEach((icon) => {
                        var option = document.createElement("li");
                        option.className = "select_icon";
                        var ic = document.createElement("i");
                        ic.classList.add("fa-solid");
                        var icon_name = icon.split("/")[icon.split("/").length - 1].split(".")[0];
                        ic.classList.add("fa-"+icon_name);
                        option.appendChild(ic);
                        var span = document.createElement("span");
                        span.textContent = stringTransform(icon_name);
                        option.appendChild(span);
                        selectmenu.appendChild(option);
                    });
                });
        });
    </script>
</body>
</html>
