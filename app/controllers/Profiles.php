<?php

class Profiles extends Controller
{
	public function __construct()
	{
		$this->profileModel = $this->model("Profile");
	}

	public function profile()
	{
		// Let's check if GET has id, otherwise use users own session id
		$id = isset($_GET["id"]) ? $_GET["id"] : $_SESSION["user_id"];

		// Use id to get users data for it's profile
		$data = $this->profileModel->getProfileData($id);

		$this->view("profiles/profile", $data);
	}

	public function new()
	{
		$data = [
			"fileName" => "",
			"temp_name" => "",
			"title" => "",
			"fileExtension" => "",
			"finalPath" => "",
			"dateTime" => "",
			"stickerPath" => "",
			"fileError" => "",
			"titleError" => "",
			"uploadError" => ""
		];

		if (empty($_SESSION["user_id"]))
		{
			header("location: " . URLROOT . "/users/login");
			exit();
		}
		else if ($_SERVER["REQUEST_METHOD"] === "POST")
		{
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$temp_path =  "localhost/camagru/public/img/gallery/" . $_FILES["image"]["name"];

			$data = [
				"fileName" => trim($_FILES["image"]["name"]),
				"tempName" => $_FILES["image"]["tmp_name"],
				"title" => trim($_POST["title"]),
				"fileExtension" => pathinfo($temp_path, PATHINFO_EXTENSION),
				"finalPath" => "",
				"dateTime" => "",
				"stickerPath" => trim($_POST["sticker"]),
				"fileError" => "",
				"titleError" => "",
				"descriptionError" => "",
				"uploadError" => ""
			];

			// Valid file extensions for images
			$valid_extensions = array("jpg", "png", "jpeg", "gif", "bmp");

			if (empty($data["fileName"]))
				$data["fileError"] = "Please select a file";
			else if (!file_exists($data["tempName"]))
				$data["fileError"] = "File does not exist/File size over 20MB";
			else if ($_FILES["image"]["size"] <= 0)
				$data["fileError"] = "Not a proper image";
			else if (!in_array($data["fileExtension"], $valid_extensions))
				$data["fileError"] = "You can only ulpoad gif, jpg, jpeg, png and bmp image files";

			if (empty($data["title"]))
				$data["titleError"] = "Please provide title";

			if (empty($data["fileError"]) && empty($data["titleError"]))
			{
				if ($data["fileExtension"][0] == "j")
					$image = imagecreatefromjpeg($data["tempName"]);
				else if ($data["fileExtension"] == "png")
					$image = imagecreatefrompng($data["tempName"]);
				else if ($data["fileExtension"] == "gif")
					$image = imagecreatefromgif($data["tempName"]);
				else if ($data["fileExtension"] == "bmp")
					$image = imagecreatefrombmp($data["tempName"]);
				if ($data["stickerPath"] != "none")
				{
					$insert = imagecreatefrompng($data["stickerPath"]);
					$sx = imagesx($insert);
					$sy = imagesy($insert);
					imagecopymerge($image, $insert, (imagesx($image)/2)-(imagesx($insert)/2), (imagesy($image)/2)-(imagesy($insert)/2), 0, 0, $sx, $sy, 90);
				}
				$data["fileName"] = md5(generate_otp()) . $data["dateTime"] . "." . $data["fileExtension"];
				$data["finalPath"] = "C:/wamp64/www/camagru/public/img/gallery/" . $data["fileName"];
				if (imagejpeg($image, $data["finalPath"]))
				{
					imagedestroy($image);
					if ($insert)
						imagedestroy($insert);
					$data["dateTime"] = date("YmdHis");
					if ($this->profileModel->newUpload($data))
					{
						header("location:" . URLROOT . "/index");
					}
					else
						$data["uploadError"] ="Better luck next time";
				}
				else
					$data["uploadError"] ="Failed to upload image loser";
			}
		}
		$this->view("profiles/new", $data);
	}

	public function post()
	{
		$data= [];

		if (isset($_GET["id"]))
		{
			$data = $this->profileModel->getImageData($_GET["id"]);
			if (isset($data["image_id"]))
			{
				$likes = $this->profileModel->getLikes($_GET["id"]);
				$comments = $this->profileModel->getComments($_GET["id"]);

				if (isset($_POST["send"]) && isset($_POST["comment"]))
				{
					if ($this->profileModel->addComment($data, $_POST["comment"]))
					{
						header("location: " . URLROOT . "/profiles/post?id=".$_GET["id"]);
						return;
					}
				}
				$this->view("profiles/post", $data, $comments, $likes);

			}
			else
				header("location: " . URLROOT . "/");
		}

		$this->view("profiles/post", $data);
	}
}
?>
