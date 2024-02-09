<?php
require_once '../connection/DbManager.php';
require_once "../models/Cart.php";
require_once "../models/Product.php";
require_once "../models/CartProduct.php";

$carrello = CartProduct::Find($_POST['cart_id'], $_POST['product_id']);

if ($_POST["quantita"] == 0) {
    $carrello->delete();
} else {
    $carrello->Save($carrello->getCartId(), $carrello->getProductId(), $_POST['quantita']);
}


header('Location: http://localhost:63342/ecommercev2/views/cart.php');


exit;