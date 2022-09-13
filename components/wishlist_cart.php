<?php

if (isset($_POST['add_to_wishlist'])) {

   if ($user_id == '')
      header('location:user_login.php');
   else {
      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $image = $_POST['image_01'];

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ? ");
      $check_wishlist_numbers->execute([$pid, $user_id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ? ");
      $check_cart_numbers->execute([$pid, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0)
         $message[] = 'Already added to wishlist!';
      else if ($check_cart_numbers->rowCount() > 0)
         $message[] = 'Already added to cart!';
      else {
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id, pid, name, price, image) VALUES (?, ?, ?, ?, ?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $message[] = 'Added to wishlist!';
      }
   }
}

if (isset($_POST['add_to_cart'])) {

   if ($user_id == '')
      header('location:user_login.php');
   else {
      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $image = $_POST['image_01'];
      $qty = $_POST['qty'];

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ? ");
      $check_cart_numbers->execute([$pid, $user_id]);

      if ($check_cart_numbers->rowCount() > 0)
         $message[] = 'Already added to cart!';
      else {

         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ? ");
         $check_wishlist_numbers->execute([$pid, $user_id]);

         if ($check_wishlist_numbers->rowCount() > 0) {
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ? AND user_id = ?");
            $delete_wishlist->execute([$pid, $user_id]);
         }

         $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'Added to cart!';
      }
   }
}
