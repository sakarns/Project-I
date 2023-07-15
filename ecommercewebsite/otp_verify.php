<?php

include 'components/connect.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $select_user = $conn->prepare("SELECT email FROM `users` WHERE user_id = ?");
    $select_user->execute([$user_id]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $email = $row['email'];
    } else {
        // handle case where user_id is not found or email is missing
        $email = '';
    }
} else {
   $user_id = '';
   $email = '';
};
?>

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
         <input type="email" name="otpemail" readonly class="box" value="<?php echo $email; ?>">
         <input type="text" name="otp_verify" required placeholder="enter otp from email" maxlength="6" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Submit" class="btn" name="otp_verify">
         <p>don't have an account?</p>
         <a href="user_login.php" class="option-btn">login now</a>
      </form>

   </section>


   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>