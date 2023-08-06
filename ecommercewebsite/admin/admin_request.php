<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
 } else {
    $user_id = '';
 }

$userID = $_SESSION['userID'];

if (!isset($userID)) {
    header('location:user_login.php');
} else {

    if (isset($_POST['submit'])) {

        $name = $_POST['username'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        $userID = $_POST['userID'];
        $UserID = filter_var($userID, FILTER_SANITIZE_STRING);

        $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE username = ?");
        $select_admin->execute([$name]);

        if ($select_admin->rowCount() > 0) {
            $message[] = 'username already exist!';
        } else {
            if ($pass != $cpass) {
                $message[] = 'confirm password not matched!';
            } else {
                $insert_admin = $conn->prepare("INSERT INTO `admins` (username, password, userID) VALUES (?, ?, ?)");
                $insert_admin->execute([$name, $cpass, $userID]);
                header('location:admin_login.php');
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
    <title>register admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>


<?php include '../components/admin_header.php'; ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>register now</h3>
            <label for="userID" style="font-size: 15px; margin-left: 150px;"> User ID: </label>
            <input type="text" readonly name="userID" value="<?php echo $userID; ?>">
            <input type="text" name="username" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" class="btn" name="submit">
        </form>

    </section>



    <script src="../js/admin_script.js"></script>

</body>

</html>