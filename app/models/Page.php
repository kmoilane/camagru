<?php

class Page
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function gallery()
	{
		$this->db->query("SELECT a.*, b.profile_pic, c.username
		FROM images a JOIN profiles b JOIN users c
		WHERE a.user_id=b.user_id AND a.user_id=c.id
		ORDER BY a.upload_datetime DESC");
		return $this->db->resultSet();
	}

	public function getComments()
	{
		$this->db->query("SELECT * FROM comments");
		return $this->db->resultSet();
	}

	public function getLikes()
	{
		$this->db->query("SELECT * FROM likes");
		return $this->db->resultSet();
	}

	public function getImageCount()
	{
		$this->db->query("SELECT * FROM images");
		return $this->db->rowCount();
	}
}

?>
