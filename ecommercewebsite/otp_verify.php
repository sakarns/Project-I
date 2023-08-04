<?php include 'components/connect.php';
session_start();
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
if (isset($_POST['verify_otp'])) {
   $otp = $_POST['otp'];
   $otp = filter_var($otp, FILTER_SANITIZE_STRING);
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select_user->execute([$user_id]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   if ($row['emailOtp'] == $otp) {
      $update_user = $conn->prepare("UPDATE `users` SET isEmailVerify = 1 WHERE id = ?");
      $update_user->execute([$user_id]);
      header("Location: user_login.php");
   } else {
      $message = "Invalid OTP!";
   }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OTP Verification Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>OTP Verification</h3>
         <input readonly class="box" value="<?php echo $row['email']; ?>">
         <input type="text" name="otp" id="otp" required placeholder="enter otp from email" maxlength="6" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Verify OTP" class="btn" name="verify_otp">
      </form>

   </section>


   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>
