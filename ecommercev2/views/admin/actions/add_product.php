<?php
require_once '../../../connection/DbManager.php';
require_once '../../../models/Product.php';

if (!Product::duplicato($_POST)) {
    Product::Create($_POST);
} else
    throw new PDOException("Prodotto già esistente");

header('Location: http://localhost:63342/ecommercev2/views/admin/products/index.php');
exit();





