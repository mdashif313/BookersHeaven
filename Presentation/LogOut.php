<?php
    session_start();
/**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $userLogin = new User();
    
    if(!$userLogin->IsLoggedIn()){
        header('Location: Home.php');
    } else{
        $userLogin->LogOut();
        header('Location: LogIn.php');
    }
        
/*    else
        header('Location: https://www.google.co.uk');*/