<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = null;

    $upload_ok = true;
    $error_message = "";

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "images/";
        $image_name = "image" . date('YmdHis') . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            $upload_ok = false;
            $error_message = "Plik nie jest prawidłowym obrazem.";
        }

        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            $upload_ok = false;
            $error_message = "Plik przekracza maksymalny rozmiar 5 MB.";
        }

        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($imageFileType, $allowed_extensions)) {
            $upload_ok = false;
            $error_message = "Tylko pliki JPG, JPEG, PNG i GIF są dozwolone.";
        }

        if ($upload_ok) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $image_name;
            } else {
                $upload_ok = false;
                $error_message = "Wystąpił błąd podczas przesyłania pliku.";
            }
        }
    }

    if ($upload_ok) {
        $sql = "UPDATE blog_posts SET title = ?, content = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $content, $image, $id);

        if ($stmt->execute()) {
            header("Location: blog.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    } else {
        echo $error_message;
    }

    $conn->close();
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Post not found.";
        exit();
    }
    $stmt->close();
}
?>

<?php include 'header.php'; ?>
<div class="container mt-4">
    <h2>Edytuj post</h2>
    <form action="edit_post.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
            <label for="title">Tytuł:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Treść:</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($row['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Zdjęcie (pozostaw puste, jeśli nie chcesz zmieniać):</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </form>
</div>
<?php include 'footer.php'; ?>