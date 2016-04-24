<?php

require_once(__DIR__ . "/config.php");

$session = Session::start();
$user = Session::getUser();

if(isset($_GET['threadname']))
{
    $session->set('currentthread', $_GET['threadname']);
}

if(isset($_POST['newthread']))
{
    if(isset($_POST['message']) && isset($_POST['subject']))
    {
        echo $_POST['message'];
        $db = new DataBase();
        $db->addThread($session->get('currentboard'), $_POST['subject'], $_POST['message'], $user->getUsername());
    }
    else
    {
        echo "Missing fields";
    }
        
}

if(isset($_POST['newpost']))
{
    if(isset($_POST['message']) && isset($_POST['subject']))
    {
        echo $_POST['message'];
        $db = new DataBase();
        $db->addPost($_POST['subject'], $_POST['message'], $user->getUsername(), $session->get('currentthread'));
        /*Refresh page*/
        $thread = $session->get('currentthread');
        header("Location: Thread.php?threadname=$thread");
    }
    else
    {
        echo "Missing fields";
    }
        
}

require __DIR__ . '/style/thread.php';