<?php

require '../models/Classes.php';

session_start();

$user = $_SESSION['current_user'];
$product_id = $_POST['product_id'];
$quantita = $_POST['quantita'];

$carrello = Cart::Find($user->GetID());


if ($quantita > 0) {
    $params = ['product_id' => $product_id, 'quantita' => $quantita];
    $carrello->AggiornaProdotti($params);
} else {
    $carrello->RimuoviProdotti($product_id);
}

header('Location: ../views/carts/index.php');
exit;