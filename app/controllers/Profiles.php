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

	public function new_upload()
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
			"stickerError" => "",
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

			$temp_path = "localhost/camagru/public/img/gallery/" . $_FILES["image"]["name"];

			$data = [
				"fileName" => trim($_FILES["image"]["name"]),
				"tempName" => $_FILES["image"]["tmp_name"],
				"title" => trim($_POST["title"]),
				"fileExtension" => pathinfo($temp_path, PATHINFO_EXTENSION),
				"finalPath" => "",
				"dateTime" => date("YmdHis"),
				"stickerPath" => "none",
				"fileError" => "",
				"titleError" => "",
				"stickerError" => "",
				"uploadError" => ""
			];

			// Validate and assign potential error messages
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

			if (isset($_POST["sticker"]))
				$data["stickerPath"] = trim($_POST["sticker"]);

			// If there's no errors, create new image that will be copied to server
			if (empty($data["fileError"]) && empty($data["titleError"]) && empty($data["stickerError"]))
			{
				if ($data["fileExtension"][0] == "j")
					$image = imagecreatefromjpeg($data["tempName"]);
				else if ($data["fileExtension"] == "png")
				{
					$image = imagecreatefrompng($data["tempName"]);
					imagealphablending($image, false);
					imagesavealpha($image, true);
				}
				else if ($data["fileExtension"] == "bmp")
					$image = imagecreatefrombmp($data["tempName"]);


				if ($data["stickerPath"] !== "none" && $data["fileExtension"] !== "gif")
				{
					$insert = imagecreatefrompng($data["stickerPath"]);
					$sx = imagesx($insert);
					$sy = imagesy($insert);
					imagecopymerge($image, $insert, (imagesx($image)/2) - ($sx/2), (imagesy($image) - $sy), 0, 0, $sx, $sy, 90);
				}


				$data["fileName"] = md5(generate_otp()) . $data["dateTime"] . "." . $data["fileExtension"];
				$data["finalPath"] = "C:/wamp64/www/camagru/public/img/gallery/" . $data["fileName"];

				if ($data["fileExtension"][0] == "j")
					$finalResult = imagejpeg($image, $data["finalPath"]);
				else if ($data["fileExtension"] == "png")
					$finalResult = imagepng($image, $data["finalPath"]);
				else if ($data["fileExtension"] == "gif")
					$finalResult = move_uploaded_file($data["tempName"], $data["finalPath"]);
				else if ($data["fileExtension"] == "bmp")
					$finalResult = imagebmp($image, $data["finalPath"]);

				if ($finalResult)
				{
					if ($image)
					{
						imagedestroy($image);
						if ($data["stickerPath"] !== "none")
							imagedestroy($insert);
					}
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
		$this->view("profiles/new_upload", $data);
	}


	public function new_capture()
	{
		$data = [
			"stickerError" => "",
			"fileError" => "",
			"titleError" => "",
			"uploadError" => ""
		];

		if (empty($_SESSION["user_id"]))
		{
			header("location: " . URLROOT . "/users/login");
			exit();
		}
		
		if (isset($_POST["submit"]))
		{
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				"img" => $_POST["image_data"],
				"fileName" => "",
				"fileData" => "",
				"title" => trim($_POST["title"]),
				"fileExtension" => "png",
				"finalPath" => "",
				"dateTime" => date("YmdHis"),
				"stickerPath" => "none",
				"titleError" => "",
				"stickerError" => "",
				"uploadError" => ""
			];

			if (empty($data["title"]))
				$data["titleError"] = "Please provide title";

			if (isset($_POST["sticker"]))
				$data["stickerPath"] = trim($_POST["sticker"]);

			$data["img"] = str_replace('data:image/png;base64,', '', $data["img"]);
			$data["img"] = str_replace(' ', '+', $data["img"]);
			$data["fileData"] = base64_decode($data["img"]);

			if (empty($data["titleError"]) && empty($data["stickerError"]))
			{

				$data["fileName"] = md5(generate_otp()) . $data["dateTime"] . "." . $data["fileExtension"];
				$data["finalPath"] = "C:/wamp64/www/camagru/public/img/gallery/" . $data["fileName"];

				if (file_put_contents($data["finalPath"], $data["fileData"]))
				{
					$max_dim = 640;
					list($width, $height, $type, $attr) = getimagesize($data["fileData"]);
					if ($width > $max_dim || $height > $max_dim)
					{
						$targetImg = $data["imageData"];
						$ratio = $width / $height;
						if ($ratio > 1)
						{
							$new_width = $max_dim;
							$new_height = $max_dim / $ratio;
						}
						else
						{
							$new_width = $max_dim * $ratio;
							$new_height = $max_dim;
						}
						$src = imagecreatefrompng($data["finalPath"]);
						$image = imagecreatetruecolor($new_width, $new_height);
						imagecopyresampled($image, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						imagedestroy($src);
					}
					else
					{
						$image = imagecreatefrompng($data["finalPath"]);
					}

					if ($data["stickerPath"] !== "none" && $data["fileExtension"] !== "gif")
					{
						$insert = imagecreatefrompng($data["stickerPath"]);
						$sx = imagesx($insert);
						$sy = imagesy($insert);
						imagecopymerge($image, $insert, (imagesx($image)/2) - ($sx/2), (imagesy($image) - $sy), 0, 0, $sx, $sy, 100);
					}

					if (imagepng($image, $data["finalPath"]))
					{
						imagedestroy($image);
						if ($data["stickerPath"] !== "none")
							imagedestroy($insert);
						if ($this->profileModel->newUpload($data))
						{
							header("location:" . URLROOT . "/index");
						}
						else
							$data["uploadError"] ="Better luck next time";
					}
				}
			}
		}
		$this->view("profiles/new_capture", $data);
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
						if ($data["emailNotifications"] == '1')
						{
							// Send notification email
							$email = $data["email"];
							$username = $data["username"];
							$subject = "New Comment!";
							$message = "Hey $username! You have new comment one one of your posts!";
							$headers = "Content-Type: text/html; charset=UTF-8\r\n";
							$headers .= 'From: Camagru <admin@kmoilane.me>' . "\r\n";

							mail($email, $subject, $message, $headers);
						}
						header("location: " . URLROOT . "/profiles/post?id=".$_GET["id"]);
						return;
					}
				}

				if (isset($_POST["likeBtn_x"]))
				{
					if ($this->profileModel->addLike($_GET["id"], $_SESSION["user_id"]))
					{
						header("location: " . URLROOT . "/profiles/post?id=".$_GET["id"]);
						return;
					}
					else
						$this->view("profiles/post", $data, $comments, $likes);
				}

				if (isset($_POST["unlikeBtn_x"]))
				{
					if ($this->profileModel->removeLike($_GET["id"], $_SESSION["user_id"]))
					{
						header("location: " . URLROOT . "/profiles/post?id=".$_GET["id"]);
						return;
					}
					else
						$this->view("profiles/post", $data, $comments, $likes);
				}

				if (isset($_POST["delete_x"]))
				{
					$name = $this->profileModel->deleteImage($_GET["id"]);
					if ($name)
					{
						$imgPath = "C:\\wamp64\\www\\camagru\\public\\img\\gallery\\".$name->file_name;
						$deleted = unlink($imgPath);
						if ($deleted)
						{
							$_SESSION["message"] = "Image removed successfully!";
							header("location: " . URLROOT . "/");
							return;
						}
					}
				}

				$this->view("profiles/post", $data, $comments, $likes);
			}
			else
				header("location: " . URLROOT . "/");
		}

		$this->view("profiles/post", $data);
	}

	public function new()
	{
		$data = [];
		$this->view("profiles/new", $data);
	}

}
?>
