function preview_image(event)
{
	var reader = new FileReader();
	reader.onload = function()
	{
		var filename = document.getElementById("file-upload").value;
		var extension = filename.split('.').pop();
		// Display sticker list && title input
		const stickers = document.getElementsByClassName("wrapper-stickers")[0];
		const title = document.getElementsByClassName("upload-title")[0];
		const btn = document.getElementById("submit");
		title.classList.toggle("hidden");
		btn.classList.toggle("hidden");
		if (extension !== "gif")
			stickers.classList.toggle("hidden");


		// Display image preview
		var output = document.getElementById("output-image");
		output.src = reader.result;
	}

	reader.readAsDataURL(event.target.files[0]);
}
