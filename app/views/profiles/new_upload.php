<?php
	require APPROOT . "/views/includes/head.php"
?>
<script type="text/javascript" src="<?php echo URLROOT;?>/public/javascript/upload.js"></script>
<?php
	require APPROOT . "/views/includes/navigation.php";
?>
<div class="section-new">
	<div class="wrapper-upload">
		<div class="preview">
			<img id="output-image">
		</div>
		<div class="wrapper-form">
			<form action="<?php echo URLROOT; ?>/profiles/new_upload" method="POST" enctype="multipart/form-data" name="new">
				<span class="error-feedback">
					<?php echo $data["stickerError"]; ?>
				</span>
				<div class="wrapper-stickers hidden">
					<p>Filters</p>
					<label>
						<input type="radio" name='sticker' id="empty" value="none"/>
						<img src="<?php echo IMGROOT;?>/stickers/no_sticker.png" alt="No Sticker" title="No Sticker"/>
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
				<label for="file-upload" class="custom-file-input">Browse</label>
				<input id="file-upload" type="file" name="image" accept="image/*" onchange="preview_image(event)">
				<span class="error-feedback">
					<?php echo $data["titleError"]; ?>
				</span>
				<input class="upload-title hidden" type="text" name="title" placeholder="Image Title">
				<span class="error-feedback hidden">
					<?php echo $data["uploadError"]; ?>
				</span>
				<button class="hidden" id="submit" name="submit" type="submit" value="submit">Upload</button>
			</form>
		</div>
	</div>
</div>
