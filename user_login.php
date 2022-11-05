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
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $pass = filter_var((sha1($_POST['pass'])), FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   
   if ($select_user->rowCount() > 0) {
      $row = $select_user->fetch(PDO::FETCH_ASSOC);
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
      // $message[] = 'Login success!';
   }
   else 
      $message[] = 'Incorrect email or password.';
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User login</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Login to our services to use our wishlist and cart features.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- User login section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Login now</h3>
      <input type="email" required maxlength="50" name="email" placeholder="Enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" required maxlength="50" name="pass" placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
      <p>Don't have an account?</p>
      <a href="user_register.php" class="option-btn">Register now</a>
   </form>

</section>

<!-- User login section ends  -->





<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>