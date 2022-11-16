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


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Your Orders | OnlineShop</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="See your complete order history using our service.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- Orders section starts  -->

<section class="show-orders">

   <h1 class="heading">Your orders</h1>
   
   <div class="box-container">
      <?php
         $show_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $show_orders->execute([$user_id]);
         if ($show_orders->rowCount() > 0) {
            while ($fetch_orders = $show_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>

      <div class="box">
         <!-- <p> User ID <span><?= $fetch_orders['user_id'] ?></span></p> -->
         <p> Placed on : <span><?= substr($fetch_orders['placed_on'], 0, -3) ?></span></p>
         <p> Name : <span><?= $fetch_orders['name'] ?></span></p>
         <p> Number : <span><?= $fetch_orders['number'] ?></span></p>
         <p> Email : <span><?= $fetch_orders['email'] ?></span></p>
         <p> Address : <span><?= $fetch_orders['address'] ?></span></p>
         <p> Your orders : <span><?= $fetch_orders['total_products'] ?></span></p>
         <p> Total price : <span>$<?= $fetch_orders['total_price'] ?>\-</span></p>
         <p> Payment method : <span style="text-transform:capitalize;"><?= $fetch_orders['method'] ?></span></p>
         <p> Payment status : <span style="color:<?= $fetch_orders['payment_status'] == 'pending' ? 'red' : 'green' ?>;text-transform:capitalize;"><?= $fetch_orders['payment_status'] ?></span></p>
      </div>

      <?php
            }
         }
         else {
            echo '<p class="empty">No orders placed yet!</p>';
         }
      ?>
   </div>

</section>

<!-- Orders section ends  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>