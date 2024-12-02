<?php

include 'components/connect.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $username = $_POST['username'];
   $username = filter_var($username, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   // Generating 6 Digit Random OTP
   $otp = mt_rand(100000, 999999);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   // Create an instance; passing `true` enables exceptions
   $mail = new PHPMailer(true);

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Invalid email address!';
   } else if ($select_user->rowCount() > 0) {
      $message[] = 'Email already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirm password does not match!';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, username, password, address, emailOTP) VALUES(?,?,?,?,?,?)");
         $insert_user->execute([$name, $email, $username, $cpass, $address, $otp]);
         try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'example@gmail.com';             // SMTP username
            $mail->Password   = 'xtjioswjjqxvdauc';                      // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom('example@gmail.com', 'uname');
            $mail->addAddress($email, $name);     // Add a recipient
            $mail->addReplyTo('example222@gmail.com', 'Sakar');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'OTP verification for Registration !!!';
            $mail->Body    = 'Dear ' . $name . ',<br>
               Thank you for registering at NepaliKrishak.<br>
               Please use the following OTP to complete your registration:<br><br>
               For Username: <b>' . $username . '</b><br>
               OTP: <b>' . $otp . '</b><br><br>
               If you have any questions or need further assistance, please feel free to contact us.<br><br>
               Best regards,<br>
               nepalikrishak.pvt.ltd';

            $mail->send();
         } catch (Exception $e) {
            $message[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         }
         $_SESSION['email'] = $email;
         $_SESSION['user_id'] = $row['id'];
         header('location:otp_verify.php');
         exit();
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
         <input type="text" name="name" required placeholder="enter your fullname" maxlength="20" class="box">
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="text" name="username" required placeholder="enter unique username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <select id="address" name="address" required class="box">
            <option value="Kathnamdu" >Select District</option>
         </select>
         <input type="submit" value="register now" class="btn" name="submit">
         <p>already have an account?</p>
         <a href="user_login.php" class="option-btn">login now</a>
      </form>

   </section>


   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>
   <script>
      // Array of 77 districts in Nepal
      var districts = [
         "Achham", "Arghakhanchi", "Baglung", "Baitadi", "Bajhang", "Bajura", "Banke", "Bara", "Bardiya", "Bhaktapur", "Bhojpur",
         "Chitwan", "Dadeldhura", "Dailekh", "Dang", "Darchula", "Dhading", "Dhankuta", "Dhanusa", "Dolakha", "Dolpa", "Doti",
         "Gorkha", "Gulmi", "Humla", "Ilam", "Jajarkot", "Jhapa", "Jumla", "Kailali", "Kalikot", "Kanchanpur", "Kapilvastu", "Kaski",
         "Kathmandu", "Kavrepalanchok", "Khotang", "Lalitpur", "Lamjung", "Mahottari", "Makwanpur", "Manang", "Morang", "Mugu", "Mustang",
         "Myagdi", "Nawalparasi", "Nuwakot", "Okhaldhunga", "Palpa", "Panchthar", "Parbat", "Parsa", "Pyuthan", "Ramechhap", "Rasuwa",
         "Rautahat", "Rolpa", "Rukum", "Rupandehi", "Salyan", "Sankhuwasabha", "Saptari", "Sarlahi", "Sindhuli", "Sindhupalchok", "Siraha",
         "Solukhumbu", "Sunsari", "Surkhet", "Syangja", "Tanahun", "Taplejung", "Terhathum", "Udayapur"
      ];

      var addressSelect = document.getElementById("address");

      // Populate the dropdown options
      districts.forEach(function(district) {
         var option = document.createElement("option");
         option.value = district;
         option.text = district;
         addressSelect.appendChild(option);
      });
   </script>

</body>

</html>
