<?php
include 'header.php';
include 'functions.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<div class="container mt-4">
    <h2>Koszyk</h2>
    <ul>
        <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $total_price = 0;
            foreach ($_SESSION['cart'] as $index => $item) {
                $item_price = calculate_price($item['ticket_type'], $item['discount'], $item['hours'], $item['time']);
                $total_price += $item_price;
                echo "<li>" . htmlspecialchars($item['ticket_type']) . " na " . htmlspecialchars($item['date']) . " od " . htmlspecialchars($item['time']) . " - " . htmlspecialchars($item['hours']) . " godz. - Cena: " . number_format($item_price, 2) . " PLN
                <form action='process_remove_from_cart.php' method='post' style='display:inline;'>
                    <input type='hidden' name='index' value='$index'>
                    <button type='submit' class='btn btn-danger btn-sm'>Usuń</button>
                </form></li>";
            }
            echo "<form action='process_clear_cart.php' method='post' style='display:inline;'>
                    <button type='submit' class='btn btn-warning btn-sm'>Usuń wszystko</button>
                </form>";
            echo "<a class='btn btn-primary' href='purchase_summary.php'>Przejdź do płatności</a>";
        } else {
            echo "<p>Twój koszyk jest pusty.</p>";
            echo "<a class='btn btn-primary' href='purchase_ticket.php'>Dodaj bilety do koszyka</a>";
        }
        ?>
    </ul>
</div>
<?php include 'footer.php'; ?>