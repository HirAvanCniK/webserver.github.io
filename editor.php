<?php
	ob_start();
    session_start();
    require_once('./includes/config.php');
    if(!isset($_SESSION['user'])){
        header('Location: /login.php');
    }
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.46.0/min/vs/editor/editor.main.js" integrity="sha512-NWwYS96/xFIveKsE3xEB9PKQfNmjW3luEoIfZxiap7ol7LBiYduUNbs0OovQGDlb8gk6/z+TdqJjrqo/ufcuUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.46.0/min/vs/editor/editor.main.min.css" integrity="sha512-Q/ZIaWsdJBTBAkGTDqXN6AhYSD7+QEa+ccWJLsFTbayZWiv+Vi/BUGfm8E/4k/AV9Wvpci22/QSl56214Mv5NQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.46.0/min/vs/loader.min.js" integrity="sha512-ZG31AN9z/CQD1YDDAK4RUAvogwbJHv6bHrumrnMLzdCrVu4HeAqrUX7Jsal/cbUwXGfaMUNmQU04tQ8XXl5Znw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./static/js/page_exit.js"></script>
</head>
<body id="bg">
    <canvas class="bg"></canvas>
    <canvas class="bg"></canvas>
    <canvas class="bg"></canvas>
    <main>
        <div id="background_blurred" class="all hidden"></div>
        <div id="background_blurred" class="secondary hidden"></div>
        <div id="insertFileName" class="close">
            <h3>Enter the name of the file</h3>
            <input type="text">
            <div class="responses">
                <button onclick="toggleEditorFilename()">Cancel</button>
                <button onclick="">Save</button>
            </div>
        </div>
        <div id="navbar_pc">
            <nav class="navbar top">
                <a href="/" class="link"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
                <a href="upload.php" class="link"><i class="link_icon fa-solid fa-file-arrow-up"></i> <b class="link_text">Upload files</b></a>
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link active"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
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
                <a href="terminal.php" class="link"><i class="link_icon fa-solid fa-terminal"></i> <b class="link_text">Terminal</b></a>
                <a href="editor.php" class="link active"><i class="fa-solid fa-file-pen"></i> <b class="link_text">Editor</b></a>
                <div class="bottom">
                    <a href="settings.php" class="link"><i class="link_icon fa-solid fa-gear"></i> <b class="link_text">Settings</b></a>
                    <a href="logout.php" class="link"><i class="link_icon fa-solid fa-right-from-bracket"></i> <b class="link_text">Logout</b></a>
                </div>
            </nav>
        </div>
        <article class="editor">
            <div id="editor_navbar">
                <div id="filename"></div>
                <select id="languages" onchange="changeLanguage(this)">
                    <option>PLAINTEXT</option>
                </select>
                <button class="editor_navbar_btn" onclick="save()">Save</button>
                <button class="editor_navbar_btn" onclick="saveAs()">Save as</button>
            </div>
            <div id="editor">
            </div>
        </article>
    </main>
    <script type="text/javascript" src="static/js/background.js"></script>
    <script type="text/javascript" src="static/js/script5.js"></script>
</body>
</html>
