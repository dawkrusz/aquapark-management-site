<?php
//session_destroy();
//echo '<pre>'; var_dump($_SESSION); echo '</pre>';
$config_file = 'config.php';

if (!file_exists('install.php')){   
    include 'header.php';
}
else{
    if (file_exists($config_file)) {
        if (is_writable($config_file)) {
            header('Location: install.php');
        } else {
            echo "<p>Zmień uprawnienia do pliku <code>".$config_file."</code><br>np. <code>chmod o+w ".$config_file."</code></p>";
            echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
            exit();
        }
    } else {
        echo "<p>Stwórz plik <code>".$config_file."</code><br>np. <code>touch ".$config_file."</code></p>";
        echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
        exit();
    }
}    

?>
<div class="container mt-4">
    <div class="jumbotron dark-mode-toggle">
        <h1 class="display-4">Witamy w Aquaparku!</h1>
        <p class="lead">Najlepsze miejsce na relaks i zabawę wodną.</p>
        <hr class="my-4">
        <p>Zapraszamy do zapoznania się z naszymi atrakcjami i ofertą.</p>
        <a class="btn btn-primary btn-lg" href="prices.php" role="button">Sprawdź cennik</a>
    </div>
</div>
<?php include 'footer.php'; ?>