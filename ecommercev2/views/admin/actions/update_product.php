<?php
require_once '../../../connection/DbManager.php';
require_once '../../../models/Product.php';
require_once '../../../models/Session.php';


$product = Product::Find($_POST["id"]);
$product->update($_POST["nome"], $_POST["marca"], $_POST["prezzo"], $_POST["id"]);

header('Location: http://localhost:63342/ecommercev2/views/admin/products/index.php');


