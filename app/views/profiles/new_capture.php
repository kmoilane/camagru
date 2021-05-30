<?php
	require APPROOT . "/views/includes/head.php"
?>

<?php
	require APPROOT . "/views/includes/navigation.php";
?>
<div class="section-new">
	<div class="wrapper-upload">
		<div class="preview">
			<video id="video" playsinline autoplay></video>
			<canvas id="canvas"></canvas>
		</div>
		<button id="capture" class="camagru-btn" onclick="captureSnapshot()">Capture</button>
		<button id="retake" class="camagru-btn hidden" onclick="clearCanvas()">Retake</button>
		<div class="wrapper-form" style="margin:0 auto;">
			<form id="uploadForm" action="<?php echo URLROOT; ?>/profiles/new_capture" method="POST" enctype="multipart/form-data" name="new">
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
					<?php echo $data["titleError"]; ?>
				</span>
				<input type="text" name="title" placeholder="Image Title">
				<span class="error-feedback">
					<?php echo $data["uploadError"]; ?>
				</span>
				<input type="text" style="display:none;" name="image_data" id="hiddenImgData">
				<button id="submit" name="submit" type="submit" onclick="uploadImage()" value="submit">Upload</button>
			</form>
		</div>
	</div>
</div>
<script>

	'use strict';
	const video = document.querySelector('video');
	const capture = document.getElementById("capture");
	const retake = document.getElementById("retake");
	const canvas = document.getElementById("canvas");
	const context = canvas.getContext("2d");
	var webcamStream;

	const constraints =  {
		audio: true,
		video: {
			width: 640, height: 480
		}
	};

	async function startWebCam() {
		try { 
			const stream = await navigator.mediaDevices.getUserMedia ({ video: true });
			window.stream = stream;
			video.srcObject = stream;
			video.src = window.URL.createObjectURL(localMediaStream);
			webcamStream = localMediaStream;
		}
		catch (error) {
			console.log(error);
		}
	}
	startWebCam();

	capture.addEventListener("click", function() {
		context.drawImage(video, 0, 0, canvas.width, canvas.height);
		retake.classList.toggle("hidden");
		capture.classList.toggle("hidden");
		stopWebcam();
	});


	function clearCanvas() {
		context.clearRect(0, 0, canvas.width, canvas.height);
		retake.classList.toggle("hidden");
		capture.classList.toggle("hidden");
		startWebCam();

	}

	function stopWebcam() {
		const mediaStream = video.srcObject;
		const tracks = mediaStream.getTracks();
		tracks.forEach(function(track) {
			track.stop();
		});
	}

	function uploadImage() {
		document.getElementById("hiddenImgData").value = canvas.toDataURL('image/png');
		document.forms['uploadForm'].submit();
	}


</script>
