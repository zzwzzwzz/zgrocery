<?php

@include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.ico">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="img/about-img-1.png" alt="">
         <h3>Why choose us?</h3>
         <p>Based in Sydney, our online grocery store specializes in providing organic and healthy food options. We're dedicated to offering a wide range of sustainably sourced products, from fresh produce to pantry staples and ethically raised meats. With a focus on quality, integrity, and convenience, we aim to make healthy eating accessible to everyone. More than just a store, we're a community of like-minded individuals committed to wellness and sustainability. Join us in making positive choices for your health and the planet. Welcome to a world of wholesome goodness, right at your fingertips.</p>
         <a href="index.php" class="btn">Shop Now</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Clients Reivews</h1>

   <div class="box-container">

      <div class="box">
         <img src="img/pic-1.jpg" alt="">
         <p>I've been shopping at this organic grocery store for years, and I can't say enough good things about it! Plus, the staff is always friendly and helpful. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Alex Depp</h3>
      </div>

      <div class="box">
         <img src="img/pic-2.jpg" alt="">
         <p>The organic options here are top-notch, and I appreciate that they source locally whenever possible. The prices are reasonable for the quality you're getting!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Mary Deo</h3>
      </div>

      <div class="box">
         <img src="img/pic-3.jpg" alt="">
         <p>The variety of organic products available is impressive, from pantry staples to specialty items. I also appreciate their commitment to eco-friendly practices.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>John Smith</h3>
      </div>

   </div>

</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>