<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$response = [
    'success' => false,
    'title' => 'Błąd zmiany hasła',
    'message' => ''
];

$user_id = $_SESSION['user_id'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmNewPassword = $_POST['confirmNewPassword'];

// Pobierz aktualne hasło użytkownika
$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!password_verify($currentPassword, $user['password'])) {
    $response['message'] = 'Błędne aktualne hasło.';
    echo json_encode($response);
    exit();
}

if ($newPassword !== $confirmNewPassword) {
    $response['message'] = 'Nowe hasła nie są identyczne.';
    echo json_encode($response);
    exit();
}

if ($newPassword === $currentPassword) {
    $response['message'] = 'Nowe hasło nie może być takie samo jak stare hasło.';
    echo json_encode($response);
    exit();
}

// Walidacja nowego hasła
if (strlen($newPassword) < 8 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword) || !preg_match('/\d/', $newPassword)) {
    $response['message'] = 'Nowe hasło nie spełnia wymagań.';
    echo json_encode($response);
    exit();
}

// Hashowanie nowego hasła
$newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

// Aktualizacja hasła w bazie danych
$sql = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newPasswordHashed, $user_id);

if ($stmt->execute()) {
    $response['success'] = true;
    $response['title'] = 'Sukces';
    $response['message'] = 'Hasło zostało zmienione pomyślnie.';
} else {
    $response['message'] = 'Wystąpił błąd podczas zmiany hasła.';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>