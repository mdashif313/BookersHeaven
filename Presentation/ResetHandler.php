<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $user = new User();
    
    if($user->IsLoggedIn()){
        header('Location: Home.php');
    }
  
    
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Log In</title>

        <link rel="stylesheet" href="loginstyle.css">
 
  </head>

  <body>
  
	
    <div class="wrapper">
	<div class="container">	
        <form>
            <h1><a href="Home.php" style="text-decoration:none">BookersHeaven</a></h1>
        </form>            		
		<br><br><br><br><br><br><br><br><br><br><br><br>
        <h2>Your Password has been successfully changed.</h2>	        
                
        <form>            
            <a href="LogIn.php">Log In</a>
        </form>
        
	</div>	
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>

  </body>
</html>