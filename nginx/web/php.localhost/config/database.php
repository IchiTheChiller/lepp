<?php
$host = 'postgres';
$dbname = 'postgres';
$user = 'postgres';
$password = 'test_password';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Verbindungsfehler: " . $e->getMessage();
    exit;
}
?>