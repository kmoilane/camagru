
<div class="header">
	<nav class="top-nav">
		<?php
		if (isset($_SESSION["user_id"]))
			{ echo
			'<div class="user-nav">
				<ul>
					<li>
						<a href="'?>
						<?php echo URLROOT; echo '/users/settings">Settings</a>
					</li>
					<li class="btn-cta">
						<a class="cta" href="'?>
						<?php echo URLROOT; echo '/profiles/new">New Photo</a>
					</li>
					<li>
						<form action="search" method="post" name="searchForm">
							<input type="text" name="searchfield" placeholder="Search For a User">
							<input type="submit" name="search" value="">
						</form>
					</li>
				</ul>
			</div>';
			} ?>
		<a href="<?php echo URLROOT; ?>/index">
			<div class="brandLogo">
				<h1>Camagru</h1>
				<div class="border"></div>
			</div>
		</a>
		<ul>
			<li>
				<a href="<?php echo URLROOT; ?>/index">Home</a>
			</li>
			<li>
				<?php if (isset($_SESSION["user_id"])) : ?>
					<a href="<?php echo URLROOT . "/profiles/profile?id=".$_SESSION['user_id']; ?>">Profile</a>
				<?php else : ?>
					<a href="<?php echo URLROOT; ?>/users/register">Sign up</a>
				<?php endif; ?>
			</li>
			<?php if (isset($_SESSION["user_id"])) : ?>
			<li>
				<a href="<?php echo URLROOT; ?>/users/logout">Log out</a>
			<?php else : ?>
			<li class="btn-cta">
				<a class="cta" href="<?php echo URLROOT; ?>/users/login">Log in</a>
			<?php endif; ?>
			</li>
		</ul>
	</nav>
</div>
