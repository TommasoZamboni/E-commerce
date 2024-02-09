<?php

require_once '../connection/DbManager.php';
require_once '../models/User.php';
require_once '../models/Cart.php';


$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password-confirmation'];


if (strcmp($password, $password_confirmation) != 0) {
    header('Location:http://localhost:63342/ecommercev2/views/signup.php');
    exit;
}

$pdo = DbManager::Connect("ecommerce");

$stmt = $pdo->prepare("select * from ecommerce.users where email=:email and password = :password limit 1");
$stmt->bindParam(":email", $email);
$stmt->bindParam(":password", $password);
$stmt->execute();
$user = $stmt->fetchObject("User");

if (!$user) {
    $user = User::Create($_POST);
    $_POST["user_id"] = $user->GetID();

    Cart::Create($_POST);
    header('Location:http://localhost:63342/ecommercev2/views/login.php');
    exit();
} else {
    header('Location:http://localhost:63342/ecommercev2/views/login.php');
    exit();
}