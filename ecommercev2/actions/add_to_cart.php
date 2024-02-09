<?php
require_once '../connection/DbManager.php';
require_once '../models/CartProduct.php';


if (!$_POST['quantita'] > 0 || !CartProduct::Create($_POST["cart_id"], $_POST["product_id"], $_POST["quantita"])) {
    echo "Non è stato possibile aggiungere i prodotti al carrello";
    exit();
}
header('Location: http://localhost:63342/ecommercev2/views/products/index.php');
