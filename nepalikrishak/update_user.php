<?php

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
   $username = $_POST['username'];
   $username = filter_var($username, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET username = ?, name = ?, email = ?, address = ? WHERE id = ?");
   $update_profile->execute([$username, $name, $email, $address, $user_id]);
   header('location:home.php');
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
         <h3>update now</h3>
         <input type="text" name="username" required placeholder="enter your username" maxlength="20" class="box" value="<?= $fetch_profile["username"]; ?>">
         <input type="text" name="name" required placeholder="enter your name" maxlength="20" class="box" value="<?= $fetch_profile["name"]; ?>">
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
         <select id="address" name="address" required class="box">
            <option selected disabled><?= $fetch_profile["address"]; ?></option>
            <?php
            foreach ($districts as $district) {
               $selected = $district == $fetch_profile["address"] ? 'selected' : '';
               echo "<option value='$district' $selected>$district</option>";
            }
            ?>
         </select>
         <input type="submit" value="update now" class="btn" name="submit">
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