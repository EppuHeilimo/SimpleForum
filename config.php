<?php
/**
 * Global configuration parameters.
 */
require_once(__DIR__ . "/util.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/Session.php");
require_once(__DIR__ . "/db.php");

define('MIN_PASSWORD_LENGTH', 3);
define('MIN_USERNAME_LENGTH', 3);

// two weeks -> 60 * 60 * 24 * 14 = 1209600
define("LOGIN_EXPIRY_TIME", 1209600);
