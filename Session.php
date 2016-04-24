<?php

 
class Session 
{ 
    private static $instance = null;
	
	    /** Constructor */
    protected function __construct() 
    {
        if (static::$instance === null) {
            session_start();
        }
    }
	
    public static function start() 
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function clear($key) 
    {
        if (isset($key)) {
            unset($_SESSION[$key]);
            return true;
        } else {
            return session_unset();
        }
    }
    
    public function destroy() 
    {
        static::$instance = null;
        return session_destroy();
    }
    
    public function get($key) 
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }
    

    public function set($key, $value) 
    {
        $_SESSION[$key] = $value;
        return $_SESSION[$key];
    }
    
    public function getUser()
    {
        return Session::get('user');
    }
 }
 