<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}
else {
   $user_id = '';
}

if (isset($_POST['submit'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $pass = filter_var((sha1($_POST['pass'])), FILTER_SANITIZE_STRING);
   $cpass = filter_var((sha1($_POST['cpass'])), FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   // $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if ($select_user->rowCount() > 0) {
      $message[] = 'Email already has an account!';
   }
   else {

      if ($pass != $cpass) {
         $message[] = 'Confirm password does not match!';
      }
      else {
         $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES (?, ?, ?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'New user successfully registered! Please login.';
      }
   }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User register</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Create an account with us today to add items to cart, wishlist and place orders.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>


<!-- User register section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Register now</h3>
      <input type="text" required maxlength="20" name="name" placeholder="Enter your name" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="email" required maxlength="50" name="email" placeholder="Enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" required maxlength="50" name="pass" placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" required maxlength="50" name="cpass" placeholder="Confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>Already have an account?</p>
      <a href="user_login.php" class="option-btn">Login now</a>
   </form>

</section>

<!-- User register section ends  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>