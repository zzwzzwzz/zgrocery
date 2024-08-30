<?php

if (isset($_POST['add_to_cart'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $pid = (int)$pid;
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_unit = $_POST['p_unit'];
   $p_unit = filter_var($p_unit, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

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
   //echo print_r($available);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ?");
   $check_cart_numbers->execute([$p_name]);
   $row = $check_cart_numbers->fetch(PDO::FETCH_ASSOC);
   $current_qty = $row['quantity'];
   $new_qty = $current_qty + $p_qty;

   $extra_message = '';
   $reduced_from = null;
   if($new_qty > $available[$pid]) {
      $reduced_from = $new_qty;
      $new_qty = $available[$pid];
      $extra_message = ' Note: Only ' . $available[$pid] . ' in stock';
   }

   if ($check_cart_numbers->rowCount() > 0) {
      $update_cart = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE name = ?");
      $update_cart->execute([$new_qty, $p_name]);

      $message[] = 'Quantity updated in cart!' . $extra_message;
   } else {
      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ?");
      $check_wishlist_numbers->execute([$p_name]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ?");
         $delete_wishlist->execute([$p_name]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(pid, name, price, unit, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$pid, $p_name, $p_price, $p_unit, $p_qty, $p_image]);

      $message[] = 'Added to cart!' . $extra_message;
   }
}

?>