<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/Admin.php';
    $admin = new Admin();
    
    if($admin->AdminIsLoggedIn()){
        
        if(isset($_POST['password'],$_POST['btn-login'])){
            $password = trim($_POST['password']);

            $xml = '<login>';
            $xml = $xml.'<password>'.$password.'</password>';
            $xml = $xml.'</login>';

            $admin->AdminChangePassword($xml);           
            header('Location: AdminLogOut.php');        
        }          
    }else{            
        header('Location: AdminLogIn.php');
    }
    
    
?>

<html>
    
    <head>
        
        <!-- Admin Login -->
        <link rel="stylesheet" href="admin-css/admin.login.css">
        
    </head>
    
    <div class="login-page">
        <div class="form">

            <h1>Change Password</h1>
            <form class="login-form" method="post">
                <input type="password" placeholder="password" name="password" required/>
                <button type="submit" id="login-button" name="btn-login">Change Password</button>              
            </form>
        </div>
    </div>
</html>

