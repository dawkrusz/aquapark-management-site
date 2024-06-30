<?php
include 'header.php';
include 'config.php';

$sql = "SELECT * FROM ticket_prices";
$result = $conn->query($sql);

$prices = [];
while ($row = $result->fetch_assoc()) {
    $prices[$row['ticket_type']] = $row['hour_1_price'];
}

$sql = "SELECT hours, discount FROM ticket_discounts";
$result = $conn->query($sql);

$discounts = [];
while ($row = $result->fetch_assoc()) {
    $discounts[$row['hours']] = $row['discount'];
}
?>

<div class="container mt-4">
    <h2>Cennik</h2>
    <table class="table table-striped dark-mode-toggle" id="tabela_cennik">
        <thead>
            <tr>
                <th>Typ biletu</th>
                <th>Cena za 1 godzinę</th>
                <th>Cena za 2 godziny (-<?php echo $discounts[2]; ?>%)</th>
                <th>Cena za 3 godziny (-<?php echo $discounts[3]; ?>%)</th>
                <th>Cena za 4+ godziny (-<?php echo $discounts[4]; ?>%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prices as $ticket_type => $hour_1_price): ?>
                <tr>
                    <td><?php echo $ticket_type; ?></td>
                    <td><?php echo $hour_1_price; ?> zł</td>
                    <td><?php echo $hour_1_price * 2 * (1 - $discounts[2] / 100); ?> zł</td>
                    <td><?php echo $hour_1_price * 3 * (1 - $discounts[3] / 100); ?> zł</td>
                    <td><?php echo $hour_1_price * 4 * (1 - $discounts[4] / 100); ?> zł</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h3>Zniżki</h3>
    <ul>
        <?php
        $sql = "SELECT type, discount FROM special_discounts";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()): ?>
            <li><?php echo ucfirst($row['type']); ?> -<?php echo $row['discount']; ?>%</li>
        <?php endwhile; ?>
    </ul>
    <h3><b>PODCZAS NOCNEGO PŁYWANIA (22:00 - 6:00) ZNIŻKA <?php
        $sql = "SELECT discount FROM night_discount";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['discount'];
    ?>% NA KAŻDY BILET!</b></h3>
    <a class="btn btn-primary" href="purchase_ticket.php">Kup bilet</a>
</div>
<?php include 'footer.php'; ?>