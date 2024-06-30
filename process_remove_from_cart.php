<?php
session_start();
$index = $_POST['index'];

if (isset($_SESSION['cart'][$index])) {
    unset($_SESSION['cart'][$index]);
}

header("Location: cart.php");
?>