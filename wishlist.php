<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}
else {
   $user_id = '';
   header('location:user_login.php');
}

include 'components/wishlist_cart.php';


if (isset($_POST['remove'])) {
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist->execute([$wishlist_id]);
   $message[] = 'Wishlist item removed.';
}

if (isset($_GET['delete_all'])) {
   $delete_all = $_GET['delete_all'];
   $delete_all_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_all_wishlist->execute([$user_id]);
   header('location:wishlist.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wishlist</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="See the items you wishlisted with your account in our website.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- Wishlist section starts  -->

<section class="products">
   
   <h1 class="heading">Your wishlist</h1>
   
   <div class="box-container">
   <?php 
      $grand_total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);

      if ($select_wishlist->rowCount() > 0) {
         while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
            $grand_total += $fetch_wishlist['price'];
   ?>

   <form action="" class="box" method="POST">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid'] ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name'] ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price'] ?>">
      <input type="hidden" name="image_01" value="<?= $fetch_wishlist['image'] ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id'] ?>">

      <a href="quick_view.php?pid=<?= $fetch_wishlist['pid'] ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_wishlist['image'] ?>" alt="" class="image">
      <div class="name"><?= $fetch_wishlist['name'] ?></div>
      <div class="flex">
         <div class="price">$<span><?= $fetch_wishlist['price'] ?></span>\-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
      </div>

      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      <input type="submit" value="remove" name="remove" class="delete-btn" onclick="return confirm('Delete this item from wishlist?');">
   </form>

   <?php
         }
      }
      else {
         echo '<p class="empty">Your wishlist is empty.</p>';
      }
   ?>
   </div>

   <div class="grand-total">
      <p>Grand total : <span>$<?= $grand_total ?>\-</span></p>
      <a href="shop.php" class="option-btn">Continue shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled' ?>" onclick="return confirm('Remove all from wishlist?')">Remove all</a>
   </div> 

</section>

<!-- Wishlist section endss  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>