<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="project1-style.css">
</head>
<body>

<header>
	<nav>
		<div class="main-wrapper">
			<ul>
				<li><a href="index.php">Home</a></li>
			</ul>
			<div class="navigation-login">
			<?php
				if (isset($_SESSION['user_id'])) {
					echo '<form action="logout.php" method="POST">
						<button type="submit" name="submit">Logout</button>
						</form>';
				} else {
					echo '<form action="login.php" method="POST">
						<input type="text" name="user_name" placeholder="Username/E-mail">
						<input type="password" name="user_password" placeholder="Password">
						<button type="submit" name="submit">Login</button>
						</form>
						<a href="signup-page.php">Sign up</a>';
				}
			?>
			</div>
		</div>
	</nav>	
</header>
