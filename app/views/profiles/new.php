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
		<div class="wrapper-form" style="margin:0 auto;">
			<form action="<?php echo URLROOT; ?>/profiles/new" method="POST" enctype="multipart/form-data" name="new">
				<div class="wrapper-stickers">
					<select name="sticker" id="sticker-select">
						<option value="none">No stickers<?php $sticker = "None";?></option>
						<option value="camagru_sticker.png">Camagru Sticker Black<?php $sticker = "camagru_sticker.png";?></option>
						<option value="camagru_sticker_white.png">Camagru Sticker White<?php $sticker = "camagru_sticker_white.png";?></option>
					</select>
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
