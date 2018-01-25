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
    
    if(isset($_POST['txtemail'],$_POST['btn-submit'])){
        $user_email = trim($_POST['txtemail']);
        
        $xml = '<user>';
        $xml = $xml.'<user_email>'.$user_email.'</user_email>';
        $xml = $xml.'</user>';        
        
        if($user->EmailValidityCheck($xml)){
            $resultid = $user->GetUserId($xml);
            $xmlid = simplexml_load_string($resultid);
            $xid = $xmlid->id;
            $id = base64_encode($xid);
            $resulttoken = $user->GetUserToken($xml);
            $xmltoken = simplexml_load_string($resulttoken);
            $token = $xmltoken->token;
            $code =  base64_encode($token);

            $message = " 
                Welcome to BookersHeaven!

                To change your password , just click following link...

                http://localhost:8080/BookersHeaven/Presentation/ResetPassword.php?id=$id&code=$code'      Click HERE to Contonue :)
                                    
                Thanks You";
            $subject = "BookersHeaven - Reset Password";

            $user->SendMail($user_email, $message, $subject);
            header('Location: FpassSuccess.php');
        } else {           
            header('Location: ForgetPass.php');
        }
    }
?>
    
<html>
  <head>
    <meta charset="UTF-8">
    <title>Forget Password</title>

        <link rel="stylesheet" href="loginstyle.css">
 
  </head>

  <body>
  
	
    <div class="wrapper">
	<div class="container">	
                <form>
                    <h1><a href="Home.php" style="text-decoration:none">BookersHeaven</a></h1>
                </form>            		
		<br><br><br><br><br>
		<h1>Forget Password</h1>
		<form class="form" method="post">
			<input type="text" placeholder="Email" name="txtemail" required/>
            
            <?php if(isset($_SESSION['email_not_found'])){?>
                <h4 style="color:red;">Email address you entered does not registerd</h4>
            <?php } ?>
            
			<button type="submit" id="submit-button" name="btn-submit">submit</button>                        
		</form>	
        
        <form>
            <a href="LogIn.php">LogIn</a>
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