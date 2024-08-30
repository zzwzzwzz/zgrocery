<?php

@include 'config.php';

session_start();

// checkout.php can set this cookie to show a message
if(isset($_COOKIE['message'])) {
   $message[] = $_COOKIE['message'];
   setcookie("message", "", time() - 3600, "/");
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$delete_id]);
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart`");
   $delete_cart_item->execute();
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   // Query to prevent user from adding too much of an item
   $products_query = $conn->prepare("SELECT id, quantity FROM `products` ");
   $products_query->execute();
   // How much of each product is still available
   $available = array();
   if($products_query->rowCount() > 0){
      while($row = $products_query->fetch(PDO::FETCH_ASSOC)){
         $available[$row['id']] = $row['quantity'];
      }
   }

   $cart_id = $_POST['cart_id'];
   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $new_qty = $_POST['p_qty'];
   $new_qty = filter_var($new_qty, FILTER_SANITIZE_STRING);

   $extra_message = '';
   $reduced_from = null;
   if($new_qty > $available[$pid]) {
      $reduced_from = $new_qty;
      $new_qty = $available[$pid];
      $extra_message = ' Note: Only ' . $available[$pid] . ' in stock';
   }

   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$new_qty, $cart_id]);
   $message[] = 'Cart quantity updated.'. $extra_message;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping cart</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.ico">

</head>
<body>
   
<?php include 'header_logo.php'; ?>

<section class="shopping-cart">

   <h1 class="title">Shopping Cart</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` ");
      $select_cart->execute();
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Delete this from cart?');"></a>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="price">$<?= $fetch_cart['price']; ?>/<?= $fetch_cart['unit']; ?></div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_cart['pid']; ?>">
      <div class="flex-btn">
         <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>" class="qty" name="p_qty">
         <input type="submit" value="update" name="update_qty" class="option-btn">
      </div>
      <div class="sub-total"> Sub total: <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span> </div>
   </form>
   <?php
      $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">Your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>Grand total: <span>AUD $<?= $grand_total; ?></span></p>
      <a href="index.php" class="option-btn">Continue Shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">Delete all</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Checkout</a>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>