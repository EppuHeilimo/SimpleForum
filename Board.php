<?php

require_once(__DIR__ . "/config.php");

$session = Session::start();
$user = Session::getUser();

$session->set('currentboard', $_GET['boardname']);

require __DIR__ . '/style/board.php';

