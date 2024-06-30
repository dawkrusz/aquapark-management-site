<?php
function calculate_price($ticket_type, $discount, $hours, $time) {
    include 'config.php';

    // 1h price req
    $sql = "SELECT hour_1_price FROM ticket_prices WHERE ticket_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ticket_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $hour_1_price = $row['hour_1_price'];

    // znizki req
    $discounts = [];
    $sql = "SELECT hours, discount FROM ticket_discounts";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $discounts[$row['hours']] = $row['discount'];
    }
    //calc
    $price = $hour_1_price * $hours;
    if (isset($discounts[$hours])) {
        $price -= ($price * $discounts[$hours] / 100);
    }

    // syudenci etc znizki req
    $special_discounts = [];
    $sql = "SELECT type, discount FROM special_discounts";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $special_discounts[$row['type']] = $row['discount'];
    }

    if (isset($special_discounts[$discount])) {
        $price -= ($price * $special_discounts[$discount] / 100);
    }

    // nocne plywanie znizka req
    $sql = "SELECT discount FROM night_discount";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $night_discount = $row['discount'];

    $time_discount = (strtotime($time) >= strtotime('22:00') || strtotime($time) < strtotime('06:00')) ? $night_discount : 0;
    $price -= ($price * $time_discount / 100);

    return $price;
}
?>