<?php 
    include 'header.php'; 
    include 'config.php';
?>
<div class="container mt-4">
    <h2>Godziny otwarcia</h2>
    <h3>Godziny standardowe</h3>
    <ul>
        <li>Codziennie : 6:00 - 22:00</li>
    </ul>
    <h3>Nocne pływanie</h3>
    <ul>
        <li>Codziennie w nocy : 22:00 - 6:00</li>
    </ul>
    <h4><b>PODCZAS NOCNEGO PŁYWANIA (22:00 - 6:00) ZNIŻKA <?php
        $sql = "SELECT discount FROM night_discount";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['discount'];
    ?>% NA KAŻDY BILET!</b></h4>
</div>
<?php include 'footer.php'; ?>