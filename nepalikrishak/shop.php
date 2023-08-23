<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- Swiper link -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <?php include 'category_slide.php'; ?>

   <section class="products">
      <h1 class="heading">latest products
         <div class="option-bar ">
            <form action="" method="post">
               <select name="sort" required style="width: 20%; display: inline-block;" class="btn" onchange="this.form.submit()">
                  <option value="">Sort By</option>
                  <option value="1">A-Z</option>
                  <option value="2">Z-A</option>
                  <option value="3">Lower Price</option>
                  <option value="4">Higher Price</option>
               </select>
            </form>
         </div>
      </h1>
      <div class="box-container">

         <?php

         $sortOption = $_POST['sort'] ?? 'default';
         $orderClause = '';

         switch ($sortOption) {
            case '1':
               $orderClause = "`name` ASC";
               break;
            case '2':
               $orderClause = "`name` DESC";
               break;
            case '3':
               $orderClause = "`price` ASC";
               break;
            case '4':
               $orderClause = "`price` DESC";
               break;
            default:
               $orderClause = "`id` DESC";
         }

         $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY $orderClause");
         $select_products->execute();

         if ($select_products->rowCount() > 0) {
            while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <form action="" method="post" class="box">
                  <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                  <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                  <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                  <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                  <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                  <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                  <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                  <div class="name"><?= $fetch_product['name']; ?></div>
                  <div class="flex">
                     <div class="price"><span>Rs.</span><?= $fetch_product['price']; ?><span>/-</span></div>
                     <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                  </div>
                  <input type="submit" value="add to cart" class="btn" name="add_to_cart">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no products found!</p>';
         }
         ?>

      </div>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>