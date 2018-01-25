<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/Admin.php';
    $admin = new Admin();
    
    if(!$admin->AdminIsLoggedIn()){
        header('Location: AdminLogIn.php');
    }
    
    if(isset($_GET['id'])){
        $xml = '<product>';
        $xml = $xml.'<product_id>'.$_GET['id'].'</product_id>';
        $xml = $xml.'</product>'; 
        
        $admin->DeleteProduct($xml);           
    }
    header('Location: AdminproductList.php');
    
    
