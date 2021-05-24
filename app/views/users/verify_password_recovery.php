<?php
if (!isset($_SESSION["email"]))
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
		<h1>Recovery Code Sent</h1>
		<form method="POST">
			<input type="text" placeholder="Recovery Code" name="otp">
			<span class="error-feedback">
				<?php echo $data["otpError"]; ?>
			</span>
			<button id="submit" name="recover" type="submit" value="submit">Continue</button>
		</form>
	</div>

</div>
