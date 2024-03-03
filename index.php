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
                <div class="main_dir" style="box-shadow: 0 0 10px 1px goldenrod;" onclick="location.href='explorer.php?path=/Photos/'">
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
                </div>
                <div class="main_dir" style="box-shadow: 0 0 10px 1px white;" onclick="add_main_dir()">
                    <i class="fa-solid fa-plus add-icon" style="color:white;"></i>
                </div>
            </div>
            <div id="services">
                <h1 class="title">Services status</h1>
                <div class="service">
                    <b class="status_on_off"></b>
                    <h3 class="serviceName">Apache2</h3>
                    <ul>
                        <li>Status <b class="status_on_off_text">Online</b></li>
                        <li>Version <b>1.0.4</b></li>
                        <li>Port(s) <b>7010</b></li>
                    </ul>
                </div>
                <div class="service">
                    <b class="status_on_off"></b>
                    <h3 class="serviceName">MySQL</h3>
                    <ul>
                        <li>Status <b class="status_on_off_text">Offline</b></li>
                        <li>Version <b>2.0.8</b></li>
                        <li>Port(s) <b>8185</b></li>
                    </ul>
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
                        <li>Temperature <b>67</b>°C</li>
                        <li>Speed <b>4</b>GHz</li>
                        <li>Usage <b>7</b>%</li>
                    </ul>
                </div>
                <div class="db_element ram">
                    <h2>RAM</h2>
                    <ul>
                        <li>Speed <b>2</b>GHz</li>
                        <li>Usage <b>12</b>%</li>
                    </ul>
                </div>
                <div class="db_element connection">
                    <h2>Network</h2>
                    <ul>
                        <li>Download <b>20</b>MB</li>
                        <li>Upload <b>5</b>MB</li>
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
