<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/Admin.php';
    $admin = new Admin();
    
    
    if(isset($_GET['id'])){
        $xml = '<product>';
        $xml = $xml.'<product_id>'.$_GET['id'].'</product_id>';
        $xml = $xml.'</product>'; 
        
        $imagexml = simplexml_load_string($admin->GetProductImageType($xml));
        $img_type = $imagexml->img_type;
        
        $image = $admin->GetProductImage($xml);
        
        header('Content-type: '.$img_type);
        echo $image;
    } else {
        header('Location: Home.php');
    }

