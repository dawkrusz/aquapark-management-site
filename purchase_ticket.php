<?php include 'header.php'; ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$sql = "SELECT type, discount FROM special_discounts";
$result = $conn->query($sql);

$discounts = [];
while ($row = $result->fetch_assoc()) {
    $discounts[$row['type']] = $row['discount'];
}
?>
<div class="container mt-4">
    <h2>Kup bilet</h2>
    <form action="process_add_to_cart.php" method="post">
        <div class="form-group">
            <label for="ticket_type">Typ biletu:</label>
            <select class="form-control" id="ticket_type" name="ticket_type" required>
                <option value="Bilet do aquaparku">Bilet do aquaparku</option>
                <option value="Bilet do sauny">Bilet do sauny</option>
                <option value="Bilet na basen profesjonalny">Bilet na basen profesjonalny</option>
                <option value="Dostęp do wszystkiego">Dostęp do wszystkiego</option>
            </select>
        </div>
        <div class="form-group">
            <label for="hours">Liczba godzin:</label>
            <select class="form-control" id="hours" name="hours" required>
                <option value="1">1 godzina</option>
                <option value="2">2 godziny</option>
                <option value="3">3 godziny</option>
                <option value="4">4+ godziny</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Data:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Godzina:</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="discount">Zniżka:</label>
            <select class="form-control" id="discount" name="discount">
                <option value="none">Brak</option>
                <?php foreach ($discounts as $type => $discount): ?>
                    <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?> -<?php echo $discount; ?>%</option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj do koszyka</button>
    </form>
</div>
<?php include 'footer.php'; ?>