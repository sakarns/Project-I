<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $message[] = 'email already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm password not matched!';
      } else {
         // Generate a random 6-digit OTP
         $otp = rand(100000, 999999);

         // Send the OTP to the user's email
         $mail = new PHPMailer(true);
         try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'your_email@gmail.com';                     //SMTP username
            $mail->Password   = 'your_email_password';                               //SMTP password
            $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    //TCP port to connect to

            //Recipients
            $mail->setFrom('your_email@gmail.com', 'Your Name');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'OTP for registration';
            $mail->Body    = "Your OTP is: $otp";

            $mail->send();
            $message[] = 'OTP sent to your email address';
         } catch (Exception $e) {
            $message[] = 'Error sending email: ' . $mail->ErrorInfo;
         }

         // Store the OTP in the session for validation
         $_SESSION['otp'] = $otp;

         // Store the user's details in the database
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'registered successfully, please enter the OTP received on your email to verify your account!';
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
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="form-container">

      <?php
      if (isset($message)) {
         foreach ($message as $msg) {
            echo "<div class='message'>$msg</div>";
         }
      }
      ?>

      <form action="" method="post">
         <h3>register now</h3>
         <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirm password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="text" name="otp" required placeholder="enter the OTP received on your email" maxlength="6" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <button type="submit" name="submit" class="btn">register</button>
      </form>

      <p>already have an account? <a href="login.php">login here</a></p>

   </section>

   <!-- jquery cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>