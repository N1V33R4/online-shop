<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

include 'components/wishlist_cart.php';


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home | OnlineShop</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Find your much needed products with us, today. See our promotions we offer.">

   <!-- swiper cdn -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <div class="home-bg">

      <section class="swiper home-slider">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide">
               <div class="image">
                  <img src="images/home-img-1.png" alt="">
               </div>
               <div class="content">
                  <span>Upto 50% off</span>
                  <h3>Latest smartphone</h3>
                  <a href="shop.php" class="btn">shop now</a>
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="image">
                  <img src="images/home-img-2.png" alt="">
               </div>
               <div class="content">
                  <span>Upto 50% off</span>
                  <h3>Latest watch</h3>
                  <a href="shop.php" class="btn">shop now</a>
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="image">
                  <img src="images/home-img-3.png" alt="">
               </div>
               <div class="content">
                  <span>Upto 50% off</span>
                  <h3>Latest headset</h3>
                  <a href="shop.php" class="btn">shop now</a>
               </div>
            </div>

         </div>

         <div class="swiper-pagination"></div>
      </section>

   </div>

   <!-- Home Category section starts  -->

   <section class="home-category">

      <h1 class="heading">Shop by category</h1>
      <div class="swiper category-slider">

         <div class="swiper-wrapper">
            <?php
               $show_categories = $conn->prepare("SELECT * FROM `categories` ORDER BY name ASC");
               $show_categories->execute();
               if ($show_categories->rowCount() > 0) {
                  while ($fetch_categories = $show_categories->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <a href="category.php?category=<?= $fetch_categories['name']; ?>&id=<?= $fetch_categories['id']; ?>" class="swiper-slide slide">
               <img src="uploaded_img/<?= $fetch_categories['icon']; ?>" alt="">
               <h3><?= $fetch_categories['name']; ?></h3>
            </a>
            <?php }} ?>

            <!-- <a href="category.php?category=tv" class="swiper-slide slide">
               <img src="images/icon-2.png" alt="">
               <h3>tv</h3>
            </a>

            <a href="category.php?category=camera" class="swiper-slide slide">
               <img src="images/icon-3.png" alt="">
               <h3>camera</h3>
            </a>

            <a href="category.php?category=mouse" class="swiper-slide slide">
               <img src="images/icon-4.png" alt="">
               <h3>mouse</h3>
            </a>

            <a href="category.php?category=fridge" class="swiper-slide slide">
               <img src="images/icon-5.png" alt="">
               <h3>fridge</h3>
            </a>

            <a href="category.php?category=washing" class="swiper-slide slide">
               <img src="images/icon-6.png" alt="">
               <h3>washing machine</h3>
            </a>

            <a href="category.php?category=smartphone" class="swiper-slide slide">
               <img src="images/icon-7.png" alt="">
               <h3>smartphone</h3>
            </a>

            <a href="category.php?category=watch" class="swiper-slide slide">
               <img src="images/icon-8.png" alt="">
               <h3>watch</h3>
            </a> -->

         </div>

         <div class="swiper-pagination"></div>

      </div>
   </section>

   <!-- Home Category section ends  -->


   <!-- Home products section starts -->

   <section class="home-products">
   
      <h1 class="heading">Latest products</h1>

      <div class="swiper products-slider">

      <div class="swiper-wrapper">

      <?php 
         $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC LIMIT 6");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
               
      ?>

      <form action="" method="POST" class="slide swiper-slide">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image_01" value="<?= $fetch_products['image_01']; ?>">

         <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>

         <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="" class="image">
         <div class="name"><?= $fetch_products['name']; ?></div>
         
         <div class="flex">
            <div class="price">$<span><?= $fetch_products['price']; ?></span>\-</div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
         </div>

         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>

      <?php
            }
         }
         else {
            echo '<p class="empty">No products added yet!</p>';
         }
      ?>

      </div>

      <div class="swiper-pagination"></div>

      </div>

   </section>

   <!-- Home products section endss -->



   <?php include 'components/footer.php'; ?>

   <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".home-slider", {
         loop: true,
         grabCursor: true,
         pagination: {
            el: ".swiper-pagination",
         },
      });

      var swiper = new Swiper(".category-slider", {
         // loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
         },
         breakpoints: {
            0: {
               slidesPerView: 2,
            },
            650: {
               slidesPerView: 3,
            },
            768: {
               slidesPerView: 4,
            },
            1024: {
               slidesPerView: 5,
            },
         },
      });

      var swiper = new Swiper(".products-slider", {
         // loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
         },
         breakpoints: {
            650: {
               slidesPerView: 3,
            },
            768: {
               slidesPerView: 4,
            },
            1024: {
               slidesPerView: 4,
            },
         },
      });
   </script>

</body>

</html>