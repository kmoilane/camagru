<?php

class Profile
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getProfileData($id)
	{
		$this->db->query("SELECT a.*, b.username, c.*
		FROM profiles a JOIN users b JOIN images c
		ON a.user_id=b.id WHERE a.user_id = :user_id");

		$this->db->bind(":user_id", $id);

		$data = $this->db->resultSet();
		if ($data)
			return $data;
	}

	public function newUpload($data)
	{
		$this->db->query("INSERT INTO images (user_id, image_title, file_name, upload_datetime) VALUES (:user_id, :title, :file_name, :upload_datetime)");

		$this->db->bind(":user_id", $_SESSION["user_id"]);
		$this->db->bind(":title", $data["title"]);
		$this->db->bind("file_name", $data["fileName"]);
		$this->db->bind(":upload_datetime", $data["dateTime"]);

		if ($this->db->execute())
			return true;
		else
			return false;
	}

	public function getImageData($imgId)
	{
		$this->db->query("SELECT a.*, b.profile_pic, c.username, c.email, c.emailNotifications
		FROM images a JOIN profiles b JOIN users c
		WHERE a.image_id=:imgId AND a.user_id=b.user_id AND a.user_id=c.id
		ORDER BY a.upload_datetime DESC");
		$this->db->bind(":imgId", $imgId);
		return $this->db->singleArray();
	}

	public function getComments($imgId)
	{
		$this->db->query("SELECT a.*, b.username FROM comments a JOIN users b WHERE image_id=:imgId AND a.sender_id=b.id");
		$this->db->bind(":imgId", $imgId);
		return $this->db->resultSet();
	}

	public function getLikes($imgId)
	{
		$this->db->query("SELECT * FROM likes WHERE image_id=:imgId");
		$this->db->bind(":imgId", $imgId);
		return $this->db->resultSet();
	}

	public function addComment($data, $comment)
	{
		$this->db->query("INSERT INTO comments (image_id, sender_id, comment) VALUES (:imgId, :senderId, :comment)");
		$this->db->bind(":imgId", $data["image_id"]);
		$this->db->bind(":senderId", $_SESSION["user_id"]);
		$this->db->bind(":comment", $comment);
		if ($this->db->execute())
			return true;
		else
			return false;
	}

	public function addLike($imgId, $likerId)
	{
		$this->db->query("INSERT INTO likes (image_id, liker_id)
		VALUES (:imgId, :likerId)");
		$this->db->bind(":imgId", $imgId);
		$this->db->bind(":likerId", $likerId);
		if ($this->db->execute())
			return true;
		else
			return false;
	}

	public function removeLike($imgId, $likerId)
	{
		$this->db->query("DELETE FROM likes WHERE image_id = :imgId AND liker_id = :likerId");
		$this->db->bind(":imgId", $imgId);
		$this->db->bind(":likerId", $likerId);
		if ($this->db->execute())
			return true;
		else
			return false;
	}

	public function deleteImage($imgId)
	{
		$this->db->query("DELETE FROM images WHERE image_id = :imgId");
		$this->db->bind(":imgId", $imgId);
		if ($this->db->execute())
			return true;
		else
			return false;
	}
}

?>
