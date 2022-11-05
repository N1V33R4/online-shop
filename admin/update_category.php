<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update'])) {
   $cid = $_POST['cid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_category = $conn->prepare("UPDATE `categories` SET name = ? WHERE id = ?");
   $update_category->execute([$name, $cid]);

   $message[] = 'Category updated!';

   $old_icon = $_POST['old_icon'];
   $icon = $_FILES['icon']['name'];
   $icon = filter_var($icon, FILTER_SANITIZE_STRING);
   $icon_size = $_FILES['icon']['size'];
   $icon_tmp_name = $_FILES['icon']['tmp_name'];
   $icon_folder = '../uploaded_img/' . $icon;

   if (!empty($icon)) {
      if ($icon_size > 2000000) {
         $message[] = 'Icon size is too large!';
      } else {
         $update_icon = $conn->prepare("UPDATE `categories` SET icon = ? WHERE id = ?");
         $update_icon->execute([$icon, $cid]);
         move_uploaded_file($icon_tmp_name, $icon_folder);
         unlink('../uploaded_img/' . $old_icon);
         $message[] = 'Icon updated!';
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
   <title>Update category</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- Update category section starts  -->

   <section class="update-product">
      <?php
      $update_id = $_GET['update'];
      $show_categories = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
      $show_categories->execute([$update_id]);
      if ($show_categories->rowCount() > 0) {
         while ($fetch_categories = $show_categories->fetch(PDO::FETCH_ASSOC)) {
      ?>

            <form action="" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="cid" value="<?= $fetch_categories['id'] ?>">
               <input type="hidden" name="old_icon" value="<?= $fetch_categories['icon'] ?>">

               <div class="image-container">
                  <div class="main-image">
                     <img src="../uploaded_img/<?= $fetch_categories['icon']; ?>" alt="">
                  </div>
               </div>

               <span>Update name</span>
               <input type="text" required placeholder="Enter category name" name="name" maxlength="100" class="box" value="<?= $fetch_categories['name']; ?>">
               
               <span>Update icon</span>
               <input type="file" name="icon" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">

               <div class="flex-btn">
                  <input type="submit" value="update" class="btn" name="update">
                  <a href="categories.php" class="option-btn">Go back</a>
               </div>
            </form>

      <?php
         }
      } else {
         echo '<p class="empty">No categories added yet!</p>';
      }
      ?>
   </section>

   <!-- Update category section ends  -->



   <!-- Custom js file link -->
   <script src="../js/admin_script.js"></script>

</body>

</html>