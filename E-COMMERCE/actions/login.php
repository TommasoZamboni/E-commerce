<?php

require '../models/Classes.php';

session_start();
$email = $_POST["email"];
$password = hash('sha256',$_POST["password"]);

$pdo = DbManager::Connect("ecommerce");

$stmt = $pdo->prepare("select id,email,password from ecommerce.users where  email=:email and password=:password limit 1");
$stmt->bindParam(":email", $email);
$stmt->bindParam(":password", $password);
$stmt->execute();
$user = $stmt->fetchObject("User");

if (!$user) {
    header('location:../views/login.php');
    exit;
} else {
    $_SESSION['current_user'] = $user;
    $params = array('ip' => $_SERVER["REMOTE_ADDR"], 'data_login' => date('d/m/y H:i'),'user_id'=> $user->GetID());
    $_SESSION['object_session'] = Session::Create($params);
    header('location:../views/products/index.php');
    exit;
}

?>
