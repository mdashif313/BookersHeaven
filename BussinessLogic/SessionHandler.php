<?php
/*
 * ©copyright 2016 Ashif & Sayed
 */

    /*
     * funtion to implement Secured Session
     */
    function SecureSessionStart(){
        $session_name = 'BookersHeavenUser';
        $secure = false;
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        
        //This ensure use only cookies to keep record of session
        ini_set('session.use_only_cookies', 1);
        
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params(); 
        // Set the parameters
        session_set_cookie_params($cookieParams["lifetime"], 
                $cookieParams["path"], 
                $cookieParams["domain"],
                $secure, 
                $httponly);
        
        // Sets the session name to the one set above.
        session_name($session_name);
        // Start the PHP session 
        session_start();            
        // regenerated the session, delete the old one. 
        // It mainly helps prevent session fixation attacks
        session_regenerate_id(true);            
    }
    
    
    
    
