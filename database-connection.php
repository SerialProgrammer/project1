<?php

// Returns user to the page selected and ends the current script
function returnToPage ($return_page, $error_messege) {
	header("Location: ".$return_page."?".$error_messege);
	exit();
}

// Database connection
class DatabaseConnection {
	private $database_servername;
	private $database_username;
	private $database_password;
	private $database_name;

	protected function connect () { 
		$this->database_servername = "localhost";
		$this->database_username = "root";
		$this->database_password = "";
		$this->database_name = "project1";

		$database_connection = new mysqli($this->database_servername, $this->database_username, $this->database_password, $this->database_name = "project1");

		return $database_connection;
	}
}

// User Login class
class UserLoginClass extends DatabaseConnection { 
	// Getting data from database
	public function loginUser () { 
		// checking user input
		$user_username = mysqli_real_escape_string($this->connect(), $_POST['user_name']);
		$user_password = mysqli_real_escape_string($this->connect(), $_POST['user_password']); 
		// getting query restuls
		if (empty($user_username) || empty($user_password)) {
		returnToPage("index.php","login=error_empty_input");
		} else {
			$sql_command = "SELECT * FROM users WHERE user_username='$user_username' OR user_email='$user_username';";
			$query_result = $this->connect()->query($sql_command);
			$check_query_result = $query_result->num_rows;
			// checking if we got any query results
			if ($check_query_result < 1) {
				returnToPage("index.php","login=error");
			} else {
				// fetching data from the query result
				if ($fetch_row = $query_result->fetch_assoc()) {
					// De-hashing the password
					$check_hashed_password = password_verify($user_password, $fetch_row['user_password']);
					if ($check_hashed_password == false) {
						returnToPage("index.php","login=error");
					} elseif ($check_hashed_password == true) {
						// Logging in the user here, settiong SESSION variables
						$_SESSION['user_id'] = $fetch_row['user_id'];
						$_SESSION['user_first_name'] = $fetch_row['user_first_name'];
						$_SESSION['user_last_name'] = $fetch_row['user_last_name'];
						$_SESSION['user_email'] = $fetch_row['user_email'];
						$_SESSION['user_username'] = $fetch_row['user_username'];
						returnToPage("index.php","login=success");
					}
				}
			}
		}
	}
}

// User Sign up class
class UserSignUpClass extends DatabaseConnection {

	public function signUpUser() {

		// Error Handlers
		$user_first_name = mysqli_real_escape_string($this->connect(), $_POST['user_first_name']);
		$user_last_name = mysqli_real_escape_string($this->connect(), $_POST['user_last_name']);
		$user_email = mysqli_real_escape_string($this->connect(), $_POST['user_email']);
		$user_username = mysqli_real_escape_string($this->connect(), $_POST['user_username']);
		$user_password = mysqli_real_escape_string($this->connect(), $_POST['user_password']);
		
		// Checking for empty fields
		if (empty($user_first_name) || empty($user_last_name) || empty($user_email) || empty($user_username) || empty($user_password)) {
		returnToPage("signup-page.php","signup=empty_field");
		} else {
			// Checking for valid input characters
			if (!preg_match("/^[a-zA-Z]*$/", $user_first_name) || !preg_match("/^[a-zA-Z]*$/", $user_last_name)) {
			returnToPage("signup-page.php","signup=invalid_characters_in_input");
			} else {
				// Checking for a valid e-mail
				if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
					returnToPage("signup-page.php","signup=invalid_email");
				} else {
					// Checking if the username already exists
					$sql_command = "SELECT * FROM users WHERE user_username='$user_username';";
					$query_result = $this->connect()->query($sql_command);
					$check_query_result = $query_result->num_rows;

					if ($check_query_result > 0) {
						returnToPage("signup-page.php","signup=username_already_exists");
					} else {
						// Hashing the password
						$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
						// Insert the user into the database
						$sql_command = "INSERT INTO users (user_first_name, user_last_name, user_email, user_username, user_password) VALUES ('$user_first_name', '$user_last_name', '$user_email', '$user_username', '$hashed_password');";
						$this->connect()->query($sql_command);

						returnToPage("signup-page.php","signup=success");
					}
				}
			}
		}
	}
}
