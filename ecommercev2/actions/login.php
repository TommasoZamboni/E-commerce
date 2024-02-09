<?php

require_once '../connection/DbManager.php';
require_once '../models/User.php';
require_once '../models/Session.php';
require_once '../models/Cart.php';


$email = $_POST["email"];
$password = hash('sha256', $_POST["password"]);

$pdo = DbManager::Connect("ecommerce");

$stmt = $pdo->prepare("SELECT * FROM ecommerce.users WHERE email = :email and password = :password");
$stmt->bindParam(":email", $email);
$stmt->bindParam(":password", $password);
$stmt->execute();
$user = $stmt->fetchObject("User");

if (!$user) {
    header('Location: ../views/signup.php');
    exit;
} else {
    session_start();
    $_SESSION['current_user'] = $user;
    $params = array('ip' => '127.0.0.1', 'data_login' => date('d/m/y H:i:s'), 'user_id' => $user->GetId());
    $_SESSION['object_session'] = Session::Create($params);
    $params = array("user_id" => $user->GetId());
    $cart = Cart::Create($params);

    if ($user->GetRole_ID() != 1) {
        header('Location: ../views/admin/products/index.php');
        exit;
    }
    header('Location: ../views/products/index.php');
    exit;
}

?>



