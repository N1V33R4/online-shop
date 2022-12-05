<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['submit'])) {
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $desc = $_POST['desc'];
   $desc = filter_var($desc, FILTER_SANITIZE_STRING);
   $keywords = $_POST['keywords'];
   $keywords = filter_var($keywords, FILTER_SANITIZE_STRING);

   $update_seo = $conn->prepare("UPDATE `seo` SET title = ?, description = ?, keywords = ?  WHERE id = 1");
   $update_seo->execute([$title, $desc, $keywords]);
   $message[] = 'SEO data updated successfully!';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SEO</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- Admin update profile section starts -->

   <section class="form-container seo">

      <h1 class="heading">Update SEO</h1>

      <form action="" method="POST">
         <?php 
            $select_seo = $conn->prepare("SELECT * FROM `seo`");
            $select_seo->execute();
            if ($select_seo->rowCount() > 0) {
               $fetch_seo = $select_seo->fetch(PDO::FETCH_ASSOC);
            }
         ?>
         <span>Title</span>
         <input type="text" name="title" maxlength="100" required placeholder="Enter seo title" class="box" value="<?= $fetch_seo['title']; ?>">
         <span>Description</span>
         <textarea name="description" class="box" placeholder="Enter seo description" required maxlength="500" cols="30" rows="3"><?= $fetch_seo['description']; ?></textarea>

         <span>Keywords <small>(comma-separated)</small></span>
         <textarea name="keywords" class="box" placeholder="Enter seo keywords" required maxlength="500" cols="30" rows="5"><?= $fetch_seo['keywords']; ?></textarea>
         <input type="submit" value="update now" name="submit" class="btn">

      </form>

   </section>

   <!-- Admin update profile section ends -->


   <!-- Custom js file link -->
   <script src="../js/admin_script.js"></script>

</body>

</html>