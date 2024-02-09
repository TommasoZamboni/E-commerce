<?php
// Controlla se la sessione è già attiva prima di avviarne una nuova
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['current_user']) { ?>
    <a href="../actions/logout.php">logout</a>
<?php } else { ?>
    <a href="/views/login.php">login</a>
<?php } ?>
