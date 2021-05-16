<?php

function validateUsername($data, $userController)
{
	$nameValidation = "/^[a-zA-Z0-9]*$/";

	// Validate username (letters/numbers/4-20 chars)
	if (empty($data["username"]))
		return "Please enter username";
	else if (strlen($data["username"]) < 2 || strlen($data["username"] > 20))
		return "Username must contain 2-20 characters";
	else if (!preg_match($nameValidation, $data["username"]))
		return "Only letters and numbers allowed";
	else
		if ($userController->userModel->findUserFromDb("username", $data["username"]))
			return "Username already taken";
}

function validateEmail($data, $userController)
{
	// Validate email address
	if (empty($data["email"]))
		return "Please enter email address";
	else if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
		return "Given email is not valid";
	else
		if ($userController->userModel->findUserFromDb("email", $data["email"]))
			return "Email already registered";
}

function validatePasswords($data)
{
	$passwordValidation = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/";
	// Validate password
	if (empty($data["password"]))
		return "Please enter password";
	else if (strlen($data["password"]) < 8)
		return "Password must be at least 8 characters long";
	else if (!preg_match($passwordValidation, $data["password"]))
		return "Must contain, lower-, uppercase, numerical and special (!@#$%) character";

	// Valitade password confirmation
	if (empty($data["confirmPassword"]))
		return "Please confirm your password";
	else
		if ($data["password"] != $data["confirmPassword"])
			return "Passwords don't match";
}


?>
