<?php

class User
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function register($data)
	{
		$this->db->query("INSERT INTO users (username, email, password, otp, active, createDatetime) VALUES
		(:username, :email, :password, :otp, :active, :createDatetime)");

		// Bind values
		$this->db->bind(":username", $data["username"]);
		$this->db->bind(":email", $data["email"]);
		$this->db->bind(":password", $data["password"]);
		$this->db->bind(":otp", $data["otp"]);
		$this->db->bind(":active", $data["active"]);
		$this->db->bind(":createDatetime", $data["createDatetime"]);

		// Execute function
		if ($this->db->execute())
			return true;
		else
			return false;
	}

	public function login($username, $loginType, $password)
	{
		if ($loginType == "email" || $loginType == "username")
		{
			$this->db = $this->findUserFromDb($loginType, $username, 1);

			$row = $this->db->single();
			$hashedPassword = $row->password;

			if (password_verify($password, $hashedPassword))
				return $row;
			else
				return false;
		}
	}

	public function verify($email, $otp)
	{
		$this->db->query("SELECT * FROM users WHERE email = :email AND otp = :otp AND active = :active");

		$this->db->bind(":email", $email);
		$this->db->bind(":otp", $otp);
		$this->db->bind(":active", '0');

		if ($this->db->rowCount() == 1)
		{
			$this->db->query("UPDATE users SET active = :active, otp = :otp WHERE email = :email");

			$this->db->bind(":email", $email);
			$this->db->bind(":otp", "");
			$this->db->bind(":active", '1');


			if ($this->db->execute())
				if ($this->initiateProfile($email))
					return true;
				else
					return false;
		}
	}

	// Creates new profile to database
	public function initiateProfile($email)
	{
		$this->db->query("INSERT INTO `profiles` (`user_id`) SELECT users.id FROM `users` WHERE users.email = :email");
		$this->db->bind(":email", $email);
		if ($this->db->execute())
			return true;
		else
			return false;

	}

	// Find user from database using username, email or id. $field is either username, email or id (field of user table) and value is the one we're going to look for (example: findUserFromDb("email", "kmoilane@gmail.com"))
	public function findUserFromDb($field, $value, $login = 0)
	{
		if ($field == "id" || $field == "email" || $field == "username")
		{
			$pdoField = ":" . $field;
			// Prepared statement
			$this->db->query("SELECT * FROM users WHERE $field = $pdoField");

			// Bind email parameter with email variable
			$this->db->bind($pdoField, $value);

			// Return prepared and binded statement if logging in
			if ($login == 1)
				return $this->db;

			// Check if email is already in db
			if ($this->db->rowCount() > 0)
				return true;
			else
				return false;
		}
	}

	// Takes data array and updates user information to database
	public function updateUser($data) {
		if (!isset($data["password"]))
			$sql = "UPDATE users SET username = :username, email = :email, emailNotifications = :notify WHERE id = :id";
		else
			$sql = "UPDATE users SET username = :username, email = :email, password = :password, emailNotifications = :notify WHERE id = :id";

		$this->db->query($sql);

		$this->db->bind(":username", $data["username"]);
		$this->db->bind(":email", $data["email"]);
		$this->db->bind(":id", $_SESSION["user_id"]);
		$this->db->bind(":notify", $data["notify"]);
		if (isset($data["password"]))
			$this->db->bind(":password", $data["password"]);

		if ($this->db->execute())
			return true;
		return false;
	}

	public function getImages($data)
	{
		$this->db->query("SELECT file_name FROM images WHERE user_id = :user_id");
		$this->db->bind(":user_id", $data["user_id"]);
		return $this->db->resultSet();
	}

	public function getProfile($data)
	{
		$this->db->query("SELECT * FROM profiles WHERE user_id = :id");
		$this->db->bind(":id", $data["user_id"]);
		return $this->db->singleArray();
	}

	public function deleteUser($data)
	{
		$this->db->query("DELETE FROM users WHERE id = :id");
		$this->db->bind(":id", $data["user_id"]);
		if ($this->db->execute())
			return true;
		return false;
	}
}
?>
