<?php
/**
 * Account registration form.
 */

require_once(__DIR__ . "/config.php");

// disallow new account creation for users who are already logged in
requireNotLoggedIn();

$session = Session::start();
$warnings = array();

if (isset($_POST['submit'])) {
	if (isset($_POST['passwd']) && isset($_POST['passwd2']) && 
        isset($_POST['username'])) {
        
        $passwd = $_POST['passwd'];
        $passwd2 = $_POST['passwd2'];
        $username = $_POST['username'];
        
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
        if (count($warnings) == 0) {
            $dao = new User();
            if ($dao->userExists($username)) {
                $warnings[] = "Username already taken";
            }
            else {
                $passwd = pw_encode($passwd);
                if (!$dao->createUser($username, $passwd)) {
                    $warnings[] = "Failed to insert to database";
                } else {
                    // Registration was successful, redirect the user to
                    // the login screen
                    $session->set('register_flag', true);
                    header("Location: login.php");
                    exit();
                }
            }
        }
    }
}

// Include HTML:
require __DIR__ . '/register.php';
