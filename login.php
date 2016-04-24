<?php
require_once(__DIR__ . "/config.php");

//redirect to index if already logged
isLoggedIn('index.php');

$messages = array();
$warnings = array();
$session = Session::start();
if ($session->get('registered') != null) {
    $messages[] = "Registration successful";
    $session->clear('registered');
}

if (isset($_POST['login'])) {
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
            $messages[] = "Wrong user info";
        }
    } else {
        $messages[] = "Missing fields";
    }
} 
else if(isset($_POST['register']))
{
     if (isset($_POST['passwd']) && isset($_POST['passwd2']) && isset($_POST['username']) && isset($_POST['email']) ) {
        $passwd = $_POST['passwd'];
        $passwd2 = $_POST['passwd2'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        // validate password and username
        if($passwd != $passwd2) {
            $warnings[] = "Passwords don't match";
        }
        if (!isValidPassword($passwd)) {
            $warnings[] = "Not a valid password (longer than " . 
                MIN_PASSWORD_LENGTH . " characters required)";
        }
        if (!isValidUsername($username)) {
            $warnings[] = "Not a valid username (longer than " . 
                MIN_USERNAME_LENGTH . " characters required)";
        }

    // No warnings means everything is in order, and we can create the user
        $db = new DataBase();
        if ($db->userExists($username)) {
            $warnings[] = "Username already taken";
        }
        else if($db->emailExists($email))
        {
            $warnings[] = "Email already in use";
        }
        else {
            $passwd = pw_encode($passwd);
            if (!$db->createUser($username, $passwd, $email)) {
                $warnings[] = "Failed to insert to database";
            } else {
                // Registration was successful, redirect the user to
                // the login screen
                $session->set('registered', true);
                header("Location: login.php");
                exit();
            }

        }
    }
    else{
        $warnings[] = "Fill in all the fields.";
    }
}

require_once __DIR__ . '/style/login.php';