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
	<h1>Delete User</h1>
	<div class="settings-wrap">
		<form method="POST">
			<div class="form-item">
				<label for="password">Confirm With Password</label>
				<input type="password" name="password" id="password" placeholder="Password">
				<span class="error-feedback">
					<?php echo $data["passwordError"];?>
				</span>
			</div>
				<input style="float: left;" name="cancel" type="submit" value="Cancel">
				<input style="float: right;" type="submit" name="delete" value="Delete User">
		</form>
	</div>
</div>
