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
		<div class="gallery">
		<?php
			if (isset($_SESSION["message"]))
				{
					echo '<p style="color: green; text-align:center;">' . htmlentities($_SESSION["message"]) . '</p>';
					unset($_SESSION["message"]);
				}
		?>
			<div class="pagination">
				<?php
				if (isset($data[0]))
				{
					$page = $data[0]->page;
					$final_page = $data[0]->final_page;
					$rpp = $data[0]->rpp;
					if ($page > 1)
					{
						$previous_page = $page - 1;
					?>
						<a class="arrow" href="<?php echo URLROOT;?>/index?page=<?php echo $previous_page;?>">< Previous</a>
						<a href="<?php echo URLROOT; ?>/">1</a>
					<?php
					}
					?>
					<a class="current-page" href="<?php echo URLROOT;?>/index?page=<?php echo $page?>"><?php echo $page; ?></a>
					<?php
					$next_page = $page + 1;
					if ($final_page > 1 && ($final_page - $page) > 1)
					{
					?>
						<a href="<?php echo URLROOT;?>/index?page=<?php echo $next_page;?>"><?php echo $next_page; ?></a>
					<?php
					}
					if ($final_page > 1 && $page < $final_page)
					{ ?>
						<a href="<?php echo URLROOT; ?>/index?page=<?php echo $final_page;?>"><?php echo $final_page; ?></a>
						<a class="arrow" href="<?php echo URLROOT;?>/index?page=<?php echo $next_page?>">Next ></a>
					<?php
					}
				}
				?>
				</div>
			<?php
			if (isset($data[0]->username))
			{
				$i = 0;
				$count = count($data);
				while ($i < $count)
				{
					$uploaderUName = $data[$i]->username;
					$uploaderPic = IMGROOT . "/profile/" . $data[$i]->profile_pic;
					$uploaderURL = URLROOT. "/profiles/profile?id=" . $data[$i]->user_id;
					$postURL = URLROOT. "/profiles/post?id=" . $data[$i]->image_id;
					$imgTitle = $data[$i]->image_title;
					$imgURL = IMGROOT . "/gallery/" . $data[$i]->file_name;
					$imgId = $data[$i]->image_id;
					$i++;
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
						<img src="<?php echo $imgURL?>" alt="<?php echo $imgTitle ?>">
					</a>
				</div>
				<?php
				}
			} ?>
			<div class="pagination">
				<?php
				if (isset($data[0]))
				{
					$page = $data[0]->page;
					$final_page = $data[0]->final_page;
					if ($page > 1)
					{
						$previous_page = $page - 1;
					?>
						<a class="arrow" href="<?php echo URLROOT;?>/index?page=<?php echo $previous_page;?>">< Previous</a>
						<a href="<?php echo URLROOT; ?>/">1</a>
					<?php
					}
					?>
					<a class="current-page" href="<?php echo URLROOT;?>/index?page=<?php echo $page?>"><?php echo $page; ?></a>
					<?php
					$next_page = $page + 1;
					if ($final_page > 1 && ($final_page - $page) > 1)
					{
					?>
						<a href="<?php echo URLROOT;?>/index?page=<?php echo $next_page;?>"><?php echo $next_page; ?></a>
					<?php
					}
					if ($final_page > 1 && $page < $final_page)
					{ ?>
						<a href="<?php echo URLROOT; ?>/index?page=<?php echo $final_page;?>"><?php echo $final_page; ?></a>
						<a class="arrow" href="<?php echo URLROOT;?>/index?page=<?php echo $next_page?>">Next ></a>
					<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

</body>
</html>
