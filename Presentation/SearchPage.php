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
        $logInStatus = 0;
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
    
    if(isset($_GET['page'])){
        $page_no = $_GET['page'];
    }  else {
        $page_no = 1;
    }
    
    if(isset($_GET['q'])){
        $q = "q=".$_GET['q'];
        $query = $_GET['q'];
        $simplexml = '<product>';
        $simplexml = $simplexml.'<page>'.$page_no.'</page>';
        $simplexml = $simplexml.'<key>'.$_GET['q'].'</key>';
        $simplexml = $simplexml.'</product>';
        
        $product_list = simplexml_load_string($product->SearchProduct($simplexml));
    }  else {
        $q = "";
        $query = "";
        $simplexml = '<product>';
        $simplexml = $simplexml.'<page>'.$page_no.'</page>';
        $simplexml = $simplexml.'</product>';
        
        $product_list = simplexml_load_string($product->CommonSearch($simplexml));
    }
    
    $highest_page = $product_list->count;
    $high = $product_list->high;

    if($page_no!=1){
        $_SESSION['previous_page'] = "http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?page=".$page_no.$q;
    } else {
        $_SESSION['previous_page'] = "http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?".$q;
    }
    
?>



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookersHeaven-Search Page</title>
    
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
                        <li  class="active"><a href="SearchPage.php">Search Page</a></li>
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
    
	
	
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Search Page</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
        <input type="text" placeholder="Search products..." style="width: 550px;" name="q" id="search" value="<?php echo $query; ?>">
        <input type="submit" value="Search">      
        <div id="here"style="width: 550px; border: 1px solid gray; display: none;"></div>                        
	</form> 
    
    <?php if($high < 1){
          $string = str_replace(" ", "%20", $product_list->mean);
          $src = "http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q=$string";
      ?>
        <p style="padding: 1px;">
        <a style="margin-left: 450px; margin-top: 25px; width: 700px;" href="<?php echo $src; ?>">Did You mean <?php echo $product_list->mean; ?>? </a>
    <?php } ?> 
    
            
	<p style="padding: 10px;">
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <?php
                    $temp_break = -1;
                    foreach($product_list->children() as $product){
                        $temp_break++;
                    }
                    if($high< 1){
                        $temp_break--;
                    }
                    $temp_count = 0;
                    foreach($product_list->children() as $product) { 
                        $temp_count++;
                        if($temp_count==$temp_break){
                            break;
                        }
                        $product_id = $product->product_id;
                        $img_src = "http://localhost:8080/BookersHeaven/Presentation/GetProductImage.php?id=$product_id";                    
                        $src = "http://localhost:8080/BookersHeaven/Presentation/SingleProduct.php?id=$product_id";
                ?>      
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">
                            <img src="<?php echo $img_src; ?>" alt="">
                        </div>
                        <h2><a href="<?php echo $src; ?>"><?php echo $product->product_name; ?></a></h2>
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
                    </div>
                </div>
                <?php
                    if($temp_count>0 && $temp_count%4==0){ ?>
                        </div>
                        <div class="row">
                    <?php }
                    }
                ?>			                
            </div>

			
			
			
			
			
            
            <div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center">
                        <nav>
                          <ul class="pagination">
                            <li>
                              <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <?php                                
                                $count = 0;
                                
                                for($i=-2; $i<3; $i++){
                                    $temp = $page_no + $i;
                                    if($temp>0 && $temp<=$highest_page){
                                        $count++;
                                        $x[$count]=$temp;
                                    }
                                }
                            
                                for($i=1;$i<=$count;$i++){
                            ?>                            
                            <li <?php if($i==$page_no){?>
                            class="active"<?php } ?>><a href="http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?page=<?php echo $x[$i].$q; ?>"><?php echo $x[$i]; ?></a></li>
                            <?php
                                }
                            ?>
                            <li>
                              <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>                        
                    </div>
                </div>
            </div>
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