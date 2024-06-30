<?php
include 'header.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: index.php");
    exit();
}
?>

<div class="container mt-4">
    <h2>Podsumowanie zakupu</h2>
    <ul>
        <?php
        $total_price = 0;
        foreach ($_SESSION['cart'] as $item) {
            $item_price = calculate_price($item['ticket_type'], $item['discount'], $item['hours'], $item['time']);
            $total_price += $item_price;
            echo "<li>" . htmlspecialchars($item['ticket_type']) . " na " . htmlspecialchars($item['date']) . " od " . htmlspecialchars($item['time']) . " - " . htmlspecialchars($item['hours']) . " godz. - Cena: " . number_format($item_price, 2) . " PLN</li>";
        }
        echo "<br></br>";
        echo "<p>Całkowita należność: " . "<b>" . number_format($total_price, 2) . "</b>" . " PLN</p>";
        ?>
    </ul>
    <form action='process_purchase.php' method='post'>
        <button type='submit' class='btn btn-success'>Dokonaj płatności</button>
    </form>
</div>
<?php include 'footer.php'; ?>