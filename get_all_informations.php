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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Content-type" content="application/json">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File informations</title>
</head>
<body>
    <pre id="response">{"size": <?php echo rand(10,100); ?>, "author": "irvanni"}</pre>
</body>
</html>
