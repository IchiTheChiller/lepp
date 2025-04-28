<?php
// Überprüfen, ob Argon2i verfügbar ist
if (defined('PASSWORD_ARGON2I')) {
    echo "Argon2i ist verfügbar!<br>";
} else {
    echo "Argon2i ist nicht verfügbar.<br>";
}

// Überprüfen, ob Argon2d verfügbar ist
if (defined('PASSWORD_ARGON2D')) {
    echo "Argon2d ist verfügbar!<br>";
} else {
    echo "Argon2d ist nicht verfügbar.<br>";
}

// Überprüfen, ob Argon2id verfügbar ist
if (defined('PASSWORD_ARGON2ID')) {
    echo "Argon2id ist verfügbar!<br>";
} else {
    echo "Argon2id ist nicht verfügbar.<br>";
}

// Überprüfen, ob bcrypt verfügbar ist
if (defined('PASSWORD_BCRYPT')) {
    echo "bcrypt ist verfügbar!<br>";
} else {
    echo "bcrypt ist nicht verfügbar.<br>";
}
?>
