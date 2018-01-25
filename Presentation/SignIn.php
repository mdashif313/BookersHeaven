<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $userLogin = new User();
    
    if($userLogin->IsLoggedIn()){
        header('Location: Home.php');
    }
    
?>


<html>
  <head>
    <meta charset="UTF-8">
    <title>Sign In</title>

        <link rel="stylesheet" href="loginstyle.css">
 
  </head>

  <body>
  
	
    <div class="wrapper">
	<div class="container">	
                <form>
                    <h1><a href="Home.php" style="text-decoration:none">BookersHeaven</a></h1>
                </form>            		
		<br><br><br><br><br><br><br><br><br><br><br><br>
		<h2>A mail has been sent to your email address, 
            please click the link sent in mail to activate your account</h2>	        
                
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