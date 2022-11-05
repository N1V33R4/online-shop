<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['add_category'])) {
   
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $icon = $_FILES['icon']['name'];
   $icon = filter_var($icon, FILTER_SANITIZE_STRING);
   $icon_size = $_FILES['icon']['size'];
   $icon_tmp_name = $_FILES['icon']['tmp_name'];
   $icon_folder = '../uploaded_img/'.$icon;
   
   $select_categories = $conn->prepare("SELECT * FROM `categories` WHERE name = ?");
   $select_categories->execute([$name]);

   if ($select_categories->rowCount() > 0) {
      $message[] = 'Category already exists!';
   }
   else {

      if ($icon_size > 2000000) {
         $message[] = 'Image size is too large.';
      } 
      else {
         move_uploaded_file($icon_tmp_name, $icon_folder);

         $insert_category = $conn->prepare("INSERT INTO `categories` (name, icon) VALUES (?, ?)");
         $insert_category->execute([$name, $icon]);

         $message[] = 'New category added!';
      }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   
   $delete_category_icon = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
   $delete_category_icon->execute([$delete_id]);
   $fetch_delete_icon = $delete_category_icon->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_icon['icon']);

   $delete_category = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
   $delete_category->execute([$delete_id]);

   $update_products = $conn->prepare("UPDATE `products` SET category_id = NULL where category_id = ?");
   $update_products->execute([$delete_id]);

   header('location:categories.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categories</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- Add categories section starts -->

   <section class="add-products add-categories">

      <h1 class="heading">Add category</h1>
      <form action="" method="POST" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputBox">
               <span>Product name (required)</span>
               <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box">
            </div>
            <div class="inputBox">
               <span>Icon (required)</span>
               <input type="file" name="icon" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
            </div>
            <input type="submit" value="Add category" name="add_category" class="btn">
         </div>
      </form>

   </section>

   <!-- Add categories section ends -->


   <!-- Show categories section starts  -->

   <section class="show-products show-categories">

      <h1 class="heading">Categories added</h1>

      <div class="box-container">

         <?php
            $show_categories = $conn->prepare("SELECT * FROM `categories` ORDER BY name ASC");
            $show_categories->execute();
            if ($show_categories->rowCount() > 0) {
               while ($fetch_categories = $show_categories->fetch(PDO::FETCH_ASSOC)) {
         ?>
         
         <div class="box">
            <img src="../uploaded_img/<?= $fetch_categories['icon']; ?>" alt="">
            <div class="name"></div>
            <h3><?= $fetch_categories['name']; ?></h3>
            <div class="flex-btn">
               <a href="update_category.php?update=<?= $fetch_categories['id']; ?>" class="option-btn">Update</a>
               <a href="categories.php?delete=<?= $fetch_categories['id']; ?>" class="delete-btn" onclick="return confirm('Delete this category?');">Delete</a>
            </div>
         </div>

         <?php
               }
            }
            else {
               echo '<p class="empty">No categories added yet!</p>';
            }
         ?>
      </div>

   </section>

   <!-- Show categories section ends  -->



   <!-- Custom js file link -->
   <script src="../js/admin_script.js"></script>

</body>

</html>