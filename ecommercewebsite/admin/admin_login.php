<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {

   $name = $_POST['username'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE username = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($select_admin->rowCount() > 0) {
      $admin_id = $row['id'];
      // Check user table for admin designation and hasAdminAccount value
      $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? AND designation = 'admin' AND hasAdminAccount = 1");
      $select_user->execute([$admin_id]);
      $user_row = $select_user->fetch(PDO::FETCH_ASSOC);
      if ($user_row || $row['userID'] === 0) {
         $_SESSION['admin_id'] = $admin_id;
         header('location:dashboard.php');
         exit();
      } else {
          $message[] = 'You are not authorized to login as an admin.';
      }
  } else {
      $message[] = 'Incorrect username or password!';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>login now</h3>
         <p>default username = <span>admin</span> & password = <span>111</span></p>
         <input type="text" name="username" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="login now" class="btn" name="submit">
      </form>

   </section>

</body>

</html>