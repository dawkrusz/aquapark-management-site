<?php
include 'config.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Check if passwords match
if ($password !== $confirmPassword) {
    echo "Hasła nie są identyczne.";
    exit;
}

// Validate password requirements
if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
    echo "Hasło nie spełnia wymagań.";
    exit;
}

// Check if username or email already exists
$sql = "SELECT id FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Nazwa użytkownika lub email już istnieje.";
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $passwordHash, $email);

if ($stmt->execute()) {
    // Get the inserted ID from the mysqli connection, not the statement
    $userId = $conn->insert_id;

    // Send verification email
    $verificationCode = rand(100000, 999999);
    $sql = "UPDATE users SET verification_code = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $verificationCode, $userId);
    $stmt->execute();

    // Configure PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.outlook.com'; // Użyj odpowiedniego serwera SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'aquaparkverifycode@outlook.com'; // Twój adres email
        $mail->Password = 'AquaparkHaslo987'; // Twoje hasło
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('aquaparkverifycode@outlook.com', 'Aqua Park');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Potwierdzenie adresu email';
        $mail->Body    = "Twój kod weryfikacyjny to: $verificationCode";

        $mail->send();
        
        // Logowanie użytkownika
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;

        header("Location: verify_email.php");
    } catch (Exception $e) {
        echo "Błąd podczas wysyłania emaila. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Błąd: " . $conn->error;
}

$stmt->close();
$conn->close();
?>