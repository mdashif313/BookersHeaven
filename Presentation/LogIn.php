<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $userLogin = new User();
    
    if($userLogin->IsLoggedIn()){
        if(isset($_SESSION['previous_page'])){
            header('Location: '.$_SESSION['previous_page']);
        }
        header('Location: Home.php');
    }
        
    if(isset($_POST['txtemail'],$_POST['txtupass'],$_POST['btn-login']))
    {
        $user_email = trim($_POST['txtemail']);
        $upass = trim($_POST['txtupass']);
        $password = base64_encode(md5($upass));
        
        $xml = '<login>';
        $xml = $xml.'<user_email>'.$user_email.'</user_email>';
        $xml = $xml.'<password>'.$password.'</password>';
        $xml = $xml.'</login>';
                
        $status = $userLogin->LogIn($xml);
        
        if($status){
            if($_SESSION['previous_page'] != NULL){
                header('Location: '.$_SESSION['previous_page']);
            } else {
                header('Location: Home.php');
            }            
        } else{            
            header('Location: LogIn.php');
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
		<br><br><br><br><br>
		<h1>LogIn</h1>
		<form class="form" method="post">
			<input type="text" placeholder="Email" name="txtemail" required/>
			<input type="password" placeholder="Password" name="txtupass" required/>
            <?php if(isset($_SESSION['invalid'])){
                ?>
                <h4 style="color:red;">Invalid email address or password</h4>
            <?php  }else if (isset ($_SESSION['inactive'])){
                ?>
                <h4 style="color:red;">Please activate your account first</h4>
            <?php } ?>
			<button type="submit" id="login-button" name="btn-login">Login</button>                        
		</form>	
        
        <form>
            <a href="ForgetPass.php">Forget Password?</a>
            &nbsp;&nbsp;
            <a href="SignUp.php">Sign Up</a>
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