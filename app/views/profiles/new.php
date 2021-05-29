<?php
	require APPROOT . "/views/includes/head.php"
?>
<script type="text/javascript" src="<?php echo URLROOT;?>/public/javascript/upload.js"></script>
<?php
	require APPROOT . "/views/includes/navigation.php";
?>

<div class="new-post">
	<div class="new-link">
		<a href="<?php echo URLROOT; ?>/profiles/new_upload">
			<img src="https://img.icons8.com/android/96/000000/upload.png"/>
			<h2>Upload</h2>
		</a>
	</div>
	<div class="new-link">
		<a href="<?php echo URLROOT; ?>/profiles/new_capture">
			<img src="https://img.icons8.com/ios-filled/100/000000/screenshot.png"/>
			<h2>Capture</h2>
		</a>
	</div>
</div>
