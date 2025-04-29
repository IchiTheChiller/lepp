<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../config/database.php";

if (!isset($_POST["username"]) || !isset($_POST["password"])) {
    header("Location: login.php?error=1");
    exit;
}

$username = $_POST["username"];
$password = $_POST["password"];

try {
    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = :username");
    $stmt->execute(["username" => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: downloads.php");
        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }
} catch (PDOException $e) {
    echo "Fehler: " . $e->getMessage();
    exit;
}
?>