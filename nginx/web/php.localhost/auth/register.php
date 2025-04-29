<?php
session_start();
require_once "../config/database.php";

if (isset($_SESSION["user_id"])) {
    header("Location: downloads.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        $error = "Bitte alle Felder ausfüllen!";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $options = [
            "memory_cost" => 1 << 14,
            "time_cost" => 4,
            "threads" => 2,
        ];
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);
        try {
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute(["username" => $username, "password" => $hashedPassword]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $error = "Fehler bei der Registrierung: " . $e->getMessage();
        }
    }
}
?>
<?php include "../templates/header.php"; ?>
<h1>Registrieren</h1>
<?php if ($error) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>
<form action="register.php" method="POST">
    <label for="username">Benutzername:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Passwort:</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Registrieren</button>
</form>
<p>Schon ein Konto? <a href="login.php">Zum Login</a></p>
<?php include "../templates/footer.php"; ?>