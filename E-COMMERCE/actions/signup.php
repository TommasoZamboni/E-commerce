<?php

require '../models/Classes.php';

$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password-confirmation'];


if (strcmp($password, $password_confirmation) != 0) {
    header('Location:../views/signup.php');
    exit;
}

$password = hash('sha256', $password);

$pdo = DbManager::Connect("ecommerce");

$stmt = $pdo->prepare("select id from ecommerce.users where email=:email limit 1");
$stmt->bindParam(":email", $email);
$stmt->execute();

$user = $stmt->fetchObject("User");

if (!$user)
{
    $params = ['email' => $email, 'password' => $password];
    $user = User::Create($params);

    if ($user) {
        Cart::Create($user->GetID());
        header('Location:../views/login.php');
        exit();
    } else {
        header('Location:../views/signup.php');
        exit();
    }

}else
{
    header('Location:../views/signup.php');
    exit();

}


?>

