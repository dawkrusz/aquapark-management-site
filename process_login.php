<?php
/*
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, password, verification_code, role FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id, $hashed_password, $verification_code, $role);

if ($stmt->num_rows === 1) {
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        if (!is_null($verification_code)) {
            header("Location: verify_email.php");
        } else {
            $_SESSION['loggedin'] = true;
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Nieprawidłowe hasło.";
    }
} else {
    echo "Nieprawidłowa nazwa użytkownika.";
}

$stmt->close();
$conn->close();
*/
?>

<?php
/*
include 'config.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location: index.php");
    } else {
        $_SESSION['login_error'] = true;
        header("Location: login.php");
    }
} else {
    $_SESSION['login_error'] = true;
    header("Location: login.php");
}

$stmt->close();
$conn->close();
*/
?>

<?php
include 'config.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        if (!is_null($row['verification_code'])) {
            // Kod weryfikacyjny nie jest NULL, użytkownik nie zweryfikował adresu e-mail
            $_SESSION['verification_pending'] = true;
            $_SESSION['user_id'] = $row['id'];
            header("Location: verify_email.php");
        } else {
            // Użytkownik zweryfikował adres e-mail
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
        }
    } else {
        $_SESSION['login_error'] = true;
        header("Location: login.php");
    }
} else {
    $_SESSION['login_error'] = true;
    header("Location: login.php");
}

$stmt->close();
$conn->close();
?>
