<?php
if (empty($_SESSION["email"]))
	header("location: " . URLROOT ."/users/login");

if (isset($_GET["email"]) && isset($_GET["otp"]))
	$this->verify();
?>

<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
		require APPROOT . "/views/includes/navigation.php";
?>
<div class="container-form">
	<div class="wrapper-form">
		<h1>Verify Email</h1>
		<form action="<?php echo URLROOT; ?>/users/verify" method="POST">
			<input type="text" placeholder="Verification Code" name="otp">
			<span class="error-feedback">
				<?php echo $data["otpError"]; ?>
			</span>
			<button id="submit" name="verify" type="submit" value="submit">Verify</button>
		</form>
	</div>

</div>

