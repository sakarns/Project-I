<?php

include 'components/connect.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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

   //Generating 6 Digit Random OTP
   $otp = mt_rand(100000, 999999);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   //Create an instance; passing `true` enables exceptions
   $mail = new PHPMailer(true);

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Invalid email address!';
   } else if ($select_user->rowCount() > 0) {
      $message[] = 'Email already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirm password does not match!';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password, emailOTP) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $cpass, $otp]);
         try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'mainalisakar222@gmail.com';                     //SMTP username
            $mail->Password   = 'xtjioswjjqxvdauc';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mainalisakar222@gmail.com', 'Sakar');
            $mail->addAddress($email, $name);     //Add a recipient
            $mail->addReplyTo('mainalisakar222@gmail.com', 'Sakar');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'OTP verification for Registration !!!';
            $mail->Body    = 'Dear ' . $name . ',<br>
            Thank you for registering at nepalikrisak.com.np<br>
            Please use the following OTP to complete your registration:<br><br>
            OTP: <b>' . $otp . '</b><br><br>
            If you have any questions or need further assistance, please feel free to contact us.<br><br>
            Best regards,<br>
            nepalikrishak.com.np';

            $mail->send();
            echo 'Message has been sent.';
         } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         }
         header('location:otp_verify.php?' . $user_id);
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

      <form action="" method="post">
         <h3>register now</h3>
         <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="register now" class="btn" name="submit">
         <p>already have an account?</p>
         <a href="user_login.php" class="option-btn">login now</a>
      </form>

   </section>


   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>