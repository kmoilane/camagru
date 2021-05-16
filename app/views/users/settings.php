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

<div class="settings">
	<h1>Settings</h1>
	<div class="settings-menu">
		<ul>
			<a href="#" class="current"><li>General</li></a>
		</ul>
	</div>
	<div class="settings-wrap">
		<form method="POST" autocomplete="off">
			<div class="form-item">
				<label for="name">Username</label>
				<input type="text" id="name" name="name" value="<?php echo $_SESSION["username"] ?>">
				<span class="error-feedback">
					<?php echo $data["usernameError"];?>
				</span>
			</div>
			<div class="form-item">
				<label for="email">Change Email</label>
				<input type="text" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" placeholder="Email">
				<span class="error-feedback">
					<?php echo $data["emailError"];?>
				</span>
			</div>
			<div class="form-item pass">
				<label for="password">New Password</label>
				<input type="password" name="password" id="password" autocomplete="new-password" placeholder="New Password" value="">
				<input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm" autocomplete="off" value="">
				<span class="error-feedback">
					<?php echo $data["passwordError"];?>
				</span>
			</div>
			<div class="form-item">
				<label class="notifications" for="receiveEmail">Receive Email Notifications</label>
				<input type="checkbox" name="notify" id="receiveEmail" <?php if ($_SESSION["notify"]) {echo "checked";} ?>>
			</div>
			<input type="submit" name="save" value="Save Changes">
			<input type="submit"  name="delete" value="Delete User">
		</form>
		<?php
			if (isset($_SESSION["success"]))
				{
					echo '<p style="color: green;">' . htmlentities($_SESSION["success"]) . '</p>';
					unset($_SESSION["success"]);
				}
		?>
	</div>
</div>

