/*

document.addEventListener("DOMContentLoaded", function()
{
	let galleryImages = document.querySelectorAll(".gallery-item");
	let getLatestOpenedImg;
	let windowWidth = window.innerWidth;

	if(galleryImages)
	{
		console.log(galleryImages);
		galleryImages.forEach(function(image, index) {
			image.addEventListener("click", function() {
				let fullImageUrl = image.querySelector(".full-img").src;

				getLatestOpenedImg = index + 1;

				let container = document.body;
				let newImgWindow = document.createElement("div");
				container.appendChild(newImgWindow);
				newImgWindow.setAttribute("class", "img-window");
				newImgWindow.setAttribute("onclick", "closeImg()");

				let newImg = document.createElement("img");
				newImgWindow.appendChild(newImg);
				newImg.setAttribute("src", getFullImageUrl);
			});
		});
	}
});

function closeImg() {
	document.querySelector(".img-window").remove();
}*/


