<?php
include 'config.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$title = $_POST['title'];
$content = $_POST['content'];
$author_id = $_SESSION['user_id'];
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
    $sql = "INSERT INTO blog_posts (title, content, author_id, created_at, image) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $title, $content, $author_id, $image);

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
?>