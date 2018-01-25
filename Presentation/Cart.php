<?php
    session_start();

 /**
 * ©copyright 2016 Ashif & Sayed
 */

    require_once '../BussinessLogic/User.php';
    require_once '../BussinessLogic/Product.php';    
    $user = new User();
    $product = new Product();
    
    if(!$user->IsLoggedIn()){
        $_SESSION['previous_page'] = "Cart.php";
        header('Location: LogIn.php');
    }  else {
        $user_email = $_SESSION['email'];
        $simplexml = '<user><user_email>'.$user_email.'</user_email></user>';
        $xml = simplexml_load_string($user->GetCartDetails($simplexml));
        $cart_total = simplexml_load_string($user->GetTotal($simplexml));
        $product_list = simplexml_load_string($product->LatestTwoProducts());
        $_SESSION['previous_page'] = "Cart.php";  
    }

?>




<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookers Heaven Cart</title>
    
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
                        <li  class="active"><a href="Cart.php">Cart</a></li>
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
                        <h2>Cart</h2>
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
                <table cellspacing="0" class="shop_table cart">
                    <thead>
                        <tr>
                            <th class="product-thumbnail"></th>                            
                            <th class="product-name">Product</th>
                            <th class="author-name">Author</th>
                            <th class="publisher-name">Publisher</th>
                            <!--th class="isbn-no">ISBN NO</th-->
                            <th class="product-price">Price</th>
                            <th class="number">quantity</th>
                            <th class="product-remove">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($xml->children() as $product) { 
                        ?>                                                                        
                        <tr class="cart_item">   
                            
                            <td class="product-thumbnail">
                                <?php
                                    $product_id = $product->product_id;
                                    $img_src = "http://localhost:8080/BookersHeaven/Presentation/GetProductImage.php?id=$product_id"; 
                                ?>
                                <img width="145" alt="poster_1_up" class="shop_thumbnail" src="<?php echo $img_src; ?>">
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
                            
                            <td class="product-price">
                                <span class="amount">$<?php echo $product->product_price;?></span> 
                            </td>

                            <td class="number">                                                                                                                               
                                <form class="form-item" method="get" action="AddToCartButton.php">
                                    <input name="product_id" type="hidden" value="<?php echo $product_id;?>">
                                    <button class="add_to_cart_button" type="submit">+</button>                                
                                </form>
                                
                                 <?php echo $product->quantity;?>
                                
                                <form class="form-item" method="get" action="LessToCartButton.php">
                                    <input name="product_id" type="hidden" value="<?php echo $product_id;?>">
                                    <button class="add_to_cart_button" type="submit"> - </button>                                
                                </form>
                            </td>
                            
                            
                            <td class="product-remove">
                                <?php         
                                    $src = "http://localhost:8080/BookersHeaven/Presentation/RemoveProductFromCart.php?id=$product_id";
                                ?>
                                <form method="post" action = <?php echo $src; ?>>
                                    <input type="submit" value="Remove" name="Remove">
                                </form>
                            </td>
                        </tr>    
                        <?php
                            }
                        ?>
                        
                    </tbody>
                </table>
                <!-- Here I've to put the code -->
                
                
                <div class="cart-collaterals">


                    <div class="cross-sells">
                        <h2>You may be interested in...</h2>
                        <ul class="products">
                            <?php                                 
                                
                                foreach($product_list->children() as $product) { 
                                    $product_id = $product->product_id;
                                    $img_src = "http://localhost:8080/BookersHeaven/Presentation/GetProductImage.php?id=$product_id";                    
                                    $src = "http://localhost:8080/BookersHeaven/Presentation/SingleProduct.php?id=$product_id";
                            ?>                            
                            <li class="product">                                
                                <img width="325"  alt="T_4_front" class="attachment-shop_catalog wp-post-image" src="<?php echo $img_src; ?>">
                                <h3><a href="<?php echo $src; ?>"><?php echo $product->product_name; ?></a></h3>                                                        
                                <div class="product-carousel-price">
                                    <ins><?php echo '$'.$product->product_price; ?></ins> 
                                    <del><?php echo '$'.$product->general_price; ?></del>
                                </div> 
                                <div class="product-option-shop">
                                <form class="form-item" method="get" action="AddToCartButton.php">
                                    <input name="product_id" type="hidden" value="<?php echo $product_id;?>">
                                    <button class="add_to_cart_button" type="submit">Add to Cart</button>                                
                                </form>
                            
                        </div> 
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </div>


                    <div class="cart_totals ">
                        <h2>Cart Totals</h2>

                        <table cellspacing="0">
                            <tbody>                              
                                <tr class="cart-subtotal">
                                    <th>Cart Subtotal</th>
                                    <td><span class="amount">$<?php echo $cart_total->total;?></span></td>
                                </tr>

                                <tr class="shipping">
                                    <th>Shipping and Handling</th>
                                    <td>Free Shipping</td>
                                </tr>

                                <tr class="order-total">
                                    <th>Order Total</th>
                                    <td><strong><span class="amount">$<?php echo $cart_total->total;?></span></strong> </td>
                                </tr>
                                
                                <tr class="chekout">
                                    <th>Checkout</th>
                                    <td>
                                        <form action="Checkout.php">
                                            <input type="submit" value="Checkout">
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                
                </div>
                
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