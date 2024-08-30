<?php

@include 'config.php';

session_start();

if(isset($_GET['delete'])){
   $delete_order_item = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order_item->execute([$_SESSION['last_order_id']]);
   unset($_SESSION['last_order_id']);
   header('location:orders.php');
   exit();
}

$last_order_id = isset($_SESSION['last_order_id']) ? $_SESSION['last_order_id'] : 0;
$select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
$select_order->execute([$last_order_id]);
$order_exists = $select_order->rowCount() > 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.ico">

</head>
<body>
   
<?php include 'header_logo.php'; ?>

<section class="placed-orders">

   <h1 class="title">A confirmation email has been sent to your email!</h1>

   <div class="box-container">

   <?php
         if($order_exists){
            $fetch_order = $select_order->fetch(PDO::FETCH_ASSOC);
         ?>
         <div class="box">
            <p> Date: <span><?= $fetch_order['placed_on']; ?></span> </p>
            <p> Name: <span><?= $fetch_order['name']; ?></span> </p>
            <p> Number: <span><?= $fetch_order['number']; ?></span> </p>
            <p> Email: <span><?= $fetch_order['email']; ?></span> </p>
            <p> Address: <span><?= $fetch_order['address']; ?></span> </p>
            <p> Total Products: <span><?= $fetch_order['total_products']; ?></span> </p>
            <p> Total Price: <span>AUD $<?= $fetch_order['total_price']; ?></span> </p>
         </div>
         <?php
         }else{
            echo '<div class="empty">No order to display</div>';
         }
         ?>

   </div>

   <div class="wishlist-total">
      <a href="index.php" class="option-btn">Continue Shopping</a>
      <a href="orders.php?delete=<?= $last_order_id ?>" class="delete-btn <?= $order_exists ? '' : 'disabled'; ?>">Delete Order</a>
   </div>

</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>