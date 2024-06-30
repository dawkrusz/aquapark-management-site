<?php
include 'config.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn->begin_transaction();

try {
    $total_price = 0;

    foreach ($_SESSION['cart'] as $item) {
        $ticket_type = $item['ticket_type'];
        $hours = $item['hours'];
        $date = $item['date'];
        $time = $item['time'];
        $discount = $item['discount'];
        $final_price = calculate_price($ticket_type, $discount, $hours, $time);

        $sql = "INSERT INTO tickets (user_id, ticket_type, hours, date, time, discount, price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $user_id, $ticket_type, $hours, $date, $time, $discount, $final_price);
        $stmt->execute();

        $total_price += $final_price;
    }

    $conn->commit();
    unset($_SESSION['cart']);
    header("Location: profile.php?purchase=success&total_price=$total_price");
} catch (Exception $e) {
    $conn->rollback();
    echo "Błąd: " . $e->getMessage();
}

$conn->close();
?>