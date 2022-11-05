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

if (isset($_POST['remove'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart->execute([$cart_id]);
   $message[] = 'Cart item removed.';
}

if (isset($_GET['delete_all'])) {
   $delete_all = $_GET['delete_all'];
   $delete_all_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_all_cart->execute([$user_id]);
   header('location:cart.php');
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Cart quantity updated!';
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="See the items you've placed in your carts.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>


<!-- Cart section starts  -->

<section class="products">
   
   <h1 class="heading">Your cart</h1>
   
   <div class="box-container">
   <?php 
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);

      if ($select_cart->rowCount() > 0) {
         while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
   ?>

   <form action="" class="box" method="POST">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id'] ?>">

      <a href="quick_view.php?pid=<?= $fetch_cart['pid'] ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_cart['image'] ?>" alt="" class="image">
      <div class="name"><?= $fetch_cart['name'] ?></div>

      <div class="flex">
         <div class="price">$<span><?= $fetch_cart['price'] ?></span>\-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity'] ?>" onkeypress="if(this.value.length == 2) return false;">
         <button type="submit" class="fas fa-edit" name="update_qty"></button>
      </div>
      <div class="sub-total">Sub total : <span>$<?= $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'] ?>\-</span></div>

      <!-- <input type="submit" value="add to cart" name="add_to_cart" class="btn"> -->
      <input type="submit" value="remove" name="remove" class="delete-btn" onclick="return confirm('Delete this item from cart?');">
   </form>

   <?php
         $grand_total += $sub_total;
         }
      }
      else {
         echo '<p class="empty">Your cart is empty.</p>';
      }
   ?>
   </div>

   <div class="grand-total">
      <p>Grand total : <span>$<?= $grand_total ?>\-</span></p>
      <a href="shop.php" class="option-btn">Continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled' ?>" onclick="return confirm('Remove all from cart?')">Remove all</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled' ?>">Proceed to checkout</a>
   </div> 

</section>

<!-- Cart section endss  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>