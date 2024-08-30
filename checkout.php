<?php

@include 'config.php';

session_start();

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'] .', '. $_POST['city'] .', '. $_POST['state'] .' '. $_POST['pin_code'] .', Australia';
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   // Validate email format
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Please enter a valid email address';
   }
   // Validate phone number format
   elseif (!preg_match("/^\d{10}$/", $number)) {
      $message[] = 'Phone number should contain exactly 10 digits';
   }
   // Validate post code format
   elseif (!preg_match("/^\d{4}$/", $_POST['pin_code'])) {
      $message[] = 'Post code should contain only 4 digits';
   }
   else {

      $cart_total = 0;
      $cart_products[] = '';

      // Query to prevent user from buying too much of an item
      $products_query = $conn->prepare("SELECT id, quantity FROM `products` ");
      $products_query->execute();
      // How much of each product is still available
      $available = array();
      if($products_query->rowCount() > 0){
         while($row = $products_query->fetch(PDO::FETCH_ASSOC)){
            $available[$row['id']] = $row['quantity'];
         }
      }

      $cart_query = $conn->prepare("SELECT * FROM `cart` ");
      $cart_query->execute();
      if($cart_query->rowCount() > 0){
         while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
            $avail = $available[$cart_item['pid']];
            if($cart_item['quantity'] > $avail) {
               $problem = 'Out of stock: requested quantity ' . $cart_item['quantity'] . ' of ' . $cart_item['name'] . ', but only ' . $avail . ' are available';
               // Need to see the message on another page so put it in a temporary cookie
               setcookie("message", $problem, time() + 3600, "/");
               header('location: cart.php');
               exit();
            }
            $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
         };
      };

      $total_products = implode(' ', $cart_products);

      $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND address = ? AND total_products = ? AND total_price = ?");
      $order_query->execute([$name, $number, $email, $address, $total_products, $cart_total]);

      if($cart_total == 0){
         $message[] = 'Your cart is empty';
      }elseif($order_query->rowCount() > 0){
         $message[] = 'Order already exists!';
      }else{
         $conn->beginTransaction();

         $insert_order = $conn->prepare("INSERT INTO `orders` (name, number, email, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?)");

         if($insert_order->execute([$name, $number, $email, $address, $total_products, $cart_total, $placed_on])) {
            $order_id = $conn->lastInsertId();
            $_SESSION['last_order_id'] = $order_id;

            // Now insert their items into order_items so we know what they purchased,
            // and also reduce quantities in products
            $insert_order_items = $conn->prepare("INSERT INTO `order_items` (order_id, product_id, quantity, price) VALUES(?,?,?,?)");
            $reduce_quantity_query = $conn->prepare("UPDATE `products` SET quantity = quantity - ? WHERE id = ?");
            // Same query as above
            $cart_query = $conn->prepare("SELECT * FROM `cart` ");
            $cart_query->execute();
            if($cart_query->rowCount() > 0){
               while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
                  $product_id = $cart_item['pid'];
                  $quantity = $cart_item['quantity'];
                  $price = $cart_item['price'];
                  $insert_order_items->execute([$order_id, $product_id, $quantity, $price]);
                  $reduce_quantity_query->execute([$quantity, $product_id]);
               }
            }

            // Empty the cart
            $delete_cart = $conn->prepare("DELETE FROM `cart` ");
            $delete_cart->execute();

            $conn->commit();

            header('location: orders.php');
            exit();
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="img/favicon.ico">

</head>
<body>
   
<?php include 'header_logo.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` ");
      $select_cart_items->execute();
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$'.$fetch_cart_items['price'].'/'.$fetch_cart_items['unit'].' x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">Your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">Grand Total: <span>AUD $<?= $cart_grand_total; ?></span></div>
</section>

<section class="checkout-orders">
   
   <form action="" method="POST" id="checkout-form" onsubmit="return validateForm()">

      <h3>Delivery Details</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Name*:</span>
            <input type="text" name="name" placeholder="e.g. John Smith" class="box" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required>
         </div>
         <div class="inputBox">
            <span>Number*:</span>
            <input type="number" name="number" placeholder="e.g. 0475955556" class="box" pattern="\d{10}" title="Phone number should contain exactly 10 digits" value="<?php echo isset($_POST["number"]) ? $_POST["number"] : ''; ?>" required>
         </div>
         <div class="inputBox">
            <span>Email*:</span>
            <input type="email" name="email" placeholder="e.g. xxx@gmail.com" class="box" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required>
         </div>
         
         <div class="inputBox">
            <span>Address*:</span>
            <input type="text" name="address" placeholder="e.g. 8/1 Broadway Street" class="box" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : ''; ?>" required>
         </div>
         <div class="inputBox">
            <span>Suburb*:</span>
            <input type="text" name="city" placeholder="e.g. Burwood" class="box" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>" required>
         </div>
         <div class="inputBox">
            <span>State*: </span>
            <select name="state" class="box" required>
               <option value="" <?= (isset($_POST["state"]) && $_POST["state"] == "") ? "selected" : "" ?>>- Select -</option>
               <option value="NSW" <?= (isset($_POST["state"]) && $_POST["state"] == "NSW") ? "selected" : "" ?>>NSW</option>
               <option value="VIC" <?= (isset($_POST["state"]) && $_POST["state"] == "VIC") ? "selected" : "" ?>>VIC</option>
               <option value="QLD" <?= (isset($_POST["state"]) && $_POST["state"] == "QLD") ? "selected" : "" ?>>QLD</option>
               <option value="WA" <?= (isset($_POST["state"]) && $_POST["state"] == "WA") ? "selected" : "" ?>>WA</option>
               <option value="SA" <?= (isset($_POST["state"]) && $_POST["state"] == "SA") ? "selected" : "" ?>>SA</option>
               <option value="TAS" <?= (isset($_POST["state"]) && $_POST["state"] == "TAS") ? "selected" : "" ?>>TAS</option>
               <option value="ACT" <?= (isset($_POST["state"]) && $_POST["state"] == "ACT") ? "selected" : "" ?>>ACT</option>
               <option value="NT" <?= (isset($_POST["state"]) && $_POST["state"] == "NT") ? "selected" : "" ?>>NT</option>
               <option value="Others" <?= (isset($_POST["state"]) && $_POST["state"] == "Others") ? "selected" : "" ?>>Others</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Country*: Australia</span> 
         </div>
         <div class="inputBox">
            <span>Post Code*:</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 2000" class="box" pattern="\d{4}" value="<?php echo isset($_POST["pin_code"]) ? $_POST["pin_code"] : ''; ?>" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="Submit">

   </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
