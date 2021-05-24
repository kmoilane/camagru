<?php
if (!isset($_SESSION["email"]) || !isset($_SESSION["passRecovery"]))
{
	header("location: " . URLROOT ."/users/login");
	exit;
}
if (isset($_SESSION["user_id"]))
{
	header("location: " . URLROOT ."/index");
	exit;
}
?>

<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
		require APPROOT . "/views/includes/navigation.php";
?>
<div class="container-form">
	<div class="wrapper-form">
		<h1>Set New Password</h1>
		<form method="POST">
			<input autocomplete="off" type="password" placeholder="Password" name="password">
			<span class="error-feedback">
				<?php echo $data["passwordError"]; ?>
			</span>
			<input autocomplete="off" type="password" placeholder="Confirm Password" name="confirmPassword">

			<button id="submit" name="change" type="submit" value="submit">Change Password</button>
		</form>
	</div>

</div>
