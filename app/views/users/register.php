<?php
	if (isset($_SESSION["user_id"]))
		header("Location: ../profile/profile");
?>

<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
	require APPROOT . "/views/includes/navigation.php";
?>

<div class="container-form">
	<div class="wrapper-form">
		<h1>Register</h1>
		<form autocomplete="off" action="<?php echo URLROOT; ?>/users/register" method="POST">
			<span class="error-feedback">
				<?php echo $data["usernameError"]; ?>
			</span>
			<input autocomplete="off" type="text" placeholder="Username" name="username">
			<span class="error-feedback">
				<?php echo $data["emailError"]; ?>
			</span>
			<input autocomplete="off" type="text" placeholder="Email" name="email">
			<span class="error-feedback">
				<?php echo $data["passwordError"]; ?>
			</span>
			<input autocomplete="off" type="password" placeholder="Password" name="password">
			<span class="error-feedback">
				<?php echo $data["confirmPasswordError"]; ?>
			</span>
			<input autocomplete="off" type="password" placeholder="Confirm Password" name="confirmPassword">

			<button id="submit" type="submit" value="submit">Continue</button>
			<span class="error-feedback">
				<?php echo $data["mailError"]; ?>
			</span>

			<p class="options">Already registered? <a href="<?php echo URLROOT; ?>/users/login">Sign in!</a></p>
		</form>
	</div>

</div>
