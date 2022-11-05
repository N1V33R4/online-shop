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

if (isset($_POST['order'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);

   $address = $_POST['flat'].', '.$_POST['street'].', '.$_POST['city'];
   if (isset($_POST['state'])) {
      $address .= ', '.$_POST['state'];
   }
   $address .= ', '.$_POST['country'].' - '.$_POST['pin_code'];

   $payment_method = $_POST['method'];
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) 
   {
      $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_order->execute([$user_id, $name, $number, $email, $payment_method, $address, $total_products, $total_price]);

      $message[] = 'Your order was placed successfullly!';

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
   }
   else {
      $message[] = 'Your cart is empty!';
   }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Place your orders here and let us handle the rest.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- Checkout section starts  -->

<section class="checkout">

   <h1 class="heading">Your orders</h1>

   <div class="display-orders">

   <?php 
      $grand_total = 0;
      $cart_items[] = '';
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);

      if ($select_cart->rowCount() > 0) {
         while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['quantity'] . ') - ';
            $total_products = implode($cart_items);
   ?>

   <p> <?= $fetch_cart['name'] ?> <span>$<?= $fetch_cart['price'] ?>/- x <?= $fetch_cart['quantity'] ?></span> </p>

   <?php
         }
      }
      else {
         echo '<p class="empty">Your cart is empty.</p>';
      }
      ?>
   </div>

   <p class="grand-total">Grand total : <span>$<?= $grand_total ?>\-</span></p>

   <form action="" method="POST">

      <h1 class="heading">Place order</h1>
      
      <input type="hidden" name="total_products" value="<?= $total_products ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total ?>"> 
      
      <div class="flex">
         <div class="inputBox">
            <span>Your name :</span>
            <input type="text" maxlength="20" placeholder="Enter your name" required class="box" name="name">
         </div>
         <div class="inputBox">
            <span>Your number :</span>
            <input type="number" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" placeholder="Enter your number" required class="box" name="number">
         </div>
         <div class="inputBox">
            <span>Your email :</span>
            <input type="text" maxlength="20" placeholder="Enter your email" required class="box" name="email">
         </div>
         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method" class="box">
               <option value="cash on delivery">Cash on delivery</option>
               <option value="credit card">Credit card</option>
               <option value="paypal">Paypal</option>
               <option value="visa">Visa</option>
               <option value="aba">ABA</option>
            </select>
         </div>

         <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="text" maxlength="50" placeholder="e.g Flat, House no." required class="box" name="flat">
         </div>
         <div class="inputBox">
            <span>Address line 02 :</span>
            <input type="text" maxlength="50" placeholder="e.g Street name" required class="box" name="street">
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" maxlength="50" placeholder="e.g Phnom Penh" required class="box" name="city">
         </div>
         <div class="inputBox">
            <span>State :</span>
            <input type="text" maxlength="50" placeholder="e.g ..." class="box" name="state">
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" maxlength="50" placeholder="e.g Cambodia" required class="box" name="country">
         </div>
         <div class="inputBox">
            <span>Pin code :</span>
            <input type="number" min="0" max="999999" placeholder="e.g 123456" required class="box" name="pin_code" onkeypress="if(this.value.length == 6) return false;">
         </div>
      </div>
      
      <input type="submit" value="place order" class="btn <?= ($grand_total > 1) ? '' : 'disabled' ?>" name="order">

   </form>

</section>

<!-- Checkout section ends  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>