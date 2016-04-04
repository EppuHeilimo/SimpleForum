<?php
require_once(__DIR__ . "/config.php");

if (isLoggedIn()) {
    $user = getUser();
    echo "Logged in as {$user->getUsername()}";
} else {
    echo "Not logged in.";
}
