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
    <link rel="stylesheet" href="static/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
    <link href="https://fonts.cdnfonts.com/css/space-mono" rel="stylesheet">
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
                <a href="explorer.php" class="link active"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
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
                <a href="/" class="link"><i class="link_icon fa-solid fa-house-user"></i> <b class="link_text">Home</b></a>
                <a href="explorer.php" class="link active"><i class="link_icon fa-solid fa-folder"></i> <b class="link_text">Explorer</b></a>
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
            <div id="favorites_bar">
                <h1 class="title" style="text-align:center;">Favorites</h1>
                <div class="folder-tree-wrapper">
                    <ul class="folder-tree">
                        <li><i class="fa fa-folder"></i><b class="name" onclick="location.href='?path=/New Folder (0)'">New Folder (0)</b>
                            <div class="arrow"><i class="fa fa-angle-down"></i></div>
                            
                            <ul>
                                <li><i class="fa fa-folder"></i><b class="name" onclick="location.href='?path=/New Folder (0)/New Folder (0)'">New Folder (0)</b></li>
                                <li><i class="fa fa-folder"></i><b class="name" onclick="location.href='?path=/New Folder (0)/New Folder (1)'">New Folder (1)</b>
                                    <div class="arrow"><i class="fa fa-angle-down"></i></div>
                                    <ul>
                                    
                                        <li><i class="fa fa-folder"></i><b class="name" onclick="location.href='?path=/New Folder (0)/New Folder (1)/New Folder (2)'">New Folder (2)</b></li>
                                        <li><i class="fa fa-file"></i><b class="name" onclick="location.href='/editor?file=New Folder (0)/New Folder (1)/File'">File</b></li>
                                    
                                    </ul>
                                
                                </li>
                            </ul>
                            
                        </li>
                        <li><i class="fa fa-folder"></i><b class="name" onclick="location.href='?path=/New Folder (1)'">New Folder (1)</b></li>
                        <li><i class="fa fa-folder"></i><b class="name" onclick="location.href='?path=/New Folder (2)'">New Folder (2)</b></li>
                        <li><i class="fa fa-file"></i><b class="name" onclick="location.href='/editor?file=File'">File</b></li>
                    </ul>
                </div>
            </div>
            <div id="explorer">
                <form method="get" id="searchbars">
                    <div class="pathInputDiv">
                        <input type="text" name="path" id="path">
                        <input type="submit" class="fa-solid" value="">
                    </div>
                    <div class="findInputDiv">
                        <input type="text" name="find" placeholder="Search in current directory" id="find">
                        <input type="submit" class="fa-solid" value="">
                    </div>
                </form>
                <br>
                <div class="filesDiv">
                    <table id="mytable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Last edit <i class="fa-solid"></i></th>
                                <th>Type</th>
                                <th>Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr></tr>
                            <tr>
                                <td><i class="fa-solid fa-folder"></i> static</td>
                                <td>18/10/2024 08:37</td>
                                <td>Folder</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-file-text"></i> docker-compose.yml</td>
                                <td>23/01/2024 10:32</td>
                                <td>Yaml</td>
                                <td>1 KB</td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-file-text"></i> file.txt</td>
                                <td>12/02/2024 15:45</td>
                                <td>Text</td>
                                <td>500 B</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="properties">
                <h1 class="title">Properties</h1>
                <div class="filesDiv">
                    <table id="mytable2"></table>
                </div>
            </div>
        </article>
    </main>
    <script>
        $(function() {
            $('.folder-tree li').click(function(evt) {
                evt.stopPropagation();
                $(this).toggleClass('expanded');
            });
        });
    </script>
    <script type="text/javascript" src="static/js/background.js"></script>
    <script type="text/javascript" src="static/js/script2.js"></script>
</body>
</html>
