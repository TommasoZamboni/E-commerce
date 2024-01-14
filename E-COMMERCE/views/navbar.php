<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['current_user'])) { ?>
    <a href="/E-COMMERCE/actions/logout.php">logout</a>
<?php } else { ?>
    <a href="/E-COMMERCE/views/login.php">login</a>
<?php } ?>