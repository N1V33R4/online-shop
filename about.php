<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}
else {
   $user_id = '';
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- swiper cdn -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- About Section -->
<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>Why choose us?</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis eveniet mollitia ratione modi error vel? Maiores voluptate recusandae necessitatibus minus dolorem assumenda deserunt voluptatibus dolore? Quos perferendis minus eaque quidem?</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>


<!-- Reviews section -->
<section class="reviews">

   <h1 class="heading">Client's reviews</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

   <div class="swiper-slide slide">
      <img src="images/pic-1.png" alt="">
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, iste. Quis labore omnis accusamus officia?</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>john doe</h3>
   </div>

   <div class="swiper-slide slide">
      <img src="images/pic-2.png" alt="">
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, iste. Quis labore omnis accusamus officia?</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>john doe</h3>
   </div>

   <div class="swiper-slide slide">
      <img src="images/pic-3.png" alt="">
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, iste. Quis labore omnis accusamus officia?</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>john doe</h3>
   </div>

   <div class="swiper-slide slide">
      <img src="images/pic-4.png" alt="">
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, iste. Quis labore omnis accusamus officia?</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>john doe</h3>
   </div>

   <div class="swiper-slide slide">
      <img src="images/pic-5.png" alt="">
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, iste. Quis labore omnis accusamus officia?</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>john doe</h3>
   </div>

   <div class="swiper-slide slide">
      <img src="images/pic-6.png" alt="">
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, iste. Quis labore omnis accusamus officia?</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>john doe</h3>
   </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>




<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>
   var swiper = new Swiper(".reviews-slider", {
         // loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
         },
         breakpoints: {
            550: {
               slidesPerView: 2,
            },
            768: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });
</script>

</body>

</html>