<?php
require_once(__DIR__ . "/util.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/Session.php");
require_once(__DIR__ . "/db.php");
require_once(__DIR__ . "/PasswordHash.php");

define('MIN_PASSWORD', 3);
define('MIN_USERNAME', 3);

define("LOGIN_EXPIRE_TIME", 1209600);