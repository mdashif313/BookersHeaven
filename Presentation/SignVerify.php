<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $userSignup = new User();
    
    if($userSignup->IsLoggedIn()){
        header('Location: Home.php');
    } elseif(empty($_GET['id']) || empty($_GET['code'])){
        header('Location: LogIn.php');
    } elseif(isset($_GET['id']) && isset($_GET['code'])) {
        $id = base64_decode($_GET['id']);
        
        $xml = '<signup>';
        $xml = $xml.'<id>'.$id.'</id>';
        $xml = $xml.'</signup>';        
        
        if($userSignup->ActivateUserAccount($xml)){
            $msg = 'Welcome to Bookers Heaven! Your account is now active';
        } else {
            $msg = 'Ops! Your account has already activated';
        }
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
		<h2><?php echo $msg?></h2>	        
        <br>
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