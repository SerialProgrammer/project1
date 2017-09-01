<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Signup</h2>
		<form class="signup-form" action="signup.php" method="POST">
			<input type="text" name="user_first_name" placeholder="First Name">
			<input type="text" name="user_last_name" placeholder="Last Name">
			<input type="text" name="user_email" placeholder="E-mail">
			<input type="text" name="user_username" placeholder="Username">
			<input type="password" name="user_password" placeholder="Password">
			<button type="submit" name="submit">Sign up</button>
		</form>
	</div>
</section>

<?php
	include_once 'footer.php';
?>