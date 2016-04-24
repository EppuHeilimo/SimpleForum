<?php

class DataBase
{
    private $conn = null;
    
    /* Constructor. Creates a DB connection. */
    public function __construct() 
    {     
        $this->conn = new PDO('mysql:host=mysql.labranet.jamk.fi;dbname=H8566;charset=utf8',
							'H8566','jznmOhKezTpPxioCt4Y2tK0R3v8LKFt6');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        if ($this->conn == false) {
            die("Could not connect to database: " . $this->conn->errorInfo());
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
        $result = $this->conn->query("SELECT * FROM ForumUser WHERE Name = '$username'");
        $count = count($result->fetchAll());
        if($count > 0)
            return true;
        else
            return false;
    }
    
    public function emailExists($email) 
    {
        $result = $this->conn->query("SELECT * FROM ForumUser WHERE Name = '$email'");
        $count = count($result->fetchAll());
        if($count > 0)
            return true;
        else
            return false;
    }
    
    /**
     * Inserts a new user into the database.
     */
    public function createUser($username, $password, $email) 
    {
        $sql = "INSERT INTO ForumUser (JoinDate, Name, PassHash, LastLogin, Email) VALUES (CURDATE(), '$username', '$password', CURDATE(), '$email');";
        $result = $this->conn->exec($sql);
        
        /* Insert accesslevel 0 (default) to all boards for the user */
        $boards = $this->getBoards();
        $boardname = "BoardName";
        foreach($boards as $row)
        {
            $sql = "INSERT INTO Moderator (FK_Board, FK_User, FK_AccessLevel) VALUES ((SELECT ID FROM Board where BoardName='$row[$boardname]'),(SELECT ID FROM ForumUser where Name='$username'), (SELECT ID FROM AccessLevel where ALevel='0'));";
            $result = $this->conn->exec($sql);
        }
        
        if(!$result)
            print_r($this->conn->errorInfo());
        return $result != false;
    }
    
    /**
     * Gets a user's password hash.
     */
    public function getPassword($username) 
    {
        $result = $this->conn->query("SELECT PassHash FROM ForumUser WHERE Name = '$username'");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $pwhash = $row['PassHash'];
        return $pwhash;
    }
    
    public function getBoards()
    {
        $res = $this->conn->query("SELECT ID, BoardName, BoardDescription from Board");
        return $res;
    }
    
    public function getThreads($board)
    {
        $res = $this->conn->query("SELECT ThreadName, ViewCount, PostCount, CreateDate from Thread where FK_Board=(SELECT ID FROM Board where BoardName='$board')");
        return $res;
    }
    
    public function isModerator($username, $board)
    {
        /* Check if user has higher than default (0) access level in the board */
        $res = $this->conn->query("SELECT ALevel from AccessLevel where ID=(SELECT FK_AccessLevel from Moderator where FK_User=(SELECT ID from ForumUser where Name='$username') and FK_Board=(SELECT ID FROM Board where BoardName='$board')));");
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $level = $row['ALevel'];
        if($level > 0)
            return true;
        return false;
    }
    
    public function isAdmin($username)
    {
        /*Checks if user is admin*/
        $res = $this->conn->query("SELECT isAdmin from ForumUser where Name='$username';");
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $is = $row['isAdmin'];
        if($is)
        {
            return true;
        }
        return false;
    }
    
    public function addBoard($boardname, $boarddesc)
    {
        $res = $this->conn->exec("INSERT INTO Board (BoardName, BoardDescription) VALUES ('$boardname', '$boarddesc');");
    }
    
    public function addThread($board, $subject, $message, $user)
    {
        $res = $this->conn->exec("INSERT INTO Thread (ThreadName, ViewCount, PostCount, CreateDate, Sticky, Locked, FK_Board)
                VALUES ('$subject', 0, 1, NOW(), 0, 0, (select ID from Board where BoardName = '$board'));");
        $this->addPost($subject, $message, $user, $subject);
    }
    
    public function addPost($subject, $message, $user, $thread)
    {
        $res = $this->conn->exec("INSERT INTO Post (PostDate, PostName, PostMessage, FK_Thread, FK_User)
            VALUES (NOW(), '$subject', '$message', (select ID from Thread where ThreadName = '$thread'),
            (select ID from ForumUser where Name = '$user'));");
    }
    
    public function getPosts($thread){
        $res = $this->conn->query("SELECT * from Post where FK_Thread = (SELECT ID from Thread where ThreadName = '$thread') order by PostDate ASC;");
        return $res;
    }
    
    //TODO: optimize: get poster with getPosts query
    public function getPoster($post, $postdate){
        $res = $this->conn->query("SELECT Name from ForumUser where ID = (SELECT FK_User from Post where PostName='$post' and PostDate = '$postdate')");
        $result = $res->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}

