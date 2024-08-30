<header class="header">

   <div class="flex">

      <a href="index.php" class="logo">ZGROCERY.</a>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` ");
            $count_cart_items->execute();
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist`");
            $count_wishlist_items->execute();
         ?>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
      </div>

   </div>

</header>

<!-- Display messages -->
<?php
if(isset($message)){
   foreach($message as $msg){
      echo '<div class="empty">'.$msg.'</div>';
   }
}
?>
