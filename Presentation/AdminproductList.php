<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/Admin.php';
    $admin = new Admin();
    
    if(!$admin->AdminIsLoggedIn()){
        $_SESSION['previous_page'] = 'AdminproductList.php';
        header('Location: AdminLogIn.php');
    }

?>




<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookers Heaven ProductList</title>
    
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
                        <li  class="active"><a href="AdminproductList.php">Admin Home</a></li>
                        <li><a href="Home.php">Client Home</a></li>
                        <li><a href="OrderList.php">Order List</a></li>
                        <li><a href="AddProduct.php">Add Product</a></li>
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
                        <h2>Product List</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    		
    <?php
        $simplexml = $admin->GetProductList();
        $xml = simplexml_load_string($simplexml);
    ?>
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                
                <p style="padding: 25px;">
                <!-- Here I've to put the code -->
                <table cellspacing="0" class="shop_table cart">
                    <thead>
                        <tr>
                            <th class="product-id">ID</th>
                            <th class="product-name">Product</th>
                            <th class="author-name">Author</th>
                            <th class="publisher-name">Publisher</th>
                            <th class="isbn-no">ISBN NO</th>
                            <th class="product-price">Price</th>
                            <th class="product-update">Update Product</th>
                            <th class="image-update">Update Image</th>
                            <th class="product-delete">Delete Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($xml->children() as $product) { 
                        ?>
                        
                        <tr class="cart_item"> 
                            <td class="product-id">
                                <?php echo $product->product_id;?>
                            </td>
                            
                            <td class="product-name">
                                <?php echo $product->product_name;?>
                            </td>
                            
                            <td class="author-name">
                                <?php echo $product->author_name;?>
                            </td>
                            
                            <td class="publisher-name">
                                <?php echo $product->publisher_name;?>
                            </td>
                            <td class="isbn-no">
                                <?php echo $product->isbn_no;?> 
                            </td>

                            <td class="product-price">
                                <span class="amount">$<?php echo $product->product_price;?></span> 
                            </td>

                            <td class="product-update">
                                <?php         
                                    $product_id = $product->product_id;
                                    $update_src = "http://localhost:8080/BookersHeaven/Presentation/UpdateProduct.php?id=$product_id";
                                ?>
                                <form method="post" action=<?php echo $update_src;?>>
                                    <input type="submit" value="Update" name="product_update">
                                </form>
                            </td>

                            <td class="image-update">
                                <?php         
                                    $image_src = "http://localhost:8080/BookersHeaven/Presentation/ChangeProductImage.php?id=$product_id";
                                ?>
                                <form method="post" action = <?php echo $image_src; ?>>
                                    <input type="submit" value="Image" name="image_update">
                                </form>
                            </td>
                            
                            <td class="product-delete">
                                <?php         
                                    $src = "http://localhost:8080/BookersHeaven/Presentation/DeleteProduct.php?id=$product_id";
                                ?>
                                <form method="post" action = <?php echo $src; ?>>
                                    <input type="submit" value="Delete" name="delete_product">
                                </form>
                            </td>
                        </tr>    
                        <?php
                            }
                        ?>
                        
                    </tbody>
                </table>
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
                        <h2 class="footer-wid-title">Admin Navigation </h2>
                        <ul>
                            <li><a href="AdminproductList.php">Admin Home</a></li>
                            <li><a href="AddProduct.php">Add Product</a></li>
                            <li><a href="OrderList.php">Order List</a></li>
                            <li><a href="Contact.php">Contact</a></li>
                            <li><a href="Home.php">Client Home</a></li>
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