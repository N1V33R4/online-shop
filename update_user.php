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

if (isset($_POST['submit'])) 
{
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   
   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);
   $message[] = 'Updated name and email.';
   
   if ($_POST['old_pass'] != '' || $_POST['new_pass'] != '' || $_POST['cpass'] != '') 
   {
      $old_pass = filter_var((sha1($_POST['old_pass'])), FILTER_SANITIZE_STRING);
      $new_pass = filter_var((sha1($_POST['new_pass'])), FILTER_SANITIZE_STRING);
      $cpass = filter_var((sha1($_POST['cpass'])), FILTER_SANITIZE_STRING);
      
      $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
      $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
      $select_prev_pass->execute([$user_id]);
      $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
      $prev_pass = $fetch_prev_pass['password'];
      
      if ($old_pass == $empty_pass)
      $message[] = 'Please enter old password!';
      else if ($old_pass != $prev_pass) 
      $message[] = 'Old password does not match with previous one!';
      else if ($new_pass != $cpass)
      $message[] = 'Confirm password does not match!';
      else {
         if ($new_pass == $empty_pass) 
         $message[] = 'Please enter new password!';
         else {
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$cpass, $user_id]);
            $message[] = 'Password updated successfully!';
         }
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
   <title>Update profile</title>
   <meta name="author" content="Group 2">
   <meta name="description" content="Update your information of the profile you registered with us!">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<!-- Update user section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Update profile</h3>
      <input type="text" required maxlength="20" name="name" placeholder="Enter your name" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name'] ?>">
      <input type="email" required maxlength="50" name="email" placeholder="Enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['email'] ?>">

      <input type="password" maxlength="50" name="old_pass" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" maxlength="50" name="new_pass" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" maxlength="50" name="cpass" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>

<!-- Update user section ends  -->




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>