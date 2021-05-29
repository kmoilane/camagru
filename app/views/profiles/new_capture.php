<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
	require APPROOT . "/views/includes/navigation.php";
?>
<div class="section-new">
	<div class="wrapper-upload">
		<div class="preview">
			<video autoplay></video>
			<button onclick="startWebCam()">Start</button>
			<button onclick="stopWebCam()">Stop</button>
		</div>
		<div class="wrapper-form" style="margin:0 auto;">
			<form action="<?php echo URLROOT; ?>/profiles/new_capture" method="POST" enctype="multipart/form-data" name="new">
				<span class="error-feedback">
					<?php echo $data["stickerError"]; ?>
				</span>
				<div class="wrapper-stickers">
					<label>
						<input type="radio" name='sticker' id="empty" value="none"/>
						<img src="https://img.icons8.com/material-outlined/96/000000/no-entry.png" alt="No Sticker" title="No Sticker"/>
					</label>
					<label>
						<input type="radio" name='sticker' id="blackCamagru" value="<?php echo IMGROOT;?>/stickers/camagru_sticker.png"/>
						<img src="<?php echo IMGROOT;?>/stickers/camagru_sticker.png" alt="Camagru Sticker Black">
					</label>
					<label>
						<input type="radio" name='sticker' id="whiteCamagru" value="<?php echo IMGROOT;?>/stickers/camagru_sticker_white.png"/>
						<img src="<?php echo IMGROOT;?>/stickers/camagru_sticker_white.png" alt="Camagru Sticker White">
					</label>
				</div>

				<span class="error-feedback">
					<?php echo $data["fileError"]; ?>
				</span>
				<input type="file" name="image" accept="image/*" onchange="preview_image(event)">
				<span class="error-feedback">
					<?php echo $data["titleError"]; ?>
				</span>
				<input type="text" name="title" placeholder="Image Title">
				<span class="error-feedback">
					<?php echo $data["uploadError"]; ?>
				</span>
				<button id="submit" name="submit" type="submit" value="submit">Upload</button>
			</form>
		</div>
	</div>
</div>
<script>
	const video = document.querySelector('video');

	const startWebCam = () => {
		if (navigator.mediaDevices.getUserMedia) {
			navigator.mediaDevices.getUserMedia ({ video: true })
			.then(stream => video.srcObject = stream)
			.catch(error => console.log(error));
		}
	}
	startWebCam();

	const stopWebCam = () => {
		let stream = video.srcObject;
		let tracks = stream.getTracks();
		tracks.foreach(track => track.stop());
		video.srcObject = null;
	}
</script>
