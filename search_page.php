<?php

@include 'config.php';
@include 'add_to_wishlist.php';
@include 'add_to_cart.php';

session_start();

if(isset($_POST['search_btn'])){
   $search_box = trim($_POST['search_box']);
   if(!empty($search_box)){
      $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
      $_SESSION['search_box'] = $search_box;
   } else {
      $message[] = 'Please enter a search term.';
      unset($_SESSION['search_box']);
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Results</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.ico">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="search_page" style="margin-top: 2rem; padding-top: 0; min-height:100vh;">

<div class="box-container">
      <?php
      if(isset($_SESSION['search_box'])){
         $search_box = $_SESSION['search_box'];
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
         $select_products->execute();
         
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
               $in_stock = $fetch_products['quantity'] > 0;
      ?>
      <form action="search_page.php" class="box" method="POST">
         <input type="hidden" name="search_box" value="<?= $_SESSION['search_box']; ?>">
         <div class="price">$<span><?= $fetch_products['price']; ?></span>/<span><?= $fetch_products['unit']; ?></span></div>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <div class="name"><?= $fetch_products['name']; ?></div>
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="p_unit" value="<?= $fetch_products['unit']; ?>">
         <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
         <input type="number" min="1" value="1" name="p_qty" class="qty">
         <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
         <input type="submit" value="<?= $in_stock ? "add to cart" : "out of stock" ?>" class="btn" name="add_to_cart" <?= $in_stock ? "" : "disabled" ?>>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">No results found!</p>';
         }
      }else{
         echo '<p class="empty">Please enter a search term.</p>';
      }
      ?>
   </div>

</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>