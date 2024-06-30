<?php 
    include 'header.php'; 
?>

<div class="container mt-4">
    <h2>Logowanie</h2>
    <form action="process_login.php" method="post">
        <div class="form-group">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Zaloguj</button>
    </form>
</div>

<div class="modal dark-mode-toggle" id="loginErrorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Błąd logowania</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Niepoprawne dane logowania.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>

<script>
    <?php
        if (isset($_SESSION['login_error'])): ?>
        $('#loginErrorModal').modal('show');
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
</script>

<?php include 'footer.php'; ?>