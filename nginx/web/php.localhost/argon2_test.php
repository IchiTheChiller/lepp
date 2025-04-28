<?php
if (defined('PASSWORD_ARGON2I')) {
    echo "Argon2I ist verfügbar!";
} else {
    echo "Argon2I ist nicht verfügbar.";
}
?>