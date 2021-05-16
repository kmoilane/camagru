<?php
/*
class Setup
{
	private $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function setupDb()
	{
		// Create `camagru` database if it doesn't exist
		$this->db->query("CREATE DATABASE IF NOT EXISTS `$this->dbName`");

		// Create `users` table if it doesn't exist
		$this->db->query("CREATE TABLE IF NOT EXISTS `$this->dbName`.`users`
		( `id` INT(11) NOT NULL AUTO_INCREMENT ,
		`username` VARCHAR(20) NOT NULL ,
		`email` VARCHAR(50) NOT NULL ,
		`password` VARCHAR(100) NOT NULL ,
		`avatar` VARCHAR(100) NOT NULL ,
		`otp` VARCHAR(10) NOT NULL ,
		`active` TINYINT NOT NULL,
		`create_datetime` DATETIME NOT NULL ,
		PRIMARY KEY (`id`)) ENGINE=InnoDB; ");
	}
}*/
?>
