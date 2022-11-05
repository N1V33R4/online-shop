<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}
else {
   $user_id = '';
}

if (isset($_POST['send'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
   $number = $_POST['number'];

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);
   if ($select_message->rowCount() > 0) {
      $message[] = 'Message sent already!';
   }
   else {
      $send_message = $conn->prepare("INSERT INTO `messages` (name, email, number, message) VALUES (?, ?, ?, ?)");
      $send_message->execute([$name, $email, $number, $msg]);
      $message[] = 'Your message has been sent.';
   }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Contact us for any inquiries you may have. Our support will contact back in a few moments.">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- Contact section starts  -->

<section class="form-container">
   <h1 class="heading">Contact us</h1>

   <form action="" class="box" method="POST">
      <h3>Send us a message!</h3>

      <input type="text" name="name" required placeholder="Enter your name" maxlength="20" class="box">
      <input type="number" name="number" required placeholder="Enter your number" min="0" max="9999999999" class="box" onkeypress="if(this.value.length == 10) return false;">
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box">
      <textarea name="msg" required placeholder="Enter your message" class="box" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" class="btn" name="send">
   </form>

</section>

<!-- Contact section ends  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>