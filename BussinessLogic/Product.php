<?php
/**
 * ©copyright 2016 Ashif & Sayed
 */
require_once '../DataAccess/DBHelper.php';

class Product {
    private $database;
    

    public function __construct() {
        $this->database = new DBHelper();
    }
    
    
    /*
     * Bussiness Logic layer function
     * to implement livesearch
     */
    function LiveSearch($simplexml){
        return $this->database->DbLiveSearch($simplexml);
    }
    
    /*
     * Bussiness Logic layer function
     * to find common search
     */
    function CommonSearch($simplexml){
        return $this->database->DbCommonSearch($simplexml);
    }
    
    
    /*
     * Bussiness Logic layer function
     * to product search
     */
    function SearchProduct($simplexml){
        return $this->database->DbSearchProduct($simplexml);
    }
    
    
    /*
     * Bussiness Logic Function to
     * return latet two products
     * from Data Access layer
     */
    function LatestTwoProducts(){
        return $this->database->DbLatestTwoProducts();
    }
    
    
    /*
     * Bussiness Logic Function to
     * return latet Nine products
     * from Data Access layer
     */
    function LatestNineProducts(){
        return $this->database->DbLatestNineProducts();
    }
    
    
    /*
     * Bussiness Logic layer function
     * to get product details from 
     * data access layer
     */
    function GetProductDetails($simplexml){
        return $this->database->DbGetProductDetails($simplexml);
    }
    
    
    /*
     * Bussiness Logic function to
     * fetch ratig details
     */
    function GetRatingDetails($simplexml){
        return $this->database->DbGetRatingDetails($simplexml);
    }
    
    /*
     * Bussiness Logic layer function
     * to fetch feedback list
     */
    function GetFeedback($simplexml){
        return $this->database->DbGetFeedback($simplexml);
    }
}    