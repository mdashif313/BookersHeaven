<?php
    session_start();
    
    require_once '../BussinessLogic/User.php';
    $user = new User();
    
    if(!$user->IsLoggedIn()){
        header('Location: Home.php');
    }
    
    if(isset($_POST['submit'],$_POST['rating'],$_POST['feedback'])){
        
        $xml = '<feedback>';
        $xml = $xml.'<product_id>'.$_POST['product_id'].'</product_id>';
        $xml = $xml.'<user_email>'.$_POST['user_email'].'</user_email>';
        $xml = $xml.'<rating>'.$_POST['rating'].'</rating>';
        $xml = $xml.'<feedback>'.$_POST['feedback'].'</feedback>';
        $xml = $xml.'</feedback>';        
        
        $user->AddRating($xml);        
    }
    
    if(isset($_SESSION['previous_page'])){
        header('Location: '.$_SESSION['previous_page']);
    }  
