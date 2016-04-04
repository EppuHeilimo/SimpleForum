<?php

require_once(__DIR__ . "/config.php");
 
class User
{
    private $loggedIn = false;
    private $username = null;
    
    /** 
     * Login with username and password
     */
    public function login($username, $password) 
    {
        $db = new DataBase();
        if ($db->userExists($username)) {
            $pwhash = $db->getPassword($username);
            if (pw_verify($password, $pwhash)) {
                $this->loggedIn = true;
                $this->username = $username;
                return true;
            }
        }
        return false;
    }
	public function isLoggedIn()
	{
		return loggedIn;
	}
}
