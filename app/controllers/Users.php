<?php

class Users extends Controller
{
	public function __construct()
	{
		$this->userModel = $this->model("User");
	}

	public function login()
	{
		$data = [
			"username" => "",
			"password" => "",
			"usernameError" => "",
			"passwordError" => "",
			"verifyError" => ""
		];

		// Check for POST (user has clicked Login)
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				"username" => trim($_POST["username"]),
				"password" => trim($_POST["password"]),
				"usernameError" => "",
				"passwordError" => "",
				"verifyError" => ""
			];

			$loginMethod = "username";

			// Validate username
			if (empty($data["username"]))
				$data["usernameError"] = "Please enter username or email to log in";
			else if (filter_var($data["username"], FILTER_VALIDATE_EMAIL))
			{
				$loginMethod = "email";
				if (!$this->userModel->findUserFromDb("email", $data["username"]))
					$data["usernameError"] = "Email not reigstered";
			}
			else if (!$this->userModel->findUserFromDb("username", $data["username"]))
				$data["usernameError"] = "Username doesn't exist";

			// Validate password
			if (empty($data["password"]))
				$data["password"] = "Please enter password to log in";

			// Check that there's no errors
			if (empty($data["usernameError"]) && empty($data["passwordError"]))
			{
				if (!$loggedInUser = $this->userModel->login($data["username"], $loginMethod, $data["password"]))
					$data["passwordError"] = "Invalid Password";
				// Check that the user has verified email
				else if ($loggedInUser->active === '0')
					$data["verifyError"] = "Email not verified, check your inbox!";
				else if ($loggedInUser)
					$this->createUserSession($loggedInUser);
			}
		}
		else
		{
			$data = [
				"username" => "",
				"password" => "",
				"usernameError" => "",
				"passwordError" => "",
				"verifyError" => ""

			];
		}
		$this->view("users/login", $data);
	}

	public function createUserSession($user)
	{
		$_SESSION["user_id"] = $user->id;
		$_SESSION["username"] = $user->username;
		$_SESSION["email"] = $user->email;
		$_SESSION["notify"] = $user->emailNotifications;
		header("location:" . URLROOT . "/index");
	}

	public function logout()
	{
		unset($_SESSION["user_id"]);
		unset($_SESSION["username"]);
		unset($_SESSION["email"]);
		unset($_SESSION["notify"]);
		header("location:" . URLROOT . "/users/login");
	}

	public function register()
	{
		$data = [
			"username" => "",
			"email" => "",
			"password" => "",
			"confirmPassword" => "",
			"usernameError" => "",
			"emailError" => "",
			"passwordError" => "",
			"confirmPasswordError" => "",
			"createDatetime" => "",
			"otp" => "",
			"active" => "",
			"mailError" => "",
			"otpError" => ""
		];

		// Check for POST (user has clicked Continue on register site)
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Fill the data array with user registration data
			$data = [
				"username" => htmlspecialchars(stripslashes(trim($_POST["username"]))),
				"email" => htmlspecialchars(stripslashes(trim($_POST["email"]))),
				"password" => htmlspecialchars(stripslashes(trim($_POST["password"]))),
				"confirmPassword" => htmlspecialchars(stripslashes(trim($_POST["confirmPassword"]))),
				"usernameError" => "",
				"emailError" => "",
				"passwordError" => "",
				"confirmPasswordError" => "",
				"createDatetime" => date("Y-m-d H:i:s"),
				"otp" => generate_otp(),
				"active" => "0",
				"mailError" => "",
				"otpError" => ""
			];

			$nameValidation = "/^[a-zA-Z0-9]*$/";
			$passwordValidation = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/";

			// Validate username (letters/numbers/4-20 chars)
			if (empty($data["username"]))
				$data["usernameError"] = "Please enter username";
			else if (strlen($data["username"]) < 2 || strlen($data["username"] > 20))
				$data["usernameError"] = "Username must contain 2-20 characters";
			else if (!preg_match($nameValidation, $data["username"]))
				$data["usernameError"] = "Only letters and numbers allowed";
			else
				if ($this->userModel->findUserFromDb("username", $data["username"]))
					$data["usernameError"] = "Username already taken";

			// Validate email address
			if (empty($data["email"]))
				$data["emailError"] = "Please enter email address";
			else if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
				$data["emailError"] = "Given email is not valid";
			else
				if ($this->userModel->findUserFromDb("email", $data["email"]))
					$data["emailError"] = "Email already registered";

			// Validate password
			if (empty($data["password"]))
				$data["passwordError"] = "Please enter password";
			else if (strlen($data["password"]) < 8)
				$data["passwordError"] = "Password must be at least 8 characters long";
			else if (!preg_match($passwordValidation, $data["password"]))
				$data["passwordError"] = "Must contain, lower-, uppercase, numerical and special (!@#$%) character";

			// Valitade password confirmation
			if (empty($data["confirmPassword"]))
				$data["confirmPasswordError"] = "Please confirm your password";
			else
				if ($data["password"] != $data["confirmPassword"])
					$data["confirmPasswordError"] = "Passwords don't match";

			// Make sure there's no errors
			if (empty($data["usernameError"]) && empty($data["emailError"])
				&& empty($data["passwordError"]) &&
				empty($data["passwordConfirmError"]))
			{
				// Encrypt password
				$data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

				// Register user from model function
				if ($this->userModel->register($data))
				{
					// Send verification email
					$email = $data["email"];
					$otp = $data["otp"];
					$subject = "Camagru Verification Code";
					$message = "Your verification code is $otp <br><br>You can also activate your account by clicking the link below:<br>
					<a href='127.0.01/camagru/users/verify?email=$email&otp=$otp'>Activate Account</a>";
					$headers = "Content-Type: text/html; charset=UTF-8\r\n";
					$headers .= 'From: Camagru <admin@kmoilane.me>' . "\r\n";
					if (mail($data["email"], $subject, $message, $headers))
					{
						// Redirect to verification page
						$_SESSION["email"] = $email;
						header("location: " .URLROOT . "/users/verify?email=" . $email);
					}
					else
					{
						$data["mailError"] = "Failed to send verification code!";
					}
				}
				else
					die ("Oops, Something went wrong...");
			}

		}

		$this->view("users/register", $data);
	}

	public function verify()
	{
		$data = [
			"email" => "",
			"otp" => "",
			"otpError" => ""
		];
		// Check GET
		if (isset($_GET["email"]) && isset($_GET["otp"]))
		{
			$data = [
				"email" => trim($_GET["email"]),
				"otp" => trim($_GET["otp"]),
				"otpError" => ""
			];
			if ($this->userModel->verify($data["email"], $data["otp"]))
			{
				unset($_SESSION["email"]);
				header("location: " . URLROOT . "/users/login");
			}
			else
				$data["otpError"] = "Failed to activate account";
		}
		// Check POST
		if (isset($_POST["verify"]))
		{
			$data = [
				"email" => trim($_SESSION["email"]),
				"otp" => trim($_POST["otp"]),
				"otpError" => ""
			];
			if ($this->userModel->verify($data["email"], $data["otp"]))
			{
				unset($_SESSION["email"]);
				header("location: " . URLROOT . "/users/login");
			}
			else
				$data["otpError"] = "Failed to activate account";
		}

		$this->view("users/verify", $data);
	}

	public function settings() {
		$data = [
			"username" => "",
			"email" => "",
			"password" => "",
			"confirmPassword" => "",
			"notify" => "1",
			"usernameError" => "",
			"emailError" => "",
			"passwordError" => "",
			"success" => "",
		];

		if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save"]))
		{

			// Validate new username
			if (isset($_POST["name"]) && $_POST["name"] !== $_SESSION["username"])
			{
				$data["username"] = htmlspecialchars(stripslashes(trim($_POST["name"])));
				$data["usernameError"] = validateUsername($data, $this);
			}
			else
				$data["username"] = $_SESSION["username"];

			// Validate new email
			if (isset($_POST["email"]) && $_POST["email"] !== $_SESSION["email"])
			{
				$data["email"] = htmlspecialchars(stripslashes(trim($_POST["email"])));
				$data["emailError"] = validateEmail($data, $this);
			}
			else
				$data["email"] = $_SESSION["email"];

			// Validate new passwords if set
			if (isset($_POST["password"]) && !empty($_POST["password"]))
			{
				$data["password"] = htmlspecialchars(stripslashes(trim($_POST["password"])));
				$data["confirmPassword"] = htmlspecialchars(stripslashes(trim($_POST["confirmPassword"])));

				$data["passwordError"] = validatePasswords($data);
			}
			else
				unset($data["password"]);

			// See if email notification checkbox is checked
			if (empty($_POST["notify"]))
				$data["notify"] = 0;

			// Check that there is no errors
			if (empty($data["usernameError"]) && empty($data["emailError"])
				&& empty($data["passwordError"]))
			{
				// Encrypt password
				if (isset($data["password"]))
					$data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

				// Update user information
				if ($this->userModel->updateUser($data))
				{
					$_SESSION["username"] = $data["username"];
					$_SESSION["email"] = $data["email"];
					$_SESSION["notify"] = $data["notify"];
					$_SESSION["success"] = "User Credentials Updated!";
					header("location: ". URLROOT . "/users/settings");
					return;
				}

			}
			else
				$this->view("users/settings", $data);
		}
		if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete"]))
		{
			header("location: " . URLROOT . "/users/delete");
			return;
		}
		$this->view("users/settings", $data);
	}

	public function delete()
	{
		$data = [
			"user_id" => $_SESSION["user_id"],
			"password" => "",
			"confirmPassword" => "",
			"passwordError" => "",
		];

		if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cancel"]))
		{
			header("location: " . URLROOT . "/users/settings");
			return;
		}

		if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete"]))
		{
			$data["password"] = htmlspecialchars(stripslashes(trim($_POST["password"])));
			$data["confirmPassword"] = $data["password"];
			$data["passwordError"] = validatePasswords($data);
			if (empty($data["passwordError"]))
			{
				// Remove users images from server
				$images = $this->userModel->getImages($data);
				foreach ($images as $image)
				{
					unlink(ABSOLUTE . "gallery/" .$image->file_name);
				}

				/*
				** Remove users profile pictures from server if they're not the
				** default ones
				*/
				$profile = $this->userModel->getProfile($data);
				if ($profile["profile_pic"] !== "default_profile_picture.jpg")
					unlink(ABSOLUTE . "profile/" . $profile["profile_pic"]);
				if ($profile["cover_pic"] !== "default_cover_picture.jpg")
					unlink(ABSOLUTE . "profile/" . $profile["cover_pic"]);

				if ($this->userModel->deleteUser($data))
				{
					$_SESSION["message"] = "User deleted successfully!";
					$this->logout();
				}
			}
			$this->view("users/delete", $data);
		}
		$this->view("users/delete", $data);
	}

	public function recover_password()
	{
		$data = [
			"email" => "",
			"emailError" => "",
			"mailError" => "",
			"otp" => ""
		];

		if (isset($_POST["recover"]))
		{
			$data["email"] =  htmlspecialchars(stripslashes(trim($_POST["email"])));
			$data["emailError"] = validateEmail($data, $this);
			if ($data["emailError"] === "Email already registered")
				$data["emailError"] = "";
			if ($data["emailError"] == "")
			{
				if ($this->userModel->findUserFromDb("email", $data["email"]))
				{
					$data["otp"] = generate_otp();

					// Send verification email
					$email = $data["email"];
					$otp = $data["otp"];
					$subject = "Camagru Verification Code";
					$message = "Your password recovery code is:<br> $otp <br>";
					$headers = "Content-Type: text/html; charset=UTF-8\r\n";
					$headers .= 'From: Camagru <admin@kmoilane.me>' . "\r\n";
					if (mail($email, $subject, $message, $headers))
					{
						$this->userModel->setOtp($data);

						// Redirect to verification page
						$_SESSION["email"] = $email;
						header("location: " .URLROOT . "/users/verify_password_recovery");
					}
					else
					{
						$data["mailError"] = "Failed to send verification code!";
					}
				}
				else
					$data["emailError"] = "Unknown error";

			}
			else
			{
				$data["emailError"] = validateEmail($data, $this);
				$this->view("users/recover_password", $data);
			}
			$this->view("users/verify_password_recovery", $data);
		}
		$this->view("users/recover_password", $data);
	}

	public function verify_password_recovery()
	{
		$data = [
			"otp" => "",
			"email" => "",
			"otpError" => ""
		];

		// Check POST
		if (isset($_POST["recover"]))
		{
			if (isset($_POST["otp"]))
			{
				$data = [
					"email" => trim($_SESSION["email"]),
					"otp" => trim($_POST["otp"]),
					"otpError" => ""
				];
				if ($this->userModel->verifyRecovery($data["email"], $data["otp"]))
				{
					$_SESSION["passRecovery"] = "1";
					header("location: " . URLROOT . "/users/set_new_password");
				}
				else
					$data["otpError"] = "Wrong Verification Code!";
			}
			else
				$data["otpError"] = "Please enter your verification code!";
		}
		$this->view("users/verify_password_recovery", $data);
	}

	public function set_new_password()
	{
		$data = [
			"password" => "",
			"passwordError" => "",
			"confirmPassword" => ""
		];
		// Check POST
		if (isset($_POST["change"]))
		{
			// Validate new passwords if set
			if (isset($_POST["password"]) && !empty($_POST["password"]))
			{
				$data["password"] = htmlspecialchars(stripslashes(trim($_POST["password"])));
				$data["confirmPassword"] = htmlspecialchars(stripslashes(trim($_POST["confirmPassword"])));

				$data["passwordError"] = validatePasswords($data);

				if (empty($data["passwordError"]))
				{
					// Encrypt password
					if (isset($data["password"]))
						$data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

					// Change users password
					if ($this->userModel->changePassword($data))
					{
						unset($_SESSION["email"]);
						unset($_SESSION["passRecovery"]);
						$_SESSION["message"] = "Password has been changed!";
						header("location: " . URLROOT . "/users/login");
					}
				}
				else
					$this->view("users/set_new_password", $data);
			}
			else
				$this->view("users/set_new_password", $data);
		}
		$this->view("users/set_new_password", $data);
	}
}

?>
