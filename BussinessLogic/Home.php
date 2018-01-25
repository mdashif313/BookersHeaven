<?php
require_once 'SessionHandler.php';
SecureSessionStart();

    echo $_SESSION['email'];
    require_once 'User.php';
    $user = new User();
    
    if($user->IsLoggedIn()){
        echo 'Hello World';
    }
