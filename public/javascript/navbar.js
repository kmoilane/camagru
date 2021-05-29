const hamburger = document.querySelector('.header .top-nav .hamburger');
const mobile_menu = document.querySelector('.header .top-nav .user-nav');
const menu_item = document.querySelectorAll('.header .top-nav .user-nav ul li a');

hamburger.addEventListener('click', () => {
	hamburger.classList.toggle('active-menu');
	mobile_menu.classList.toggle('active-menu');
});

menu_item.forEach((item) => {
	item.addEventListener('click', () => {
		hamburger.classList.toggle('active-menu');
		mobile_menu.classList.toggle('active-menu');
	});
});
