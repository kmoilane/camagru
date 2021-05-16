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
		<h1>Login</h1>
		<?php
		if (isset($_SESSION["message"]))
		{
			echo ('<p style="color:green;">'. $_SESSION["message"] .'</p>');
			unset($_SESSION["message"]);
		} ?>
		<form action="<?php echo URLROOT; ?>/users/login" method="POST">
			<span class="error-feedback">
				<?php echo $data["usernameError"]; ?>
			</span>
			<input type="text" placeholder="Username/Email" name="username">
			<span class="error-feedback">
				<?php echo $data["passwordError"]; ?>
			</span>
			<input type="password" placeholder="Password" name="password">

			<span class="error-feedback">
				<?php echo $data["verifyError"]; ?>
			</span>
			<button id="submit" type="submit" value="submit">Log In</button>

			<p class="options">Not registered? <a href="<?php echo URLROOT; ?>/users/register">Create an account!</a></p>
			<p class="options"><a href="<?php echo URLROOT;?>/users/recover_password">Forgot your password?</a></p>
		</form>
	</div>

</div>
