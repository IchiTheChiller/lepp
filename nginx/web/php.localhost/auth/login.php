<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: downloads.php");
    exit;
}
$error = isset($_GET["error"]) ? "Falscher Benutzername oder Passwort!" : "";
?>
<?php include "../templates/header.php"; ?>
<h1>Login</h1>
<?php if ($error) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>
<form action="process_login.php" method="POST">
    <label for="username">Benutzername:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Passwort:</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Einloggen</button>
</form>
<p>Noch kein Konto? <a href="register.php">Registrieren</a></p>
<?php include "../templates/footer.php"; ?>