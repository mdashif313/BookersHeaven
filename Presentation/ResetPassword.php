<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $user = new User();
    
    if($user->IsLoggedIn()){
        header('Location: Home.php');
    } elseif(empty($_GET['id']) || empty($_GET['code'])){
        header('Location: SignUp.php');       
    } elseif(isset($_GET['id']) && isset($_GET['code'])) {        
        $id = base64_decode($_GET['id']);
        $token = base64_decode($_GET['code']);
        
        $xml = '<user>';
        $xml = $xml.'<id>'.$id.'</id>';
        $xml = $xml.'<token>'.$token.'</token>';
        $xml = $xml.'</user>';
        
        if(!$user->UserTokenMatch($xml)){
            header('Location: SignUp.php');
        }  
        
        $_POST['id'] = $id;       
    }
    if(isset($_POST['txtupass'],$_POST['btn-reset'])){
            $upass = md5(trim($_POST['txtupass']));
            $id = base64_decode($_GET['id']);
                           
            $xml = '<user>';
            $xml = $xml.'<id>'.$id.'</id>';
            $xml = $xml.'<password>'.$upass.'</password>';
            $xml = $xml.'</user>';            

            $user->ChangePassword($xml);  
            header('Location: ResetHandler.php');
        }    
        
   
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Reset Password</title>

        <link rel="stylesheet" href="loginstyle.css">
 
  </head>

  <body>
  
	
    <div class="wrapper">
	<div class="container">	
                <form>
                    <h1><a href="Home.php" style="text-decoration:none">BookersHeaven</a></h1>
                </form>            		
		<br><br><br><br><br>
		<h1>Reset Password</h1>
        <form class="form" method="post">		
			<input type="password" placeholder="Password" name="txtupass" required/>            
               
			<button type="submit" id="reset-button" name="btn-reset">Reset Password</button>                        
		</form>	
        
        <form>
            <a href="SignUp.php">Sign Up</a>
            &nbsp;&nbsp;
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

    