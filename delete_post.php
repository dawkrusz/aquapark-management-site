<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Pobierz post, aby uzyskać nazwę pliku obrazu
    $sql = "SELECT image FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image = $row['image'];

        // Usuń post z bazy danych
        $sql = "DELETE FROM blog_posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Usuń obraz z folderu images
            if (!empty($image)) {
                unlink("images/" . $image);
            }
            header("Location: blog.php");
            exit();
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Post nie znaleziony.";
    }

    $conn->close();
} else {
    echo "Brak ID postu.";
}
?>