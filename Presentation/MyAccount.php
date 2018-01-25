<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/User.php';
    
    $user = new User();
    $user_email = $_SESSION['email'];    
    
    if(!$user->IsLoggedIn()){
        $_SESSION['previous_page'] = 'MyAccount.php';
        header('Location: LogIn.php');
    }else{
        $logInStatus = 1;
        $user_email = $_SESSION['email'];
        $xml = '<user><user_email>'.$user_email.'</user_email></user>';
        $user_id = simplexml_load_string($user->GetUserId($xml));
        $user_id = $user_id->id;
        $simplexml = '<user><user_id>'.$user_id.'</user_id></user>';
        $xml = simplexml_load_string($user->GetCartTotal($simplexml));
        $total = $xml->total;
        $items = $xml->items;
    }
    
    $xml = '<user>';
    $xml = $xml.'<user_email>'.$user_email.'</user_email>';
    $xml = $xml.'</user>'; 
    
    $xml_user_name = $user->GetUserName($xml);
    $xmlname = simplexml_load_string($xml_user_name);
    $user_name = $xmlname->name;
    
    $simplexml = $user->GetUserId($xml);
    $xmlid = simplexml_load_string($simplexml);
    $user_id = $xmlid->id;       
    
    $upload_success = 1;          
    
    if(isset($_POST["submit"]) && !isset($_FILES['upfile']['error'])){ 
        $upload_success = 1;
        $imageFileType = pathinfo($_FILES["user_image"]["name"],PATHINFO_EXTENSION);
        
        $image = $_FILES["user_image"]["tmp_name"];
        
        $imge_size = getimagesize($image);
        $mime_type = mime_content_type($image);
        $image_file = addslashes(file_get_contents($_FILES["user_image"]["tmp_name"]));
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
            $upload_success = 0;
        }
        
        if($mime_type!="image/jpeg" && $mime_type!="image/jpg" && $mime_type!="image/png"){
            $upload_success = 0;
        }
        
        if($imge_size==FALSE){
            $upload_success = 0;
        }
        if ($_FILES["user_image"]["size"] > 16000000) {            
            $upload_success = -1;
        }
        
        if($upload_success==1){            
            $user->UpdateUserImage($image_file, $user_email,$mime_type);            
        }
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
                <div class="col-sm-6">
                    <div class="shopping-item">
                        <?php if($logInStatus==0){?>
                        <a href="LogIn.php" class="cart-box" id="cart-info">Cart - <span class="cart-amunt">Empty</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">0</span></a>
                        <?php } else { ?>
                        <a href="Cart.php" class="cart-box" id="cart-info">Cart - <span class="cart-amunt">$<?php echo $total;?></span> <i class="fa fa-shopping-cart"></i> <span class="product-count"><?php echo $items;?></span></a>
                        <?php } ?>
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
                        <li><a href="OrderHistory.php.">History</a></li>
                        <li><a href="Contact.php">Contact</a></li>
                        <?php if($logInStatus){
                            ?>
                        <li class="active"><a href="MyAccount.php">My Account</a></li> 
                        <li><a href="LogOut.php">Log Out</a></li>
                        <?php }else{
                            ?>
                        <li><a href="SignUp.php">Sign Up</a></li>
                        <li><a href="LogIn.php">Log In</a></li>                             
                        <?php } ?>
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
                        <h2>My Account</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    		
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                
                <!-- Here I've to put the code -->
                <div class="col-lg-5">
                    <div class="media" style="margin-left: 50px; margin-top: 50px; width: 1000px;">
                        <a class="pull-left" href="#">
                            <?php         
                                $src = "http://localhost:8080/BookersHeaven/Presentation/GetUserImage.php?id=$user_id";
                            ?>
                            <img class="media-object dp img-circle" src="<?php echo $src; ?>" style="width: 250px;height:250px;">                
                        </a>
                        <div class="media-body">
                            <h3 class="media-heading"><?php echo $user_name; ?></h3>
                            <h5><?php echo $user_email; ?></h5>
                            <hr style="margin:8px auto">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="file-upload" class="custom-file-upload">
                            <i class="fa fa-cloud-upload"></i> Choose Image
                        </label>
                        <input id="file-upload" type="file" name="user_image" required>
                        <input type="submit" value="Upload Image" name="submit">        
                    </form> 
                    <?php
                        if($upload_success == 0){
                            echo '<script language="javascript">';
                            echo 'alert("You can upload only jpg, jpeg, png image!")';
                            echo '</script>';
                       } else if($upload_success == -1){
                           echo '<script language="javascript">';
                           echo 'alert("You can upload image upto 16MB")';
                           echo '</script>';
                       }                     
                       ?>
                        </div>
                    </div>

                </div>

                <!-- Here I've to put the code -->
                
            </div>
            <p style="padding: 150px;">
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
                        <p>&copy; 2016 BookersHeaven. All Rights Reserved. Md.Ashif Al Nowajesh & Abu Sayed</p>
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