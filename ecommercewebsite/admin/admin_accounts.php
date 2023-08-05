<?php
ini_set('display_errors', 1);
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (isset($_GET['action']) && isset($_GET['user_id'])) {
   $action = $_GET['action'];
   $user_id = $_GET['user_id'];

   if ($action == 'accept') {
      // Update hasAdminAccount to 1 in users table
      $update_user = $conn->prepare("UPDATE `users` SET hasAdminAccount = 1 WHERE id = ?");
      $update_user->execute([$user_id]);
   } elseif ($action == 'decline') {
      // Update designation to "user" in users table
      $update_user = $conn->prepare("UPDATE `users` SET designation = 'user' WHERE id = ?");
      $update_user->execute([$user_id]);
   }
   header('location:admin_accounts.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="accounts">

      <h1 class="heading">admin accounts</h1>

      <div class="box-container">

         <div class="box">
            <p>add new admin</p>
            <a href="register_admin.php" class="option-btn">register admin</a>
         </div>

         <?php
         $select_accounts = $conn->prepare("SELECT u.id, u.name, a.username, a.password FROM `users` u LEFT JOIN `admins` a ON u.id = a.userID WHERE u.designation = 'admin' AND u.hasAdminAccount = '0'");
         $select_accounts->execute();

         if ($select_accounts->rowCount() > 0) {
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <p> user id: <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> user name: <span><?= $fetch_accounts['name']; ?></span> </p>
                  <p> username: <span><?= $fetch_accounts['username']; ?></span> </p>
                  <p> password: <span><?= $fetch_accounts['password']; ?></span> </p>
                  <div class="flex-btn">
                     <a href="admin_accounts.php?action=accept&user_id=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Accept this user as admin?')" class="option-btn">Accept</a>
                     <a href="admin_accounts.php?action=decline&user_id=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Decline this user as admin?')" class="delete-btn">Decline</a>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no accounts available!</p>';
         }
         ?>

         <?php
         $select_accounts = $conn->prepare("SELECT id, username FROM `admins` WHERE userID = 0 OR userID IN (SELECT id FROM `users` WHERE hasAdminAccount = 1)");
         $select_accounts->execute();

         if ($select_accounts->rowCount() > 0) {
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <p> admin id: <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> username: <span><?= $fetch_accounts['username']; ?></span> </p>
                  <div class="flex-btn">
                     <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this account?')" class="delete-btn">Delete</a>
                     <?php
                     if ($fetch_accounts['id'] == $admin_id) {
                        echo '<a href="update_profile.php" class="option-btn">Update</a>';
                     }
                     ?>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No accounts available!</p>';
         }
         ?>

      </div>

   </section>

   <script src="../js/admin_script.js"></script>

</body>

</html>