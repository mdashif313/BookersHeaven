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
    
    
    function DbLogIn($xml){
        $user_email = $xml->user_email;
        $password = $xml->password;
        
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()==0){
            $result = '<status>
                        <password>
                        Invalid
                        </password>
                      </status>'; 
            echo 'Fail'.$query->rowCount();
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        } 
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        if($row['user_status']==0){
            $result = '<status>
                        <password>
                        Inactive
                        </password>
                      </status>'; 
            echo 'Inactive'.$query->rowCount();
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }
        
        if($row['password']==$password){
            $result = '<status>
                        <password>
                        Correct
                        </password>
                      </status>'; 
            echo 'Correct'.$query->rowCount();
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }
        $result = '<status>
                <password>
                true
                </password>
              </status>'; 
        echo 'Incorrect'.$query->rowCount();
        $simplexml = simplexml_load_string($result);
        return $simplexml;
                        
    }
}
