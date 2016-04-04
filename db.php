<?php

 
require_once(__DIR__ . "/dbconfig.php");
 
class DataBase
{
    private $conn = null;
    
    /* Constructor. Creates a DB connection. */
    public function __construct() 
    {     
        $this->conn = new PDO('mysql:host=localhost;dbname=asd;charset=utf8',
							'root','pass');
        if ($this->conn == false) {
            die("Could not connect to database: " . $conn->errorInfo());
        }
    }
    
    /* Destructor. Closes the DB connection. */
    public function __destruct() 
    {
        $this->conn = null;
    }
    
    /**
     * Checks if the given user exists in the database.
     */
    public function userExists($username) 
    {
        $result = $conn->query("SELECT * FROM user WHERE username = $username")
        );
        return ($result);
    }
    
    /**
     * Inserts a new user into the database.
     */
    public function createUser($username, $password) 
    {
        $result = $conn->query("INSERT INTO user(username, pwhash) VALUES ($username, $password)");
        return $result != false;
    }
    
    /**
     * Gets a user's password hash.
     */
    public function getPassword($username) 
    {
        $result = $conn->query("SELECT pwhash FROM user WHERE username = $username");
        return result != false;
    }
    
    /**
     * Gets an auth token row from the database that matches the given selector
     * and hasn't expired.
     */
    public function getAuthToken($selector) 
    {
        $query = <<<SQL
            SELECT acc.username, auth.token 
                FROM auth_token AS auth
                INNER JOIN account AS acc 
                    ON acc.id = auth.userid
                WHERE auth.selector = $1 AND auth.expires > NOW()
SQL;
        
        $res = pg_query_params(
            $this->conn,
            $query,
            array($selector)
        );
        $arr = pg_fetch_array($res);
        return $arr;
    }
    
    /**
     * Remove the given token from the database.
     */
    public function removeToken($selector, $token) 
    {
        pg_query_params(
            $this->conn,
            "DELETE FROM auth_token WHERE selector = $1 AND token = $2",
            array($selector, $token)
        );
        $this->clearExpiredTokens();
    }
    
    /**
     * Adds a new auth token to the database.
     */
    public function addToken($username, $selector, $token, $expiry) 
    {
        $userid = $this->getUserId($username);
        if ($userid != null) {
            $res = pg_query_params(
                $this->conn,
                "INSERT INTO auth_token(userid, selector, token, expires) VALUES ($1, $2, $3, $4)",
                array($userid, $selector, $token, date("Y-m-d H:i:s", $expiry))
            );
            return $res != false;
        }
        return false;
    }
    
    /**
     * Map a username to a userid.
     */
    protected function getUserId($username) 
    {
        $res = pg_query_params(
            $this->conn,
            "SELECT id FROM account WHERE username = $1",
            array($username)
        );
        if ($res == false) {
            return null;
        }
        $arr = pg_fetch_array($res);
        return isset($arr['id']) ? $arr['id'] : null;
    }
    
    /** Clears expired tokens from the database */
    protected function clearExpiredTokens() 
    {
        $conn->query("DELETE FROM auth_token WHERE expires < NOW()");
    }
}
