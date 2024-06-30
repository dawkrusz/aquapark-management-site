<?php include 'header.php'; ?>
<div class="container mt-4">
    <h2>Rejestracja</h2>
    <form action="process_register.php" method="post" id="registerForm">
        <div class="form-group">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input type="password" class="form-control" id="password" name="password" required>
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
            <label for="confirmPassword">Powtórz hasło:</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Zarejestruj</button>
    </form>
</div>

<div class="modal dark-mode-toggle" id="registerErrorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Błąd rejestracji</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="registerErrorMessage">
                <!-- Wiadomość o błędzie rejestracji -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('password').addEventListener('input', function() {
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

document.getElementById('registerForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    if (password !== confirmPassword) {
        event.preventDefault();
        document.getElementById('registerErrorMessage').innerText = 'Hasła nie są identyczne.';
        $('#registerErrorModal').modal('show');
    }
});
</script>
<?php include 'footer.php'; ?>