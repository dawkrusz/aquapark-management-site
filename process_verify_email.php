<?php
include 'config.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verification_code'])) {
        $verification_code = $_POST['verification_code'];
        $sql = "SELECT * FROM users WHERE id = ? AND verification_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $verification_code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            // Kod weryfikacyjny jest poprawny
            $sql = "UPDATE users SET verification_code = NULL WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            // Logowanie użytkownika
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $result->fetch_assoc()['username'];
            echo "<script>alert('Konto zostało pomyślnie zweryfikowane! Możesz się teraz zalogować.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Niepoprawny kod weryfikacyjny.');</script>";
        }
        $stmt->close();
    } elseif (isset($_POST['resend_code'])) {
        // Ponowne wysłanie kodu weryfikacyjnego
        $verification_code = rand(100000, 999999);
        $sql = "UPDATE users SET verification_code = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $verification_code, $user_id);
        $stmt->execute();
        $stmt->close();
        
        $sql = "SELECT email FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $stmt->close();

        // Wysłanie nowego kodu weryfikacyjnego
    
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aquaparkverifycode@outlook.com';
            $mail->Password = 'AquaparkHaslo987';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('aquaparkverifycode@outlook.com', 'Aquapark');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Twój kod weryfikacyjny';
            $mail->Body    = "Twoj kod weryfikacyjny to: $verification_code";

            $mail->send();
            echo "<script>alert('Nowy kod weryfikacyjny został wysłany na twój adres email.');</script>";
        } catch (Exception $e) {
            echo "Błąd podczas wysyłania emaila. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>