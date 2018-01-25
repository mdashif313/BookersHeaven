<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/User.php';    
    $user = new User();
    
    if(!$user->IsLoggedIn()){
        header('Location: LogIn.php');
    }
    
    if(isset($_POST["submit"]) && isset($_POST["country"]) && isset($_POST["city"]) &&isset($_POST['ccv'])
        && isset($_POST["address"]) && isset($_POST["postal_code"]) && isset($_POST["date"]) && isset($_POST['mobile_no'])
        && isset($_POST["time"]) && isset($_POST["credit_card"]) && isset($_POST["card_no"])){
        
        $user_email = $_SESSION['email'];
        
        $xml = '<shipment>';
        $xml = $xml.'<user_email>'.$user_email.'</user_email>';
        $xml = $xml.'<shipment_date>'.$_POST["date"].'</shipment_date>';
        $xml = $xml.'<time_slot>'.$_POST["time"].'</time_slot>';            
        $xml = $xml.'<shipment_address>'.'Country : '.$_POST["country"].' ,City : '.$_POST["city"]
                .',Post code : '.$_POST["postal_code"].',Address : '.$_POST["address"]
                .'</shipment_address>';
        $xml = $xml.'<mobile_no>'.$_POST['mobile_no'].'</mobile_no>';
        $xml = $xml.'</shipment>'; 
        
        $user->Checkout($xml);
        
        header('Location: OrderHistory.php');
    }
?>




<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookers Heaven Checkout</title>
    
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <!-- Upload Button -->
    <link rel="stylesheet" href="css/file.upload.button.css">

  </head>
  <body>
   
    
    
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="Home.php">Bookers<span>Heaven</span></a></h1>
                    </div>
                </div>                              
            </div>
        </div>
    </div> <!-- End site branding area -->
    
    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="Home.php">Home</a></li>
                        <li><a href="SearchPage.php">Search Page</a></li>
                        <li><a href="Cart.php">Cart</a></li>
                        <li><a href="Checkout.php">Checkout</a></li>
                        <li><a href="Contact.php">Contact</a></li>
                        <li><a href="MyAccount.php">My Account</a></li> 
                        <li><a href="LogOut.php">Log Out</a></li>
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    		
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                
                <p style="padding: 25px;">
                <!-- Here I've to put the code -->
                
                <form method="POST" enctype="multipart/form-data" style="margin-left: 40px; width: 400px;">
                    <p><b>Country</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="country" name="country" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                     
                    <p><b>City</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="city" name="city" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Address</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="address" name="address" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Postal Code</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="postal code" name="postal_code" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Date</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="date" name="date" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                    
                    <p><b>Time</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="time" name="time" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Mobile No</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="mobile no" name="mobile_no" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Credit Card</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="credit card" name="credit_card" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Card No</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="card no" name="card_no" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>CCV</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="ccv" name="ccv" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p style="padding: 25px;">
                    
                    <input type="submit" value="Checkout" name="submit">        
                </form>
                                
                <!-- Here I've to put the code -->
                
            </div>
            <p style="padding: 250px;">
        </div>
    </div>

    
        
    <div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-about-us">
                        <h2>Bookers<span>Heaven</span></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?</p>
                        <div class="footer-social">
                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">User Navigation </h2>
                        <ul>
                            <li><a href="MyAccount.php">My account</a></li>
                            <li><a href="OrderHistory.php">Order history</a></li>
                            <li><a href="Cart.php">Cart</a></li>
                            <li><a href="Checkout.php">Checkout</a></li>
                            <li><a href="Contact.php">Contact</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Categories</h2>
                        <ul>
                            <li><a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Kids">Kids</a></li>
                            <li><a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Horror">Horror</a></li>                            
                            <li><a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Science%20fiction">Science Fiction</a></li>                                                        
                            <li><a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Biography">Biography</a></li>
                            <li><a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Thriller">Thriller</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Newsletter</h2>
                        <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                        <div class="newsletter-form">
                            <input type="email" placeholder="Type your email">
                            <input type="submit" value="Subscribe">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2016 BookersHeaven. All Rights Reserved. Md.Ashif Al Nowajesh & Abu Sayed></p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Latest jQuery form server -->
    <script src="https://code.jquery.com/jquery.min.js"></script>
    
    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    <!-- jQuery sticky menu -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    
    <!-- jQuery easing -->
    <script src="js/jquery.easing.1.3.min.js"></script>
    
    <!-- Main Script -->
    <script src="js/main.js"></script>
  </body>
</html>