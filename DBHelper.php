<?php
/**
 * Main Class to implement
 * Data Access Layer
 *
 * ©copyright 2016 Ashif & Sayed
 */
class DBHelper {
    private $host = "localhost";
    private $db_name = "bookersheaven";
    private $username = "root";
    private $password = "";
    private $conn;
    
    
    function __construct() {
        $this->conn = NULL;
        
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Sucess';
        } catch (Exception $ex) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
    
    
    /*
     * this function generate random
     * key to secure user session
     */
    function DbHash($password){
        return rtrim(base64_encode(hash('gost-crypto',microtime().rand().$password)
                .md5(microtime()+rand().'fgwguwieh0589h573hc29rt3htg')
                .hash('ripemd160', microtime().'34b5ljhbfb472Dy93HcDQWE NFfeuyhfeBcd'.microtime())),"=");
    }
    
    
    /*
     * this function query & return 
     * the hash string for spacific 
     * user email from database
     */
    function DbGetHash($xml){
        $user_email = $xml->user_email;
        
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $hash = '<hash>';
        $hash = $hash.'<key>'.$row['hash'].'</key>';
        $hash = $hash.'</hash>';      
        
        $simplexml = simplexml_load_string($hash);
        return $simplexml;
    }

    
    function DbSignUp(){
        $hash = $this->DbHash($password);
        $sqlHash = "UPDATE user SET hash='$hash' WHERE user_email = '$user_email'";
        $this->conn->exec($sqlHash);
    }



    /*
     * this is dataaccess layer function
     * to check log in email & password
     */    
    function DbLogIn($xml){
        $user_email = $xml->user_email;
        $password = $xml->password;
        
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()==0){
            $result = '<status>
                        <password>Invalid</password>
                      </status>'; 
            echo 'Fail'.$query->rowCount();
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        } 
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        if($row['user_status']==0){
            $result = '<status>
                        <password>Inactive</password>
                      </status>'; 
            echo 'Inactive'.$query->rowCount();
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }
        
        if($row['password']==$password){
            $result = '<status>
                        <password>Valid</password>
                      </status>'; 
            echo 'Correct'.$query->rowCount();            
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }
        $result = '<status>
                <password>Invalid</password>
              </status>'; 
        echo 'Incorrect'.$query->rowCount();
        $simplexml = simplexml_load_string($result);
        return $simplexml;                        
    }
}
