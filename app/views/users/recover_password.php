<?php
	if (isset($_SESSION["user_id"]))
		header("Location: ../index");
?>

<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
		require APPROOT . "/views/includes/navigation.php";
?>

<div class="container-form">
	<div class="wrapper-form">
		<h1>Recover Password</h1>
		<form autocomplete="off" action="<?php echo URLROOT; ?>/users/recover_password" method="POST">
			<span class="error-feedback">
				<?php echo $data["emailError"]; ?>
			</span>
			<input autocomplete="off" type="text" placeholder="Email" name="email">
			<button id="submit" name="recover" type="submit" value="submit">Continue</button>
			<span class="error-feedback">
				<?php echo $data["mailError"]; ?>
			</span>

			<p class="options">Or <a href="<?php echo URLROOT; ?>/users/login">Log In</a></p>
		</form>
	</div>
</div>
