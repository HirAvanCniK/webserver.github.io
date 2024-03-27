<?php
	ob_start();
	require_once('./includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Server</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
  <link rel="stylesheet" href="./static/css/login-register.css" />
</head>

<body class="img js-fullheight" style="
	  background-image: url('https://wallpapers-clan.com/wp-content/uploads/2023/11/view-of-space-from-desolate-planet-desktop-wallpaper-preview.jpg');
	">
  <section class="ftco-section">
	<div class="container">
	  <div class="row justify-content-center">
		<div class="col-md-6 col-lg-4">
		  <div class="login-wrap p-0">
			<h3 class="mb-4 text-center">Sign up</h3>
			<form class="signin-form" method="POST">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required />
              </div>
              <div class="form-group">
                <input id="password-field1" type="password" class="form-control" placeholder="Password" name="password"
                  required />
                <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password"></span>
              </div>
              <div class="form-group">
                <input id="password-field2" type="password" class="form-control" placeholder="Re-Password"
                  name="re_password" required />
                <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
              </div>
			  <div class="form-group">
                <input id="email-field" type="email" class="form-control" placeholder="Email"
                  name="email" required />
              </div>
              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary submit px-3">
                  Sign up
                </button>
              </div>
              <div class="form-group d-md-flex"></div>
			  <?php
				if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['re_password']) && isset($_POST['email'])){
					if(preg_match($REGEX_USERNAME, $_POST['username']) && preg_match($REGEX_PASSWORD, $_POST['password']) && preg_match($REGEX_EMAIL, $_POST['email']) && strcmp($_POST['password'], $_POST['re_password']) == 0){
						$db = connect();
						$array = exec_query_catch_output($db, "SELECT * FROM users WHERE HEX(username) = HEX(?) OR HEX(email) = (?)", 'ss', array($_POST['username'], $_POST['email']));
						if($array !== false){
							if(count($array) == 0){
								$output = exec_query($db, "INSERT INTO users (username, password, email) VALUES (?, ?, ?)", 'sss', array($_POST['username'], $_POST['password'], $_POST['email']));
								if($output !== false){
									$array = exec_query_catch_output($db, "SELECT * FROM users WHERE HEX(username) = HEX(?) AND HEX(password) = HEX(?) AND HEX(email) = HEX(?)", 'sss', array($_POST['username'], $_POST['password'], $_POST['email']));
									if($array !== false){
										session_start();
										$_SESSION['user'] = $array[0];
										header('Location: /');
									}else{
										err(4);
									}
								}else{
									err(4);
								}
							}else{
								err(3);
							}
						}else{
							err(4);
						}
					}else{
						err(1);
					}
				}
			  ?>
			</form>
			<p class="w-100 text-center">
			  <a href="login.php">&mdash; Or Sign In &mdash;</a>
			</p>
			<?php
				if(isset($_POST['err'])){
					$error = $_POST['err'];
					$code = "
<p class=\"w-100 text-center\" style=\"
	color: rgb(255, 0, 0, 0.7);
	background-color: rgb(255, 255, 255, 0.5);
	border-radius: 20px;
\">
	<b>&mdash; $error &mdash;</b>
</p>";
					echo $code;
				}
			?>
		  </div>
		</div>
	  </div>
	</div>
  </section>
  <script src="./static/js/script4.js"></script>
</body>

</html>