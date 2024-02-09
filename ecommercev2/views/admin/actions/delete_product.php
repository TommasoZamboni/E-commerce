<?php

require_once '../../../connection/DbManager.php';
require_once '../../../models/Session.php';
require_once '../../../models/Product.php';
require_once '../../../models/User.php';
require_once "../../../models/CartProduct.php";


$product = Product::Find($_POST['id']);
CartProduct::delete_productId($product->getId());
$product->delete();
header('Location: http://localhost:63342/ecommercev2/views/admin/products/index.php');
exit;
