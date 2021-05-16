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
		<div class="profile-item">
			<div class="profile-picture">
				<img src="<?php echo IMGROOT . "/profile/" . $data[0]->profile_pic;?>" alt="profile picture" width="250" height="250">
			</div>
			<div class="profile-username"><?php echo $data[0]->username; ?></div>
			<div class="profile-description">
				<p><?php echo $data[0]->description; ?></p>
			</div>
		</div>
	</div>
	<div class="section-gallery">
		<div class="gallery">
			<?php $i = 0;$count = count($data);
			while ($i < $count)
			{
				$uploaderUName = $data[$i]->username;
				$uploaderPic = IMGROOT . "/profile/" . $data[$i]->profile_pic;
				$uploaderID = URLROOT. "/profiles/profile?id=" . $data[$i]->user_id;
				$imgTitle = $data[$i]->image_title;
				$imgURL = IMGROOT . "/gallery/" . $data[$i]->file_name;

				$i++;?>
			<div class="gallery-item">
				<div class="image-title">
				</div>
				<div class="image-description">
				</div>
				<div class="image-interactions">
				</div>
				<img src="<?php echo $imgURL?>" alt="anonymous profile picture">
			</div>
			<?php } ?>
		</div>
	</div>
</div>

