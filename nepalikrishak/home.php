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
   <title>home</title>
   <!-- Swiper link -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <div class="home-bg">

      <section class="home">

         <div class="swiper home-slider">

            <div class="swiper-wrapper">

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/Agricultural Hand Gloves For Industrial Use.png" alt="">
                  </div>
                  <div class="content">
                     <span>upto 50% off</span>
                     <h3>Protective gloves</h3>
                     <a href="shop.php" class="btn">shop now</a>
                  </div>
               </div>

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/Appron.jpg" alt="">
                  </div>
                  <div class="content">
                     <span>upto 50% off</span>
                     <h3>Protective Appron</h3>
                     <a href="shop.php" class="btn">shop now</a>
                  </div>
               </div>

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/Dust Mask-Chinese.jpg" alt="">
                  </div>
                  <div class="content">
                     <span>upto 50% off</span>
                     <h3>Protective Mask</h3>
                     <a href="shop.php" class="btn">shop now</a>
                  </div>
               </div>

            </div>

         </div>

      </section>

   </div>

   <?php include 'category_slide.php'; ?>

   <section class="home-products">

      <h1 class="heading">latest products</h1>

      <div class="swiper products-slider">
         <div class="swiper-wrapper">
            <?php
            // Fetch all categories
            $select_categories = $conn->query("SELECT DISTINCT category FROM products")->fetchAll(PDO::FETCH_COLUMN);

            foreach ($select_categories as $category) {
               $select_products = $conn->prepare("SELECT * FROM products WHERE category = :category ORDER BY RAND() LIMIT 1");
               $select_products->bindParam(':category', $category);
               $select_products->execute();
               if ($select_products->rowCount() > 0) {
                  while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                     <div class="swiper-slide slide">
                        <form action="" method="post">
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
                     </div>
            <?php
                  }
               } else {
                  echo '<p class="empty">no products added yet!</p>';
               }
            }
            ?>
         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>

   <?php include 'components/footer.php'; ?>

   <script>
      var swiper = new Swiper(".home-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
      });

      var swiper = new Swiper(".category-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 2,
            },
            650: {
               slidesPerView: 3,
            },
            768: {
               slidesPerView: 4,
            },
            1024: {
               slidesPerView: 5,
            },
         },
      });

      var swiper = new Swiper(".products-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            550: {
               slidesPerView: 2,
            },
            768: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>