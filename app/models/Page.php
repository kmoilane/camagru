<?php

class Page
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function gallery($offset = 0, $records = 5)
	{
		if ($offset < 0)
			$offset = 0;
		$this->db->query("SELECT a.*, b.profile_pic, c.username
		FROM images a JOIN profiles b JOIN users c
		WHERE a.user_id=b.user_id AND a.user_id=c.id
		ORDER BY a.upload_datetime DESC
		LIMIT :offset, :records");

		$this->db->bind(":offset", $offset);
		$this->db->bind(":records", $records);

		return $this->db->resultSet();
	}

	public function getImageCount()
	{
		$this->db->query("SELECT * FROM images");
		return $this->db->rowCount();
	}
}

?>
