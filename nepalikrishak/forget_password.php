<?php

include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

include 'components/wishlist_cart.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    // Generating 8 Digit Random Password
    $pwd = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);

    $select_user = $conn->prepare("SELECT `email`, `name`, `username` FROM `users` WHERE `username` = ? AND `email` = ?");
    $select_user->execute([$username, $email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $email = $row['email'];
        $name = $row['name'];
        $username = $row['username'];

        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $update_profile = $conn->prepare("UPDATE `users` SET  password = ? WHERE username = ?");
        $update_profile->execute([sha1($pwd), $username]);

        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'mainalisakar222@gmail.com';             // SMTP username
            $mail->Password   = 'xtjioswjjqxvdauc';                      // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom('mainalisakar222@gmail.com', 'Sakar');
            $mail->addAddress($email, $name);     // Add a recipient
            $mail->addReplyTo('mainalisakar222@gmail.com', 'Sakar');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'password changed !!!';
            $mail->Body    = 'Dear ' . $name . ',<br>
               We recommend changing your password immediately for security purposes after login:<br><br>
               Username: <b>' . $username . '</b><br>
               Password: <b>' . $pwd . '</b><br><br>
               If you have any questions or need further assistance, please feel free to contact us.<br><br>
               Best regards,<br>
               nepalikrishak.pvt.ltd';

            $mail->send();
            header('location:user_login.php');
        } catch (Exception $e) {
            $message[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message[] = 'Invalid username or email.';
    }
}
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
            <h3>Forget Password</h3>
            <input type="text" name="username" required placeholder="enter your username" maxlength="20" class="box">
            <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Send Password" class="btn" name="submit">
        </form>

    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>