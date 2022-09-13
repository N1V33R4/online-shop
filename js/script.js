let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () => {
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

window.onscroll = () => {
   profile.classList.remove('active');
   navbar.classList.remove('active');
}

// Change image src onclick
subImages = document.querySelectorAll('.quick-view .image-container .small-images img');
mainImage = document.querySelector('.quick-view .image-container .big-image img');

subImages.forEach(image => {
   image.onclick = () => {
      let src = image.getAttribute('src');
      mainImage.src = src;
   }
});
