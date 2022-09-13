<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update'])) {
   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   $message[] = 'Product updated!';

   for ($i = 0; $i < 3; $i++) {
      $img_no = 'image_0' . $i + 1;
      $old_image = $_POST['old_'.$img_no];
      $image = $_FILES[$img_no]['name'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $image_size = $_FILES[$img_no]['size'];
      $image_tmp_name = $_FILES[$img_no]['tmp_name'];
      $image_folder = '../uploaded_img/' . $image;

      if (!empty($image)) {
         if ($image_size > 2000000) {
            $message[] = 'Image sizes are too large!';
         } else {
            $update_image = $conn->prepare("UPDATE `products` SET $img_no = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/' . $old_image);
            $message[] = $img_no . ' updated!';
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
   <title>Update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- Update product section starts  -->

   <section class="update-product">
      <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $show_products->execute([$update_id]);
      if ($show_products->rowCount() > 0) {
         while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
      ?>

            <form action="" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $fetch_products['id'] ?>">
               <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01'] ?>">
               <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02'] ?>">
               <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03'] ?>">

               <div class="image-container">
                  <div class="main-image">
                     <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  </div>
                  <div class="sub-images">
                     <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                     <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                     <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
                  </div>
               </div>

               <span>Update name</span>
               <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
               <span>Update price</span>
               <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" onkeydown="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
               <span>Update details</span>
               <textarea name="details" class="box" placeholder="Enter product details" required maxlength="500" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
               
               <span>Update image 01</span>
               <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
               <span>Update image 02</span>
               <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
               <span>Update image 03</span>
               <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">

               <div class="flex-btn">
                  <input type="submit" value="update" class="btn" name="update">
                  <a href="products.php" class="option-btn">Go back</a>
               </div>
            </form>

      <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>
   </section>

   <!-- Update product section ends  -->



   <!-- Custom js file link -->
   <script src="../js/admin_script.js"></script>

</body>

</html>