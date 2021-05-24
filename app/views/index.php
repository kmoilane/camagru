<?php
	if (!isLoggedIn() && (isset($_SESSION["email"]) || isset($_SESSION["passRecovery"])))
	{
		unset($_SESSION["email"]);
		unset($_SESSION["passRecovery"]);
	}
?>

<?php
	require APPROOT . "/views/includes/head.php"
?>
<script type="text/javascript" src="<?php echo URLROOT;?>/public/javascript/gallery.js"></script>
<?php
	require APPROOT . "/views/includes/navigation.php";
?>
<div class="container">
	<?php if (!isset($_SESSION["user_id"])) : ?>
		<div id="section-landing">

			<div class="wrapper-landing">
				<h2>
					<a href="<?php echo URLROOT; ?>/users/register">Register now</a>
				</h2>
				<h2>and share your <span style="color: white;font-weight: 400;font-style: italic;text-decoration: 2px solid black underline;">highlights</span> to the world! :)</h2>
			</div>
		</div>
	<?php endif; ?>


	<div class="section-gallery">
		<div class="pagination">
			<div class=""></div>
		</div>
		<div class="gallery">
			<?php $i = 0;$count = count($data);
			while ($i < $count)
			{
				$uploaderUName = $data[$i]->username;
				$uploaderPic = IMGROOT . "/profile/" . $data[$i]->profile_pic;
				$uploaderURL = URLROOT. "/profiles/profile?id=" . $data[$i]->user_id;
				$postURL = URLROOT. "/profiles/post?id=" . $data[$i]->image_id;
				$imgTitle = $data[$i]->image_title;
				$imgURL = IMGROOT . "/gallery/" . $data[$i]->file_name;
				$imgId = $data[$i]->image_id;
				$ILike = 0;
				$j = 0;
				$total_likes = count($likes);
				$likeCount = 0;
				while ($j < $total_likes)
				{
					if ($likes[$j]->image_id == $data[$i]->image_id)
					{
						$likeCount++;
						if ($likes[$j]->liker_id == $_SESSION["user_id"])
							$ILike = 1;
					}
					$j++;
				}

				$i++;?>
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
			<?php } ?>
		</div>
	</div>
</div>

<script>
	function like() {
		if (this.src.match('https://img.icons8.com/emoji/48/000000/slightly-smiling-face.png'))
		{
			this.src = 'https://img.icons8.com/emoji/48/000000/smiling-face-with-heart-eyes.png';
		}
		else
		{
			this.src = 'https://img.icons8.com/emoji/48/000000/slightly-smiling-face.png';
		}
	}
</script>

</body>
</html>
