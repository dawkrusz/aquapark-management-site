<?php 
    include 'header.php'; 

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>
<div class="container mt-4">
    <h2>Weryfikacja Email</h2>
    <form action="process_verify_email.php" method="post">
        <div class="form-group">
            <label for="verification_code">Kod weryfikacyjny:</label>
            <input type="text" class="form-control" id="verification_code" name="verification_code" required>
        </div>
        <button type="submit" class="btn btn-primary">Zweryfikuj</button>
    </form>
    <form action="verify_email.php" method="post">
        <input type="hidden" name="resend_code" value="1">
        <button type="submit" id="resend_button" class="btn btn-secondary mt-2" disabled>Wyślij ponownie kod</button>
    </form>
    <div id="countdown" class="mt-2"></div>
</div>

<script>
    let resendButton = document.getElementById('resend_button');
    let countdown = document.getElementById('countdown');
    let seconds = 60;

    function updateCountdown() {
        countdown.innerText = `Proszę czekać ${seconds} sekund przed ponownym wysłaniem kodu.`;
        if (seconds > 0) {
            seconds--;
            setTimeout(updateCountdown, 1000);
        } else {
            resendButton.disabled = false;
            countdown.innerText = '';
        }
    }

    updateCountdown();
</script>

<?php include 'footer.php'; ?>