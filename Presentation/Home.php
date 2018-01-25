<?php
    session_start();
/**
 * ©copyright 2016 Ashif & Sayed
 */    
    
    require_once '../BussinessLogic/User.php';
    require_once '../BussinessLogic/Product.php';    
    $user = new User();
    $product = new Product();
    $product_list = simplexml_load_string($product->LatestNineProducts());
    
    if($user->IsLoggedIn()){
        $_SESSION['previous_page'] = "Home.php";
        $logInStatus = 1;
        $user_email = $_SESSION['email'];
        $xml = '<user><user_email>'.$user_email.'</user_email></user>';
        $user_id = simplexml_load_string($user->GetUserId($xml));
        $user_id = $user_id->id;
        $simplexml = '<user><user_id>'.$user_id.'</user_id></user>';
        $xml = simplexml_load_string($user->GetCartTotal($simplexml));
        $total = $xml->total;
        $items = $xml->items;         
    }else {
        $logInStatus = 0;
    }
        
?>



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookersHeaven-Home</title>
    
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    
	<link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

  </head>
  <body>
   
    
    
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="index.html">Bookers<span>Heaven</span></a></h1>
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
                        <li  class="active"><a href="Home.php">Home</a></li>
                        <li><a href="SearchPage.php">Search Page</a></li>
                        <li><a href="Cart.php">Cart</a></li>
                        <li><a href="OrderHistory.php.">History</a></li>
                        <li><a href="Contact.php">Contact</a></li>
                        <?php if($logInStatus){
                            ?>
                        <li><a href="MyAccount.php">My Account</a></li> 
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
    
    <div class="slider-area">
        <div class="zigzag-bottom"></div>
        <div id="slide-list" class="carousel carousel-fade slide" data-ride="carousel">
            
            <div class="slide-bulletz">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="carousel-indicators slide-indicators">
                                <li data-target="#slide-list" data-slide-to="0" class="active"></li>
                                <li data-target="#slide-list" data-slide-to="1"></li>
                                <li data-target="#slide-list" data-slide-to="2"></li>
                            </ol>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="single-slide">
                        <div class="slide-bg slide-one"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>We are awesome</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, dolorem, excepturi. Dolore aliquam quibusdam ut quae iure vero exercitationem ratione!</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi ab molestiae minus reiciendis! Pariatur ab rerum, sapiente ex nostrum laudantium.</p>
                                                <a href="" class="readmore">Learn more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-two"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>We are great</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe aspernatur, dolorum harum molestias tempora deserunt voluptas possimus quos eveniet, vitae voluptatem accusantium atque deleniti inventore. Enim quam placeat expedita! Quibusdam!</p>
                                                <a href="" class="readmore">Learn more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-three"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>We are superb</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores, eius?</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptates necessitatibus dicta recusandae quae amet nobis sapiente explicabo voluptatibus rerum nihil quas saepe, tempore error odio quam obcaecati suscipit sequi.</p>
                                                <a href="" class="readmore">Learn more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>        
    </div> <!-- End slider area -->
    
    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-refresh"></i>
                        <p>30 Days return</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-truck"></i>
                        <p>Free shipping</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-lock"></i>
                        <p>Secure payments</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-gift"></i>
                        <p>New products</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->
    
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script>
        $(document).ready(function(e){
            $("#search").keyup(function(){
                $("#here").show();
                var x = $(this).val();
                $.ajax({
                    type:'GET',
                    url:'LiveSearch.php',
                    data:'q='+x,
                    success:function(data){
                        $("#here").html(data);
                    },
                });
            });
        });
        
    </script>
    
    
	<form action="SearchPage.php" method="get" style="margin-left: 400px; margin-top: 25px; width: 700px;">
        <input type="text" placeholder="Search products..." style="width: 550px;" name="q" id="search">
        <input type="submit" value="Search">      
        <div id="here"style="width: 550px; border: 1px solid gray; display: none;"></div>                        
	</form>
	<p style="padding: 25px;">
		
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product">
                        <h2 class="section-title">Latest Products</h2>
                        <div class="product-carousel">
                            							
							<?php                                 
                                
                                foreach($product_list->children() as $product) { 
                                    $product_id = $product->product_id;
                                    $img_src = "http://localhost:8080/BookersHeaven/Presentation/GetProductImage.php?id=$product_id";                    
                                    $src = "http://localhost:8080/BookersHeaven/Presentation/SingleProduct.php?id=$product_id";
                                    $cart_src = "http://localhost:8080/BookersHeaven/Presentation/AddToCartButton.php?product_id=$product_id";
                            ?>
                            
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <img src="<?php echo $img_src; ?>" alt="">
                                        <div class="product-hover">
                                            <a href="<?php echo $cart_src; ?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                            <a href="<?php echo $src; ?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                        </div>
                                    </div>

                                    <h2><a href="<?php echo $src; ?>"><?php echo $product->product_name.' - '.$product->author_name; ?></a></h2>

                                    <div class="product-carousel-price">
                                        <ins><?php echo '$'.$product->product_price; ?></ins>
                                        <del><?php echo '$'.$product->general_price; ?></del>
                                    </div>                            
                                </div>
                            <?php } ?>                                                       
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
    
    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <h2 class="section-title">Category</h2>
                        <div class="brand-list">
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Kids">
                                <img src="img/services_logo__1.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Horror">
                                <img src="img/services_logo__2.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Science%20fiction">
                                <img src="img/services_logo__5.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Biography">
                                <img src="img/services_logo__4.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Thriller">
                                <img src="img/services_logo__3.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Kids">
                                <img src="img/services_logo__1.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Horror">
                                <img src="img/services_logo__2.jpg" alt="">
                            </a>
                            <a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=Science%20fiction">
                                <img src="img/services_logo__5.jpg" alt="">
                            </a>
                                                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End brands area -->
    
    <div class="product-widget-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Top Sellers</h2>
                        <a href="" class="wid-view-more">View All</a>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-1.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Alexendria link</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$40.00</ins> <del>$45.00</del>
                            </div>                            
                        </div>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-2.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Da Vinci Code</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$40.00</ins> <del>$45.00</del>
                            </div>                            
                        </div>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-3.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Inferno</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$20.00</ins> <del>$25.00</del>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Recently Viewed</h2>
                        <a href="#" class="wid-view-more">View All</a>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-3.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Inferno</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$20.00</ins> <del>$25.00</del>
                            </div>                            
                        </div>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-1.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Alexendria link</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$40.00</ins> <del>$42.00</del>
                            </div>                            
                        </div>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-2.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Da Vinci Code</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$40.00</ins> <del>$42.00</del>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Top New</h2>
                        <a href="#" class="wid-view-more">View All</a>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-3.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Inferno</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$40.00</ins> <del>$45.00</del>
                            </div>                            
                        </div>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-3.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Inferno</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$40.00</ins> <del>$45.00</del>
                            </div>                            
                        </div>
                        <div class="single-wid-product">
                            <a href=""><img src="img/product-thumb-1.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="">Alexendria link</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$20.00</ins> <del>$25.00</del>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End product widget area -->
    
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
                            <form action="#">
                                <input type="email" placeholder="Type your email">
                                <input type="submit" value="Subscribe">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->
    
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
    </div> <!-- End footer bottom area -->
   
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