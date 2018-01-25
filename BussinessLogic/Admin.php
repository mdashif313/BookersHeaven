<?php

/**
 * ©copyright 2016 Ashif & Sayed
 */
require_once '../DataAccess/DBHelper.php';


class Admin{
    private $database;

    public function __construct() {
        $this->database = new DBHelper();
    }
    
    
    /*
     * this function send query request
     * to varify Admin name & password
     */
    function AdminLogIn($samplexml){
        $xml = simplexml_load_string($samplexml);
        $log_in_status = $this->database->DbAdminLogIn($samplexml);
        
        if($log_in_status){
            $admin_name = (string)$xml->user_name;
            $time = time()+""+microtime();
            $browser = $_SERVER['HTTP_USER_AGENT'];
            
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['time'] = $time;
            $_SESSION['hash'] = hash('sha512',md5($time.$admin_name.$browser));

            return TRUE;
        } else {
            return FALSE;
        }
    }   

    /*
     * this method check if current
     * visitor already logged in to
     * his account on BookersAdmin
     */
    function AdminIsLoggedIn(){        
        if(isset($_SESSION['admin_name'],$_SESSION['time'])){
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $admin_name = $_SESSION['admin_name'];
            $time = $_SESSION['time'];
            
            if($_SESSION['hash'] == hash('sha512',md5($time.$admin_name.$browser))){                
                return TRUE;
            } else {                
                return FALSE;
            }
        } else {           
            return FALSE;
        }                
    }
    
    
    /*
     * Bussiness Logic Function
     * to send change Admin password
     * request to Dataaccess layer
     */
    function AdminChangePassword($xml){
        $this->database->DbAdminChangePassword($xml);
    }
    
    
    /*
     * Bussiness Logic layer function to
     * send add prtoduct request to data
     * access layer
     */
    function AddProduct($simplexml,$image_file){
        $this->database->DbAddProduct($simplexml,$image_file);
    }

    
    /*
     * This function return product list       
     */
    function GetProductList(){
        return $this->database->DbGetProductList();
    }

    
    /*
     * bussiness logic function to delete product
     */
    function DeleteProduct($xml){
        $this->database->DbDeleteProduct($xml);
    }


    /*
     * bussiness layer function to
     * retrieve product image type
     */
    function GetProductImageType($xml){
        return $this->database->DbGetProductImageType($xml);
    }


    /*
     * Bussiness Logic function
     * to retriev product image
     */
    function GetProductImage($xml){
        return $this->database->DbGetProductImage($xml);
    }

    
    /*
     * Bussiness Logic function
     * to retrieve basic product info
     */
    function GetProductBasicInfo($xml){
        return $this->database->DbGetProductBasicInfo($xml);
    }
    

    /*
     * Bussiness logic function to 
     * forward product image update request
     */
    function UpdateProductImage($image,$product_id,$img_type){
        $this->database->DbUpdateProductImage($image, $product_id, $img_type);
    }
        

    /*
     * Bussiness layer function to
     * forward all product information
     */
    function GetAllProductInfo($simplexml){
        return $this->database->DbGetAllProductInfo($simplexml);
    }


    
    /*
     * bussiness logic function to 
     * forward product update request
     */
    function UpdateProductInfo($simplexml){
        $this->database->DbUpdateProductInfo($simplexml);
    }


    function GetOrderHistory(){
        return $this->database->DbGetOrderHistory();
    }

    /*
     * product delivery function
     */
    function ProductDelivery($simplexml){
        $this->database->DbProductDelivery($simplexml);
    }


    /*
     * funtion to destroy Admin session
     */
    function LogOut(){
        // remove all session variables
        session_unset();
        
        // destroy the session 
        session_destroy();
    }
    
}

