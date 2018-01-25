<?php
/**
 * ©copyright 2016 Ashif & Sayed
 */
require_once '../DataAccess/DBHelper.php';

class User {
    private $database;
    

    public function __construct() {
        $this->database = new DBHelper();
    }
    
    
    /*
     * this function handle user
     * sign in request & forward
     * to dataaccess layer for
     * assigning new account
     */
    function SignUp($xml){
        $simplexml = $this->database->DbSignUp($xml);
        $string = $simplexml->status;
        
        if($string == 'valid'){
            return TRUE;
        } else {
            $_SESSION['signup_error'] = 'TRUE';
            return FALSE;
        }                
    }

    
    /*
     * function to pass check
     * request to data access
     * layer if the given
     * email is in database
     */
    function EmailValidityCheck($xml){
        $status = $this->database->DbEmailValidityCheck($xml);
        
        if(!$status){
            $_SESSION['email_not_found'] = 'TRUE';
        }
        
        return $status;
    }
    
    
    /*
     * Bussiness Logic layer function
     * to pass user account activation
     * request to Dataaccess layer
     */
    function ActivateUserAccount($xml){
        return $this->database->DbActivateUserAccount($xml);        
    }

    
    
    /*
     * Bussiness Logic function to match
     * user token with the given token   
     */
    function UserTokenMatch($xml){
        return $this->database->DbTokenMatch($xml);
    }
    
    
    
    /*
     * Bussiness Logic Function
     * to send change password
     * request to Dataaccess layer
     */
    function ChangePassword($xml){
        return $this->database->DbChangePassword($xml);
    }



    /*
     * Bussiness login function to
     * retrieve token for the given
     * email address from the data
     * access layer
     */
    function GetUserToken($xml){
        return $this->database->DbGetToken($xml);
    }


    /*
     * Bussiness Layer function to
     * retrieve user name from data
     * access layer
     */
    function GetUserName($simplexml){
        return $this->database->DbGetUserName($simplexml);
    }

    /*
     * Bussiness Layer Function
     * to pass user image to data
     * access layer
     */
    function UpdateUserImage($image,$user_email,$img_type){
        $this->database->DbUpdateUserImage($image,$user_email,$img_type);
    }
    
    /*
     * Data access layer function
     * to retrieve user image
     */
    function GetUserImage($user_id){
        return $this->database->DbGetUserImage($user_id);
    }


    /*
     * This function send request
     * to Dataaccess layer for user
     * id for specific mail address
     */
    function GetUserId($xml){
        $simplexml = $this->database->DbGetUserId($xml);
        return $simplexml;
    }
    
    
    
    /*
     * function for sending mail
     */
    function SendMail($email,$message,$subject){
        mail($email,$subject,$message, "From: mytestphp123@gmail.com");
    }

    /*
     * this function send query request
     * to varify user email & password
     */
    function LogIn($samplexml){
        $xml = simplexml_load_string($samplexml);
        $simplexml = $this->database->DbLogIn($samplexml);
        $string = $simplexml->password ;
        
        if($string == 'Valid'){
            $email = (string)$xml->user_email;
            $time = time()+""+microtime();
            $browser = $_SERVER['HTTP_USER_AGENT'];
            
            $_SESSION['email'] = $email;
            $_SESSION['time'] = $time;
            $_SESSION['hash'] = hash('sha512',md5($time.$email.$browser));
            
            $xml = '<cart>';
            $xml = $xml.'<user_email>'.$_SESSION['email'].'</user_email>';
            $xml = $xml.'</cart>';

            $this->database->DbFreeTempCart($xml);
            return TRUE;
        } else {
            if($simplexml->password=='Invalid'){
                $_SESSION['invalid'] = 'TRUE';
            } else if($simplexml->password=='Inactive'){
                $_SESSION['inactive'] = 'TRUE';
            }
            return FALSE;
        }
    }        

    
    /*
     * this method check if current
     * visitor already logged in to
     * his account on BookersHeaven
     */
    function IsLoggedIn(){        
        if(isset($_SESSION['email'],$_SESSION['time'])){
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $email = $_SESSION['email'];
            $time = $_SESSION['time'];
            
            if($_SESSION['hash'] == hash('sha512',md5($time.$email.$browser))){                
                return TRUE;
            } else {                
                return FALSE;
            }
        } else {           
            return FALSE;
        }        
        
    }
    
        
    /*
     * funtion to destroy session
     */
    function LogOut(){
        $xml = '<cart>';
        $xml = $xml.'<user_email>'.$_SESSION['email'].'</user_email>';
        $xml = $xml.'</cart>';
        
        $this->database->DbFreeTempCart($xml);
        
        // remove all session variables
        session_unset();
        
        // destroy the session 
        session_destroy();                
    }   
    
    
    function Checkout($simplexml){
        $xml = '<cart>';
        $xml = $xml.'<user_email>'.$_SESSION['email'].'</user_email>';
        $xml = $xml.'</cart>';
        
        
        $status = $this->database->DbCheckout($simplexml);
        if($status)       
            $this->database->DbFreeTempCart($xml);
    }
    
    
    
    function GetOrderList($simplexml){
        return $this->database->DbGetOrderList($simplexml);
    }


    /*
     * Bussiness Logic function to
     * retrieve cart information
     */
    function GetCartTotal($simplexml){
        return $this->database->DbGetCartTotal($simplexml);
    }
    
    
    /*
     * Bussiness Logic function to
     * retrieve cart total
     */
    function GetTotal($simplexml){
        return $this->database->DbGetTotal($simplexml);
    }
    
    /*
     * Bussiness Logic function to
     * return cart details from data access
     */
    function GetCartDetails($simplexml){
        return $this->database->DbGetCartDetails($simplexml);
    }
    
    
    /*
     * Bussiness Logic Function
     * to remove item from cart
     */
    function RemoveItemFromCart($simplexml){
        $this->database->DbRemoveItemFromCart($simplexml);
    }
    
    
    
    /*
     * Bussiness Logic Function to
     * forword add to cart request
     */
    function AddToCart($simplexml){
        $this->database->DbAddToCart($simplexml);
    }
    
    
    /*
     * Bussiness Logic Function to
     * forword less to cart request
     */
    function LessToCart($simplexml){
        $this->database->DbLessToCart($simplexml);
    }
    
    
    function IsRated($simplexml){
        return $this->database->DbIsRated($simplexml);
    }
    
    function AddRating($simplexml){
        $this->database->DbAddRating($simplexml);
    }
}
