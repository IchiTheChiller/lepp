<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../../config/database.php";
require_once "/usr/share/nginx/vendor/autoload.php";

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\EndroidQrCodeProvider;
use RobThree\Auth\Algorithm;

if (isset($_SESSION["user_id"])) {
    header("Location: downloads.php");
    exit;
}

$error = "";
$qrProvider = new EndroidQrCodeProvider();
$tfa = new TwoFactorAuth($qrProvider, "MeineWebseite", 6, 30, Algorithm::Sha1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["password_confirm"])) {
        $error = "Bitte alle Felder ausfüllen!";
    } else {
        $username = trim($_POST["username"]);
        $password = $_POST["password"];
        $password_confirm = $_POST["password_confirm"];

        if (empty($username) || empty($password) || empty($password_confirm)) {
            $error = "Bitte alle Felder ausfüllen!";
        } elseif ($password !== $password_confirm) {
            $error = "Die Passwörter stimmen nicht überein!";
        } else {
            $options = [
                "memory_cost" => 1 << 14,
                "time_cost" => 4,
                "threads" => 2,
            ];
            $hashedPassword = password_hash($password, PASSWORD_ARGON2ID, $options);

            $totpSecret = $tfa->createSecret(160, false);
            if ($totpSecret === null) {
                $error = "Fehler: TOTP-Secret ist NULL!";
            } elseif (empty($totpSecret)) {
                $error = "Fehler: TOTP-Secret ist leer!";
            } else {
                try {
                    $stmt = $db->prepare("INSERT INTO users (username, password, totp_secret) VALUES (:username, :password, :totp_secret)");
                    $stmt->execute([
                        "username" => $username,
                        "password" => $hashedPassword,
                        "totp_secret" => $totpSecret
                    ]);

                    echo "<h2>Registrierung erfolgreich!</h2>";
                    echo "<p>Scanne diesen QR-Code mit einer 2FA-App (z. B. Google Authenticator):</p>";
                    echo "<p>[QR Code Placeholder]</p>";
                    echo "<p>Gehe danach zum <a href='login.php'>Login</a>.</p>";
                    exit;
                } catch (PDOException $e) {
                    $error = "Fehler bei der Registrierung: " . $e->getMessage();
                }
            }
        }
    }
}
?>
<?php include "../../templates/header.php"; ?>
<h1>Registrieren</h1>
<?php if ($error) { ?>
    <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<form action="register.php" method="POST">
    <label for="username">Benutzername:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Passwort:</label>
    <input type="password" id="password" name="password" required><br>
    <label for="password_confirm">Passwort bestätigen:</label>
    <input type="password" id="password_confirm" name="password_confirm" required><br>
    <button type="submit">Registrieren</button>
</form>
<p>Schon ein Konto? <a href='login.php'>Zum Login</a></p>
<?php include "../../templates/footer.php"; ?>