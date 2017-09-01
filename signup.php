<?php

if(isset($_POST['submit'])) {

	include_once 'database-connection.php';

	$signup_unit = new UserSignUpClass;

	$signup_unit->signUpUser();

} else {
	returnToPage("signup.php","");
}