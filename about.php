<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="author" content="Group 2">
   <meta name="description" content="Our mission is to the provide the simplest way for users to get what they need online.">
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
            <h1 style="color:  #2980b9;">Why choose us?</h1>
            <br>
            <br>
            <br>
            <h1>SM4RT Inc. is a Cambodian multinational technology company that specializes in consumer electronics, software and online services headquartered in Phnom Penh, Cambodia.</h1>
            <br>
            <h1 style="color: #2980b9;">Get in touch with us SM4RTINC@info.com</h1>

            <a href="contact.php" class="btns">contact us</a>
            <style>
               .btns {
                  margin-top: 1rem;
                  display: inline-block;
                  padding: .9rem 3rem;
                  border-radius: .5rem;
                  color: #fff;
                  background: var(--blue);
                  font-size: 1.7rem;
                  cursor: pointer;
                  font-weight: 500;
               }

               .btns:hover {
                  background: var(--white);
                  color: black;
               }
            </style>
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
               <p>Package was secure and came to me as fast as I could expect. Best price on the net and top quality kit. All good.Entire ordering process was very smooth and the team were very helpful</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
               <h3>Thay Visal</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-2.png" alt="">
               <p>Ordered my item on Monday and received it two days later which was great. However it's a really expensive product so I would have expected it to have been wrapped.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>

                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Serey Danead</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-3.png" alt="">
               <p>Buying an expensive item through the internet from a company one has never heard of could be be risky, however after researching the product I wanted and reading the reviews/blogs for electricshop I went ahead.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Phanith Hun</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-4.png" alt="">
               <p>Best price on internet for oven we purchased with quick delivery. Found the phone communications a bit lacking in professionalism very to the point and as quick as they could get me off the phone.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Seang Peng</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-5.png" alt="">
               <p>Having paid for the next day delivery service our TV arrived mid morning, which was great. However, we were not told that we would need to buy additional accessories to use the SMART functions.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Pirun Amrith</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-6.png" alt="">
               <p>Overall I have very happy with The Electric shop. As I was replacing my kitchen I was buying several new appliances.ordering was straightforward but delivery arrangements were not.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>


               </div>
               <h3>Tan Pov Chesda</h3>
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
