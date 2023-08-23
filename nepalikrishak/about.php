<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="about">

      <div class="row">

         <div class="image">
            <img src="images/about-img.svg" alt="">
         </div>

         <div class="content">
            <h3>why choose us?</h3>
            <p>Choose us as your agricultural e-commerce destination for a seamless shopping experience. With our wide range of high-quality products, convenient browsing, and user-friendly interface, finding the right tools, equipment, fertilizers, and reproductive seeds has never been easier. We prioritize product quality and offer competitive pricing, ensuring you get the best value for your investment. Our dedicated customer service team is ready to assist you, providing prompt and friendly support. Trust us to meet your farming needs and elevate your agricultural practices with confidence.</p>
            <a href="contact.php" class="btn">contact us</a>
         </div>

      </div>

   </section>

   <section class="reviews">

      <h1 class="heading">client's reviews</h1>

      <div class="swiper reviews-slider">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide">
               <img src="images/pic-1.png" alt="">
               <p>This agricultural e-commerce website is a farmer's dream come true. With its user-friendly interface, I easily found a wide range of high-quality equipment, tools, fertilizers, and reproductive seeds. The competitive pricing and frequent discounts helped optimize my farming budget. I highly recommend this platform to fellow farmers for all their agricultural needs.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Hari Bahadur Lamsal</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-2.png" alt="">
               <p>Discover the ultimate agricultural e-commerce hub, where farmers thrive. This platform offers a seamless experience, with a vast selection of agricultural priorities. Competitive pricing and efficient delivery make it a go-to for cost-conscious farmers. Embrace the future of farming and unlock your full potential with this exceptional online resource.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Fulmaya Tamang</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-3.png" alt="">
               <p>Revolutionize your farming experience with our cutting-edge agricultural e-commerce platform. Explore a diverse range of high-quality facilities all at your fingertips. Enjoy competitive prices, swift delivery, and unparalleled customer service. Elevate your farming journey with us and achieve outstanding results.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Jagatman Rai</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-4.png" alt="">
               <p>Unleash your farming potential with our premier agricultural e-commerce destination. Experience seamless transactions, prompt delivery, and exceptional customer support. Elevate your farming game with confidence and convenience.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Rama Bhattrai</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-5.png" alt="">
               <p>Experience farming excellence with our premier agricultural e-commerce platform. Discover a vast selection of top-quality products. Benefit from competitive prices, fast delivery, and exceptional customer service. Elevate your farming practices and achieve remarkable results with us. Start exploring today and unlock your farm's full potential.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Krishna Shah</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/pic-6.png" alt="">
               <p>Transform your farming journey with our agricultural e-commerce haven. Explore a range of superior supplies with knowledge. Enjoy cost-effective prices, swift delivery, and exceptional support. Elevate your farming endeavors and reap the rewards. Unleash your farm's true potential now.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Juna Pandey</h3>
            </div>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>


   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            768: {
               slidesPerView: 2,
            },
            991: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>