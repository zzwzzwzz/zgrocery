<?php

if (isset($_POST['add_to_wishlist'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_unit = $_POST['p_unit'];
    $p_unit = filter_var($p_unit, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ?");
    $check_wishlist_numbers->execute([$p_name]);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ?");
    $check_cart_numbers->execute([$p_name]);

    if($check_wishlist_numbers->rowCount() > 0){
    $message[] = 'Already added to wishlist!';
    }elseif($check_cart_numbers->rowCount() > 0){
    $message[] = 'Already added to cart!';
    }else{
    $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(pid, name, price, unit, image) VALUES(?,?,?,?,?)");
    $insert_wishlist->execute([$pid, $p_name, $p_price, $p_unit, $p_image]);
    $message[] = 'Added to wishlist!';
    }

}

?>