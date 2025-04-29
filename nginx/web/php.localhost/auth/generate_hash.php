<?php
// Passwort, das wir hashen wollen
$password = 'password123';

// Argon2i-Optionen
$options = [
    'memory_cost' => 1 << 14, // 16 MiB
    'time_cost'   => 4,       // 4 Durchläufe
    'threads'     => 2,       // 2 Threads
];

// Hash das Passwort mit Argon2i
$hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

// Gib den Hash aus
echo "Gehashtes Passwort: " . $hashedPassword;
?>