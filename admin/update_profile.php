<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];

   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   // $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   // $update_name->execute([$name, $admin_id]);

   if ($old_pass == $empty_pass)
      $message[] = 'Please enter old password!';
   else if ($old_pass != $prev_pass)
      $message[] = 'Old password does not match!';
   else if ($new_pass != $confirm_pass)
      $message[] = 'Confirm password does not match!';
   else {
      if ($new_pass != $empty_pass) {
         $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_pass->execute([$confirm_pass, $admin_id]);
         $message[] = 'Password updated successfully!';
      } else
         $message[] = 'Please enter new password!';
   }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile update</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- Admin update profile section starts -->

   <section class="form-container">
      <form action="" method="POST">
         <h3>Update profile</h3>
         <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
         <input type="text" name="name" maxlength="20" required placeholder="Enter your Username" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name']; ?>">
         <input type="password" name="old_pass" maxlength="20" placeholder="Enter your old Password" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
         <input type="password" name="new_pass" maxlength="20" placeholder="Enter your new Password" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
         <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirm your new Password" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
         <input type="submit" value="update now" name="submit" class="btn">

      </form>

   </section>

   <!-- Admin update profile section ends -->


   <!-- Custom js file link -->
   <script src="../js/admin_script.js"></script>

</body>

</html>