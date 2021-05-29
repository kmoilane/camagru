<?php
	if (!isset($_SESSION["user_id"]))
		header("location: " . URLROOT . "/users/login");
	if (!isset($_GET["id"]))
		header("location: " . URLROOT . "/index");
?>
<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
	require APPROOT . "/views/includes/navigation.php";
?>

<div class="section-gallery">
		<div class="gallery">
			<div class="gallery-item">
					<div class="uploader-profile">
						<div class="profile-thumbnail">
							<img src="<?php echo IMGROOT . "/profile/" . $data["profile_pic"];?>" alt="profile picture">
						</div>
						<a href="<?php echo URLROOT. "/profiles/profile?id=".$data["user_id"]; ?>"><?php echo $data["username"];?></a>
						<div class="image-title">
							<h3><?php echo $data["image_title"]; ?></h3>
						</div>
					</div>

					<img src="<?php echo IMGROOT . "/gallery/" . $data["file_name"]?>" alt="anonymous profile picture">
				<div class="image-interactions">
					<div class="likes">
						<form method="POST">
						<?php
						$ILike = 0;
						$i = 0;
						$total_likes = count($likes);
						while ($i < $total_likes)
						{
							if ($likes[$i]->liker_id == $_SESSION["user_id"])
								$ILike = 1;
							$i++;
						}
						if ($ILike)
							echo '<input type="image" alt="Unlike" name="unlikeBtn" title="Remove Like" src="https://img.icons8.com/emoji/48/000000/smiling-face-with-heart-eyes.png">';
						else
							echo '<input type="image" alt="Like" name="likeBtn" title="Like This Image" src="https://img.icons8.com/emoji/48/000000/slightly-smiling-face.png">';
						?>
						</form>
						<span><?php echo $total_likes; ?></span>
					</div>
					<?php
						if ($data["user_id"] === $_SESSION["user_id"])
						{
							echo '<div class="delete-img">';
							echo '<form method="POST" onsubmit="return confirm(\'Are You Sure You Want To Remove This Image?\');">';
							echo '<input type="image" alt="Delete" name="delete" title="Delete This Image" src="https://img.icons8.com/fluent/48/000000/delete-forever.png">';
							echo '</form></div>';
						}
					?>
				</div>
				<div class="comments">
					<div class="posted-comments">
					<?php $i = 0; $commentCount = count($comments);
						while ($i < $commentCount)
						{
							$sender = $comments[$i]->username;
							$comment = $comments[$i]->comment;
							$i++;
					?>
						<div class="comment">
						<span><?php echo $sender.': ' ?></span>
						<span><?php echo $comment?></span>
						</div>
						<?php } ?>
					</div>
					<div class="add-comment">
						<form method="POST">
							<input type="text" name="comment" id="newComment" placeholder="Send New Comment">
							<input type="submit" name="send" value="Send">
						</form>
					</div>
				</div>
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
