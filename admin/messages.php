<?php 

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_messages->execute([$delete_id]);
   header('location:messages.php');
}

if (isset($_POST['resolve'])) {
   $msg_id = $_POST['msg_id'];
   $resolve_message = $conn->prepare("UPDATE `messages` SET resolved = ? WHERE id = ?");
   $resolve_message->execute([true, $msg_id]);
   $message[] = 'Message has been resolved.';
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Messages section starts  -->

<section class="messages">
   <h1 class="heading">New messages</h1>

   <div class="box-container">
      <?php 
         $select_messages = $conn->prepare("SELECT * FROM `messages` ORDER BY sent_on DESC");
         $select_messages->execute();
         if ($select_messages->rowCount() > 0) {
            while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
      ?>

      <div class="box <?= $fetch_messages['resolved'] ? 'resolved' : ''; ?>">
         <p> User ID : <span><?= $fetch_messages['user_id'] ?></span></p>
         <p> Name : <span><?= $fetch_messages['name'] ?></span></p>
         <p> Number : <span><?= $fetch_messages['number'] ?></span></p>
         <p> Email : <span><?= $fetch_messages['email'] ?></span></p>
         <p> Message : <span><?= $fetch_messages['message'] ?></span></p>
         <p> Sent at : <span><?=substr($fetch_messages['sent_on'], 0, -3) ?></span></p>

         <form action="" method="POST">
            <div class="flex-btn">
               <input type="hidden" name="msg_id" value="<?= $fetch_messages['id'] ?>">
               <input type="submit" disabled value="Resolve" class="btn" name="resolve">
               <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Delete this message?');">Delete</a>
            </div>
         </form>
      </div>

      <?php

            }
         }
         else {
            echo '<p class="empty">You have no messages.</p>';
         }
      ?>
   </div>
</section>

<!-- Messages section ends  -->



<!-- Custom js file link -->
<script src="../js/admin_script.js"></script>
   
</body>
</html>