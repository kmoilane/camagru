<?php
	if (!isset($_SESSION["user_id"]))
		header("location: " . URLROOT . "/users/login");
?>
<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
	require APPROOT . "/views/includes/navigation.php";
?>

<div class="container">
	<div class="section-profile">
		<div class="profile-cover glow">
			<img src="<?php echo IMGROOT . "/cover/" . $data[0]->cover_pic ?>" alt="Cover picture">
		</div>
		<div class="profile-picture">
				<img src="<?php echo IMGROOT . "/profile/" . $data[0]->profile_pic;?>" alt="profile picture" width="250" height="250">
			</div>
		<div class="profile-item">
			<div class="profile-username"><?php echo $data[0]->username; ?></div>
			<div class="profile-description">
				<p><?php echo $data[0]->description; ?></p>
			</div>
		</div>
	</div>
	<div class="section-gallery">
	<?php
			if (isset($_SESSION["message"]))
				{
					echo '<p style="color: green; text-align:center;">' . htmlentities($_SESSION["message"]) . '</p>';
					unset($_SESSION["message"]);
				}
		?>
		<div class="gallery">
			<?php $i = 0;$count = count($data);

			while ($i < $count)
			{
				if ($data[$i]->user_id == $_GET["id"])
				{
					$uploaderUName = $data[$i]->username;
					$uploaderPic = IMGROOT . "/profile/" . $data[$i]->profile_pic;
					$uploaderURL = URLROOT. "/profiles/profile?id=" . $data[$i]->user_id;
					$postURL = URLROOT. "/profiles/post?id=" . $data[$i]->image_id;
					$imgTitle = $data[$i]->image_title;
					$imgURL = IMGROOT . "/gallery/" . $data[$i]->file_name;
					?>
				<div class="gallery-item">
					<a href="<?php echo $postURL; ?>">
						<div class="uploader-profile">
							<div class="profile-thumbnail">
								<img src="<?php echo $uploaderPic;?>" alt="profile picture">
							</div>
							<h3><?php echo $uploaderUName;?></h3>
						</div>
						<div class="image-title">
							<h3>
							<?php
								if (isLoggedIn())
									echo $imgTitle;
							?>
							</h3>
						</div>
						<img class="full-img" src="<?php echo $imgURL?>" alt="anonymous profile picture">
					</a>
				</div>
			<?php
				}
				$i++;
			}?>
		</div>
	</div>
</div>

