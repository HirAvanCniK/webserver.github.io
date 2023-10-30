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
        <div id="background_blurred" class="add_main_dir hidden"></div>
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
                <ul id="add_main_dir_select_icon" style="display: none"></ul>
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
                <a href="home.php" class="link active"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
            </nav>
            <nav class="navbar bottom">
                <a href="settings.php" class="link"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
            </nav>
        </div>
        <div id="navbar_phone">
            <button onclick="toggle_navbar_phone()" class="navbar_phone_button fa-solid fa-bars"></button>
            <nav class="navbar navbar_phone_disable">
                <a href="home.php" class="link active"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
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
            <div id="dashboard">
                <h1 class="title">Dashboard</h1>
            </div>
        </article>
    </main>
    <script type="text/javascript" src="static/js/background.js"></script>
    <script type="text/javascript" src="static/js/script.js"></script>
    <script type="text/javascript" src="static/js/color-picker.js"></script>
</body>
</html>
