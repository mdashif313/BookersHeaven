<?php
    session_start();
    
 /**
 * ©copyright 2016 Ashif & Sayed
 */
    
    require_once '../BussinessLogic/User.php';
    
    $userSignup = new User();
    
    if($userSignup->IsLoggedIn()){
        header('Location: Home.php');
    }
        
    if(isset($_POST['txtemail'],$_POST['txtupass'],$_POST['txtconfirm'],$_POST['btn-signup'], $_POST['captcha']))
    {
        $user_email = trim($_POST['txtemail']);
        $user_name = trim($_POST['txtuname']);
        $upass = trim($_POST['txtupass']);
        $confirm = trim($_POST['txtconfirm']);
        $captcha = trim($_POST['captcha']);
        
        if($upass != $confirm){
            $_SESSION['signup_mismatch'] = 'TRUE';
            header('Location: SignUp.php');            
        } elseif ($captcha != $_SESSION['digit']) {
            $_SESSION['captcha_mismatch'] = 'TRUE';
            header('Location: SignUp.php');    
        } else {
            $password = base64_encode(md5($upass));
        
            $xml = '<login>';
            $xml = $xml.'<user_email>'.$user_email.'</user_email>';
            $xml = $xml.'<user_name>'.$user_name.'</user_name>';
            $xml = $xml.'<password>'.$password.'</password>';
            $xml = $xml.'</login>';
            
            $status = $userSignup->SignUp($xml);
            
            if($status){
                $resultid = $userSignup->GetUserId($xml);
                $xmlid = simplexml_load_string($resultid);                
                $xid = $xmlid->id;
                $id = base64_encode($xid);
                $code =  base64_encode(hash('sha512',  rand().time().$user_email.microtime())) ;
                
                $message = " 
                    Welcome to BookersHeaven!
                    
                    To complete your registration  please , just click following link...
                    
                    http://localhost:8080/BookersHeaven/Presentation/signverify.php?id=$id&code=$code      Click HERE to Activate :)
                    
                    Thanks You";
                $subject = "BookersHeaven - Confirm Registration";
                
                $userSignup->SendMail($user_email, $message, $subject);
                
                header('Location: SignIn.php');
            } else{         
                $_SESSION['signup_error'] = 'TRUE';
                header('Location: SignUp.php');
            }
        }
                                
    }
?>


<html>
  <head>
    <meta charset="UTF-8">
    <title>Sign Up</title>

        <link rel="stylesheet" href="loginstyle.css">
 
  </head>

  <body>
  
	
    <div class="wrapper">
	<div class="container">	
                <form>
                    <h1><a href="Home.php" style="text-decoration:none">BookersHeaven</a></h1>
                </form>            		
		<br><br><br><br><br>
		<h1>Sign Up</h1>
		<form class="form" method="post">
			<input type="text" placeholder="Email" name="txtemail" required/>
            <input type="text" placeholder="Username" name="txtuname" required />
			<input type="password" placeholder="Password" name="txtupass" required/>
            <input type="password" placeholder="Confirm Password" name="txtconfirm" required/>
            <p><img src="Captcha.php" width="250" height="60" border="1" alt="CAPTCHA"></p>
            <p style="padding: 6px;">
            <input type="text" placeholder="Captcha" name="captcha">
        
            <?php if(isset($_SESSION['signup_error'])){                  
                ?>
                <h4 style="color:red;">Email you entered already in use</h4>
            <?php  }else if (isset ($_SESSION['ca_mismatch'])){
                ?>
                <h4 style="color:red;">Password you entered do not match</h4>
            <?php  }else if (isset ($_SESSION['captcha_mismatch'])){
                ?>
                <h4 style="color:red;">Captcha you entered do not match</h4>
            <?php } ?>
			<button type="submit" id="login-button" name="btn-signup">SignUp</button>                        
		</form>	
        
        <form>
            <a href="ForgetPass.php">Forget Password?</a>
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
