<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/Admin.php';
    $admin = new Admin();
    
    if($admin->AdminIsLoggedIn()){
        header('Location: AdminproductList.php');
    }
    
    if(isset($_POST['username'],$_POST['password'],$_POST['btn-login'])){
        $user_name = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        $xml = '<login>';
        $xml = $xml.'<user_name>'.$user_name.'</user_name>';
        $xml = $xml.'<password>'.$password.'</password>';
        $xml = $xml.'</login>';
                
        $status = $admin->AdminLogIn($xml);
        
        if($status){
            if($_SESSION['previous_page'] != NULL){
                //$str = 'Location: '+$_SESSION['previous_page'];
                header('Location: '.$_SESSION['previous_page']);
            } else {
                header('Location: AdminproductList.php'); 
            } 
        }else{            
            header('Location: AdminLogIn.php');
        }
    }
?>

<html>
    
    <head>
        
        <!-- Admin Login -->
        <link rel="stylesheet" href="admin-css/admin.login.css">
        
    </head>
    
    <div class="login-page">
        <div class="form">

            <h1>Admin</h1>
            <form class="login-form" method="post">
                <input type="text" placeholder="username" name="username" required/>
                <input type="password" placeholder="password" name="password" required/>
                <button type="submit" id="login-button" name="btn-login">Login</button>              
            </form>
        </div>
    </div>
</html>

