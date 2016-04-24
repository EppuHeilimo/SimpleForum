<?php

//some utility
require_once(__DIR__ . '/config.php');

function isLoggedIn($redirect) 
{
    $session = Session::start();
    $user = Session::getUser();
    if (isset($user) && $user->isLoggedIn()) 
    {  
        header("Location: $redirect");
    } 
}
/*
	check if user is already logged in and redirect
 */
function redirectTo($redirect = 'index.php')
{
	$logged = isLoggedIn();
	if ($logged && !headers_sent()) {
        if (!headers_sent() && isset($redirect)) {
            header("Location: '$redirect'");
        }
        exit();
    }
}

/*
	if user has to login to view page, redirect to login
 */
function hasToLogIn()
{
	$redirect = 'login.php';
    if (!isLoggedIn()) {
        if (isset($redirect) && !headers_sent()) {
            header("Location: {$redirect}");
        }
        exit();
    }
}


/**
 * Makes a new login token for the given user and sets cookie.
 */
function makeNewToken($user) 
{
    $expiry = time() + LOGIN_EXPIRY_TIME;
    $token = $user->generateToken($expiry);
    setcookie('simple_forum', $token, $expiry);    
}

/** Clears the login token cookie */
function clearTokenCookie() 
{
    setcookie('simple_forum', null, time() - 3600);
}


/**
 * Checks whether the given password meets all the requirements for passwords.
 */
 
function isValidPassword($passwd) 
{
    if (strlen($passwd) >= MIN_PASSWORD) {
        return true;
    }
    return false;
}

/**
 * Checks whether the given username meets all the requirements for usernames.
 */
function isValidUsername($username) 
{
    if (strlen($username) >= MIN_USERNAME) {
        return true;
    }
    return false;
}

/**
 * Hash a password.
 */
function pw_encode($password) 
{
    $hasher = new PasswordHash(8, FALSE);
    $pw = $hasher->HashPassword($password);
    return $pw;
}

/**
 * Verify that the password matches the given password hash.
 */
function pw_verify($password, $pwhash)
{
    $hasher = new PasswordHash(8, FALSE);
    return $hasher->CheckPassword($password, $pwhash);
}

