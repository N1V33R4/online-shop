<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}
else {
   $user_id = '';
   // header('location:user_login.php');
}

include 'components/wishlist_cart.php';


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop | OnlineShop</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Our list of all the products we offer on our website!">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>


<!-- Shop section starts -->

<section class="products">
      
   <h1 class="heading">Products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
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
         echo '<p class="empty">No products added yet!</p>';
      }
   ?>

   </div>
</section>

<!-- Shop section ends -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>