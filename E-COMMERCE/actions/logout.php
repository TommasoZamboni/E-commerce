<?php

require '../models/Classes.php';


session_start();

$user = $_SESSION['current_user'];


if ($user)
{
    $session_obj= $_SESSION['object_session'];
    $_SESSION['current_user'] = null;
    $_SESSION['obj_session'] = null;
    header('location:../views/login.php');
    exit;
}