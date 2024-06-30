<?php
session_start();

$ticket_type = $_POST['ticket_type'];
$hours = $_POST['hours'];
$date = $_POST['date'];
$time = $_POST['time'];
$discount = $_POST['discount'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = [
    'ticket_type' => $ticket_type,
    'hours' => $hours,
    'date' => $date,
    'time' => $time,
    'discount' => $discount
];

header("Location: cart.php");
?>