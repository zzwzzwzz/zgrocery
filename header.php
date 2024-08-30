<header class="header">

   <div class="flex">

      <a href="index.php" class="logo">ZGROCERY.</a>

      <nav class="navbar">

            <div class="search-form">
            <form action="search_page.php" method="POST">
               <input type="text" class="box" name="search_box" placeholder="e.g. apple">
               <input type="submit" name="search_btn" value="search" class="btn">
            </form>
            </div>

      </nav>

      <div class="icons">
         <div class="dropdown">
            <a class="fas fa-bars"><span> Category</span></a>
            <div class="dropdown-content">
               <a href="category.php?category=fruits">> Fruits</a>
               <a href="category.php?category=vegetables">> Vegetables</a>
               <a href="category.php?category=meat">> Meat</a>
               <a href="category.php?category=others">> Others</a>
            </div>
         </div>
         
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