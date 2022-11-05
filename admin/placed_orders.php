<?php 

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];

   if ($_POST['old_status'] == $payment_status) {
      $message[] = 'Next status can\'t be the same as previous.';
   }
   else {
      $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
      $update_status->execute([$payment_status, $order_id]);
      $message[] = 'Payment status updated!';
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed orders</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Placed orders section starts -->

<section class="placed-orders">
   <h1 class="heading">Placed orders 
      <?php 
      if (isset($_GET['user_id'])) {
         $name = $_GET['name'];
         echo " : <span class='name'>$name</span>";

         $total_completed = 0;
         $select_completed = $conn->prepare("SELECT total_price FROM `orders` WHERE user_id = ? AND payment_status = ? ORDER BY placed_on DESC");
         $select_completed->execute([$_GET['user_id'], 'completed']);
         while ($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)) {
            $total_completed += $fetch_completed['total_price'];
         }
         echo "<br><span class='total'>Total spent: <span>$$total_completed/-</span></span>";
      }
      ?>
   </h1>

   

   <div class="box-container">
      <?php 
         if (isset($_GET['user_id'])) {
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY placed_on DESC");
            $select_orders->execute([$_GET['user_id']]);
         }
         else {
            $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY placed_on DESC");
            $select_orders->execute();
         }

         if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>

      <div class="box">
         <p> User ID : <span><?= $fetch_orders['user_id']; ?></span></p>
         <p> Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
         <p> Name : <span><?= $fetch_orders['name']; ?></span></p>
         <p> Email : <span><?= $fetch_orders['email']; ?></span></p>
         <p> Address : <span><?= $fetch_orders['address']; ?></span></p>
         <p> Total products : <span><?= $fetch_orders['total_products']; ?></span></p>
         <p> Total price : <span>$<?= $fetch_orders['total_price']; ?>\-</span></p>
         <p> Method : <span style="text-transform:capitalize;"><?= $fetch_orders['method']; ?></span></p>
         <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <input type="hidden" name="old_status" value="<?= $fetch_orders['payment_status']; ?>">
            <select name="payment_status" class="drop-down" required style="text-transform:capitalize;">
               <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">Pending</option>
               <option value="completed">Completed</option>
            </select>

            <div class="flex-btn">
               <input type="submit" value="update" class="btn" name="update_payment">
               <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
            </div>
         </form>
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

<!-- Placed orders section endss -->



<!-- Custom js file link -->
<script src="../js/admin_script.js"></script>
   
</body>
</html>