<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<?php include "../templates/header.php"; ?>
<h1>Willkommen!</h1>
<p>Du bist erfolgreich eingeloggt.</p>
<a href="logout.php">Ausloggen</a>
<?php include "../templates/footer.php"; ?>