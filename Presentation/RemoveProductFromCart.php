<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/User.php';
    $user = new User();
    
    if(!$user->IsLoggedIn()){
        header('Location: LogIn.php');
    }
    
    if(isset($_GET['id'])){
        $user_email = $_SESSION['email'];
        $xml = '<cart>';
        $xml = $xml.'<product_id>'.$_GET['id'].'</product_id>';
        $xml = $xml.'<user_email>'.$user_email.'</user_email>';
        $xml = $xml.'</cart>'; 
        
        $user->RemoveItemFromCart($xml);           
    }
    header('Location: Cart.php');
    
    
