<?php
 echo '<div class="unauthorized-message">Nieautoryzowany dostęp, przenoszę na stronę główną...</div>';
 header("Refresh: 3; URL=../index.php");
 exit();
?>