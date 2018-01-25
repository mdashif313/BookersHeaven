<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/Admin.php';
    $admin = new Admin();
    
    if(!$admin->AdminIsLoggedIn()){
        $_SESSION['previous_page'] = 'AddProduct.php';
        header('Location: AdminLogIn.php');
    }        
    
    $upload_success = 2;
    
    if(isset($_POST["submit"]) && isset($_POST["product_name"]) && isset($_POST["category"])
        && isset($_POST["author_name"]) && isset($_POST["publisher_name"]) && isset($_POST["isbn_no"])
        && isset($_POST["product_price"]) && isset($_POST["general_price"]) && isset($_POST["product_detail"])
        && !isset($_FILES['upfile']['error'])){
        
        $upload_success = 1;
        $imageFileType = pathinfo($_FILES["product_image"]["name"],PATHINFO_EXTENSION);
        
        $image = $_FILES["product_image"]["tmp_name"];
        
        $imge_size = getimagesize($image);
        $mime_type = mime_content_type($image);
        $image_file = addslashes(file_get_contents($_FILES["product_image"]["tmp_name"]));
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
            $upload_success = 0;
        }
        
        if($mime_type!="image/jpeg" && $mime_type!="image/jpg" && $mime_type!="image/png"){
            $upload_success = 0;
        }
        
        if($imge_size==FALSE){
            $upload_success = 0;
        }
        if ($_FILES["product_image"]["size"] > 16000000) {            
            $upload_success = -1;
        }
        
        if($upload_success==1){  
            
            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $author_name = $_POST['author_name'];
            $publisher_name = $_POST['publisher_name'];
            $isbn_no = $_POST['isbn_no'];
            $product_price = $_POST['product_price'];
            $general_price = $_POST['general_price'];
            $product_detail = addslashes($_POST['product_detail']);
            
            $xml = '<product>';
            $xml = $xml.'<product_name>'.$product_name.'</product_name>';
            $xml = $xml.'<category>'.$category.'</category>';
            $xml = $xml.'<author_name>'.$author_name.'</author_name>';
            $xml = $xml.'<publisher_name>'.$publisher_name.'</publisher_name>';
            $xml = $xml.'<isbn_no>'.$isbn_no.'</isbn_no>';
            $xml = $xml.'<product_price>'.$product_price.'</product_price>';
            $xml = $xml.'<general_price>'.$general_price.'</general_price>';
            $xml = $xml.'<product_detail>'.$product_detail.'</product_detail>';
            $xml = $xml.'<img_type>'.$mime_type.'</img_type>';
            $xml = $xml.'</product>'; 
            
            $admin->AddProduct($xml,$image_file);

            header('Location: AdminproductList.php');
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
    <link rel="stylesheet" href="admin-css/owl.carousel.css">
    <link rel="stylesheet" href="admin-css/style.css">
    <link rel="stylesheet" href="admin-css/responsive.css">
    
    <!-- Upload Button -->
    <link rel="stylesheet" href="admin-css/file.upload.button.css">

  </head>
  <body>
   
    
    
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="AdminproductList.php">Bookers<span>Admin</span></a></h1>
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
                        <li><a href="AdminproductList.php">Admin Home</a></li>
                        <li><a href="Home.php">Client Home</a></li>
                        <li><a href="OrderList.php">Order List</a></li>
                        <li class="active"><a href="AddProduct.php">Add Product</a></li>
                        <li><a href="AdminChangePassword.php">Admin Change Password</a></li> 
                        <li><a href="AdminLogOut.php">Admin LogOut</a></li>
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
                        <h2>Add Product</h2>
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
                    <p><b>Product Name</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="product name" name="product_name" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Category</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="category" name="category" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">    
                        
                    <p><b>Author Name</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="author name" name="author_name" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Publisher Name</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="publisher name" name="publisher_name" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>ISBN NO</b><span style="color: #FF0000;">*</span></p>
                    <input type="text" placeholder="isbn no" name="isbn_no" maxlength="100" required style="width: 450px;"/>
                    <p style="padding: 5px;"> 
                        
                    <p><b>Our Product Price</b><span style="color: #FF0000;">*</span></p>
                    <input type="number" placeholder="product price" name="product_price" maxlength="10" required style="width: 450px;"/>
                    <p style="padding: 5px;"> 
                        
                    <p><b>General Price</b></p>
                    <input type="number" placeholder="general price" name="general_price" maxlength="10" style="width: 450px;"/>
                    <p style="padding: 5px;">
                        
                    <p><b>Product Detail</b><span style="color: #FF0000;">*</span></p>
                    <textarea rows="5" placeholder="product detail" name="product_detail" maxlength="2500" required style="width: 450px;"></textarea>                                        
                    <p style="padding: 5px;">
                        
                    <p style="padding: 25px;">
                    <label for="file-upload" class="custom-file-upload">
                        <i class="fa fa-cloud-upload"></i> Choose Image
                    </label>
                    <input id="file-upload" type="file" name="product_image" required>
                    <input type="submit" value="Upload Product" name="submit">        
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
                            <li><a href="">My account</a></li>
                            <li><a href="">Order history</a></li>
                            <li><a href="">Wishlist</a></li>
                            <li><a href="">Vendor contact</a></li>
                            <li><a href="">Front page</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Categories</h2>
                        <ul>
                            <li><a href="">Mobile Phone</a></li>
                            <li><a href="">Home accesseries</a></li>
                            <li><a href="">LED TV</a></li>
                            <li><a href="">Computer</a></li>
                            <li><a href="">Gadets</a></li>
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
                        <p>&copy; 2015 eElectronics. All Rights Reserved. Coded with <i class="fa fa-heart"></i> by <a href="http://wpexpand.com" target="_blank">WP Expand</a></p>
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