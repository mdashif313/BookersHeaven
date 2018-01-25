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
        $xml = '<shipment>';
        $xml = $xml.'<shipment_id>'.$_GET['id'].'</shipment_id>';      
        $xml = $xml.'</shipment>'; 
        
        $admin->ProductDelivery($xml);
        
        header('Location: OrderList.php');
    } else {
        header('Location: AdminproductList.php');
    }
    
