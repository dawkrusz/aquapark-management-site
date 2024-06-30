<?php
include 'header.php';
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<div class="container mt-4">
    <h2>Profil użytkownika</h2>
    <p>Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="user_details.php" class="btn btn-primary mb-3">Zobacz swoje dane</a>
    <h3>Twoje bilety</h3>
    <ul>
        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM tickets WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['ticket_type']) . " na " . htmlspecialchars($row['date']) . " o " . htmlspecialchars($row['time']) . " Długośc trwania biletu: " . htmlspecialchars($row['hours']) . "." . " Cena za bilet: " . htmlspecialchars($row['price']) . " zł ";
                if (htmlspecialchars($row['date'])<date('Y-m-d') || (htmlspecialchars($row['date'])==date('Y-m-d') && htmlspecialchars($row['date'])>date('h:i:s') )) {echo " Bilet nieaktualny ❌" . "</li>";
                } else{echo "</li>";}
            }
        } else {
            echo "<p>Nie masz jeszcze żadnych biletów.</p>";
        }

        $stmt->close();
        ?>
    </ul>
</div>
<?php include 'footer.php'; ?>