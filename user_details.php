<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<div class="container mt-4">
    <h2>Twoje dane</h2>
    <p><strong>Nazwa użytkownika:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <h3>Zmień hasło</h3>
    <form action="process_change_password.php" method="post" id="changePasswordForm">
        <div class="form-group">
            <label for="currentPassword">Aktualne hasło:</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
        </div>
        <div class="form-group">
            <label for="newPassword">Nowe hasło:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            <small id="passwordHelp" class="form-text text-muted">
                Hasło musi mieć przynajmniej 8 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę i jedną cyfrę.
            </small>
            <ul id="passwordRequirements">
                <li id="length" class="text-danger">Przynajmniej 8 znaków</li>
                <li id="uppercase" class="text-danger">Przynajmniej jedna wielka litera</li>
                <li id="lowercase" class="text-danger">Przynajmniej jedna mała litera</li>
                <li id="number" class="text-danger">Przynajmniej jedna cyfra</li>
            </ul>
        </div>
        <div class="form-group">
            <label for="confirmNewPassword">Powtórz nowe hasło:</label>
            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Zmień hasło</button>
    </form>
</div>

<div class="modal dark-mode-toggle" id="changePasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="changePasswordModalMessage">
                <!-- Wiadomość o błędzie zmiany hasła -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="changePasswordModalButton">Zamknij</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    document.getElementById('length').classList.toggle('text-success', password.length >= 8);
    document.getElementById('length').classList.toggle('text-danger', password.length < 8);
    document.getElementById('uppercase').classList.toggle('text-success', /[A-Z]/.test(password));
    document.getElementById('uppercase').classList.toggle('text-danger', !/[A-Z]/.test(password));
    document.getElementById('lowercase').classList.toggle('text-success', /[a-z]/.test(password));
    document.getElementById('lowercase').classList.toggle('text-danger', !/[a-z]/.test(password));
    document.getElementById('number').classList.toggle('text-success', /\d/.test(password));
    document.getElementById('number').classList.toggle('text-danger', !/\d/.test(password));
});

document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmNewPassword = document.getElementById('confirmNewPassword').value;

    let errorMessage = null;

    if (newPassword === currentPassword) {
        errorMessage = 'Nowe hasło nie może być takie samo jak stare hasło.';
    }

    if (newPassword !== confirmNewPassword) {
        errorMessage = 'Nowe hasła nie są identyczne.';
    }

    if (errorMessage) {
        document.getElementById('changePasswordModalTitle').innerText = 'Błąd zmiany hasła';
        document.getElementById('changePasswordModalMessage').innerText = errorMessage;
        $('#changePasswordModal').modal('show');
        return;
    }

    fetch('process_change_password.php', {
        method: 'POST',
        body: new FormData(document.getElementById('changePasswordForm'))
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('changePasswordModalTitle').innerText = data.title;
        document.getElementById('changePasswordModalMessage').innerText = data.message;

        if (data.success) {
            document.getElementById('changePasswordModalButton').innerText = 'OK';
            document.getElementById('changePasswordModalButton').onclick = () => {
                window.location.href = 'profile.php';
            };

            // Obsługa kliknięcia poza modalem
            $('#changePasswordModal').on('hidden.bs.modal', function () {
                window.location.href = 'profile.php';
            });
        } else {
            document.getElementById('changePasswordModalButton').innerText = 'Zamknij';
            document.getElementById('changePasswordModalButton').onclick = () => {
                $('#changePasswordModal').modal('hide');
            };
        }

        $('#changePasswordModal').modal('show');
    });
});
</script>

<?php include 'footer.php'; ?>