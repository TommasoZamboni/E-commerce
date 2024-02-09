<?php
require_once '../connection/DbManager.php';
require_once '../models/User.php';
require_once '../models/Session.php';

session_start();


$user = $_SESSION['current_user'];


if ($user) {
    session_destroy();
    $session_obj = $_SESSION['object_session'];
    $data_logout = date(date('d/m/y H:i:s'));
    $session_obj->deactivate($data_logout);
    $_SESSION['current_user'] = null;
    $_SESSION['obj_session'] = null;
    header('location: http://localhost:63342/ecommercev2/views/login.php');
    exit();
}