<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}
else {
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
   <title>Search page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- Search form section starts  -->

<section class="search-form">
   <form action="" method="GET">
      <input type="text" class="box" maxlength="100" placeholder="Search here..." required name="search_box" autofocus value="<?= isset($_GET['search_box']) ? $_GET['search_box'] : '' ?>">
      <button type="submit" class="fas fa-search"></button>
   </form>
</section>

<!-- Search form section endss  -->

<section class="products" style="padding-top:0;min-height:50vh;">
      
   <!-- <h1 class="heading">Products</h1> -->

   <div class="box-container">

   <?php
      if (isset($_GET['search_box'])) {
         
         $search_box = $_GET['search_box'];

         $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
   ?>

   <form action="" method="POST" class="box">
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
         } else {
            echo '<p class="empty">No products found!</p>';
         }
      }
   ?>

   </div>
</section>



<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>