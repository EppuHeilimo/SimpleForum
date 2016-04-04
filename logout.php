<?php
require_once(__DIR__ . "/config.php");

$session = Session::start();
$session->clear('user');

clearCookies();
