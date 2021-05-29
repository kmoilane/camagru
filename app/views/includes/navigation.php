
<div class="header">
	<nav class="top-nav">
		<?php
		if (isset($_SESSION["user_id"]))
		{
			echo
			'<div class="hamburger">
				<div class="bar"></div>
			</div>';
			echo
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
				</ul>
			</div>';
			} ?>
		<a href="<?php echo URLROOT; ?>/index">
			<div class="brandLogo">
				<h1>Camagru</h1>
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

<script type="text/javascript" src="<?php echo URLROOT; ?>/public/javascript/navbar.js"></script>
