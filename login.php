<?php


require_once(__DIR__ . "/config.php");

// if logged in already, redirect
isLoggedIn();

$messages = array();

$session = Session::start();
if ($session->get('register_flag') != null) {
    $messages[] = "Registration successful";
    $session->clear('register_flag');
}

if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['passwd'])) {
        $username = $_POST['username'];
        $passwd = $_POST['passwd'];
        $user = new User();
		//check for user info
        if ($user->login($username, $passwd)) {
            $session->set('user', $user);
            header("Location: index.php");
            exit();
        } else {
            $messages[] = "Login failed";
        }
    } else {
        $messages[] = "Missing fields";
    }
}

// Include the HTML template:
require __DIR__ . '/style/login.php';
