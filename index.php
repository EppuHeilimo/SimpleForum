<?php
require_once(__DIR__ . "/config.php");

$session = Session::start();
$user = Session::getUser();

if(isset($_POST['newboard']))
{
    if (isset($_POST['boardname']) && isset($_POST['desc'])) {
        $db = new DataBase();
        $db->addBoard($_POST['boardname'], $_POST['desc']);
    }
    else
        echo "missing fields";
}

require __DIR__ . '/style/index.php';
