<?php

/**
 * Description of User
 *
 * @©copyright 2016 Ashif & Sayed
 */
require_once '../DataAccess/DBHelper.php';

class User {
    private $database;
    private $session;


    public function __construct() {
        $this->database = new DBHelper();
        $this->session = new SessionHandler();
    }
    
    
    /*
     * this function send query request
     * to varify user email & password
     */
    function LogIn($xml){
        $simplexml = $this->database->DbLogIn($xml);
        $string = $simplexml->password ;//preg_replace('/\s+/', '', $simplexml->password);
        echo $string;
        
        // Check validity of password
        if($string == 'Valid'){                                                                        
            // Get the user-agent string of the user.
            $browser = $_SERVER['HTTP_USER_AGENT'];
            // XSS protection as we might print this value
            $email = $xml->user_email;
            $hash = $this->GetHash($xml);
            $time = ""+microtime();
            
            $_SESSION['email'] = $email;
            $_SESSION['time'] = $time;

            $_SESSION['login'] = base64_encode($time.$hash.$browser);
        }
                       
        return $simplexml;
    }        
    
    
    private function GetHash($xml){
        return $this->database->DbGetHash($xml);
    }
}
