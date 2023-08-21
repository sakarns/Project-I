<body>
<section class="category">

<h1 class="heading">shop by category</h1>

<div class="swiper category-slider">

   <div class="swiper-wrapper">

      <a href="category.php?category=chemical-fertilizer" class="swiper-slide slide">
         <img src="images/home-icon-fertilizer.png" alt="">
         <h3>Chemical Fertilizer</h3>
      </a>

      <a href="category.php?category=insecticides" class="swiper-slide slide">
         <img src="images/home-icon-insecticides.webp" alt="">
         <h3>Insecticides</h3>
      </a>

      <a href="category.php?category=pesticides" class="swiper-slide slide">
         <img src="images/home-icon-pesticides.png" alt="">
         <h3>Pesticides</h3>
      </a>

      <a href="category.php?category=gardening-tools" class="swiper-slide slide">
         <img src="images/home-icon-guardening-tools.png" alt="">
         <h3>Gardening Tools</h3>
      </a>

      <a href="category.php?category=agricultural-equipments" class="swiper-slide slide">
         <img src="images/home-icon-agricultural-equipments.png" alt="">
         <h3>Agricultural Equipments</h3>
      </a>

      <a href="category.php?category=protective-gears" class="swiper-slide slide">
         <img src="images/home-icon-protective-gears.webp" alt="">
         <h3>Protective Gears</h3>
      </a>

      <a href="category.php?category=reproductive-seeds" class="swiper-slide slide">
         <img src="images/home-icon-reprodutive-seeds.webp" alt="">
         <h3>Reproductive Seeds</h3>
      </a>

      <a href="category.php?category=reproductive-fruits" class="swiper-slide slide">
         <img src="images/home-icon-reproductive-fruits.webp" alt="">
         <h3>Reproductive Fruits</h3>
      </a>

      <a href="category.php?category=reproductive-vegetable" class="swiper-slide slide">
         <img src="images/home-icon-reproductive-vegetables.webp" alt="">
         <h3>Reproductive Vegetables</h3>
      </a>

   </div>

   <div class="swiper-pagination"></div>

</div>

</section>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

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
