<?php
    session_start();
/**
 * ©copyright 2016 Ashif & Sayed
 */    
    
    require_once '../BussinessLogic/User.php';
    require_once '../BussinessLogic/Product.php';    
    $user = new User();
    $product = new Product();
    $is_rated = TRUE;
    
    if(isset($_GET['id'])){
        $product_id = $_GET['id'];
        $current_id = $product_id;
        $xml = '<product>';
        $xml = $xml.'<product_id>'.$product_id.'</product_id>';
        $xml = $xml.'</product>';
        
        
        $_SESSION['previous_page'] = 'http://localhost:8080/BookersHeaven/Presentation/SingleProduct.php?id='.$product_id;
        $feed_list = simplexml_load_string($product->GetFeedback($xml));
        $product_rating = simplexml_load_string($product->GetRatingDetails($xml));
        $product_detail = simplexml_load_string($product->GetProductDetails($xml));
        $img_src = "http://localhost:8080/BookersHeaven/Presentation/GetProductImage.php?id=$product_id";
              
    } else {
        header('Location: Home.php');
    }
    
    
    $product_list = simplexml_load_string($product->LatestNineProducts());
    
    if($user->IsLoggedIn()){        
        $logInStatus = 1;
        $user_email = $_SESSION['email'];
        $xml = '<user><user_email>'.$user_email.'</user_email></user>';
        $user_id = simplexml_load_string($user->GetUserId($xml));
        $user_id = $user_id->id;
        $simplexml = '<user><user_id>'.$user_id.'</user_id></user>';
        $xml = simplexml_load_string($user->GetCartTotal($simplexml));
        $total = $xml->total;
        $items = $xml->items;  
        
        $xml = '<product>';
        $xml = $xml.'<product_id>'.$current_id.'</product_id>';
        $xml = $xml.'<user_email>'.$user_email.'</user_email>';
        $xml = $xml.'</product>';
        
        $is_rated = $user->IsRated($xml);        
    }else {
        $logInStatus = 0;
    }
    
?>    



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookers Heaven Single-Product</title>
    
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

    <!-- Rating CSS -->
    <link rel="stylesheet" href="css/Rating.css">
    <link rel="stylesheet" href="css/star.rating.css">
    
    <!-- Jequery Script -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="etch-a-sketch.js"></script>
    
    <!-- Rating Script -->    
    <script src="js/rating.js"></script>
    
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
                        <li><a href="Home.php">Home</a></li>
                        <li><a href="SearchPage.php">Search Page</a></li>
                        <li><a href="Cart.php">Cart</a></li>
                        <li><a href="Checkout.php">Checkout</a></li>
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
                        <h2>Shop</h2>
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
        <input type="text" placeholder="Search products..." style="width: 550px;" name="q" id="search">
        <input type="submit" value="Search">      
        <div id="here"style="width: 550px; border: 1px solid gray; display: none;"></div>                        
	</form>

    
    
    <div class="single-product-area">        
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="">Home</a>
                            <a href=""><?php echo $product_detail->category;?></a>
                            <a href=""><?php echo $product_detail->product_name; ?></a>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="<?php echo $img_src; ?>" alt="">
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name"><?php echo $product_detail->product_name.' - '.$product_detail->author_name; ?></h2>
                                    <h5><?php echo 'Publisher : '.$product_detail->publisher_name; ?></h5>
                                    <h5><?php echo 'ISBN : '.$product_detail->isbn_no; ?></h5>
                                    <div class="product-inner-price">
                                        <ins><?php echo '$'.$product_detail->product_price; ?></ins>
                                        <del><?php echo '$'.$product_detail->general_price; ?></del>
                                    </div>    
                                    
                                    <div class="product-option-shop">
                                    <form class="form-item" method="get" action="AddToCartButton.php">
                                        <input name="product_id" type="hidden" value="<?php echo $product_id;?>">
                                        <button class="add_to_cart_button" type="submit">Add to Cart</button>                                
                                    </form>

                                     </div>   
                                    
                          
                                    
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>                                           
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Product Description</h2>  
                                                <p><?php echo $product_detail->product_detail; ?></p>
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
    </div>
	
    
  <?php if($product_rating->total_rating>0){ 
            $floor_average = floor($product_rating->avarage);
            $i = 0;
      
      ?>
    <div class="rating_container" style="width: 800px">
        <div class="inner">
          <div class="rating">
            <span class="rating-num"><?php echo $product_rating->avarage; ?></span>
            <div class="rating-stars">
              <?php for(;$i<$floor_average; $i++) { ?>
              <span><i class="active icon-star"></i></span>
              <?php } ?>
              <?php for(;$i<5; $i++) { ?>
              <span><i class="icon-star"></i></span>
              <?php } ?>
              
            </div>
            <div class="rating-users">
              <i class="icon-user"></i><?php echo $product_rating->total_rating; ?> total
            </div>
          </div>

          <div class="histo">
            <div class="five histo-rate">
              <span class="histo-star">
                <i class="active icon-star"></i> 5           </span>
              <span class="bar-block">
                <span id="bar-five" class="bar">
                  <span><?php echo $product_rating->star_5; ?></span>&nbsp;
                </span> 
              </span>
            </div>

            <div class="four histo-rate">
              <span class="histo-star">
                <i class="active icon-star"></i> 4           </span>
              <span class="bar-block">
                <span id="bar-four" class="bar">
                  <span><?php echo $product_rating->star_4; ?></span>&nbsp;
                </span> 
              </span>
            </div> 

            <div class="three histo-rate">
              <span class="histo-star">
                <i class="active icon-star"></i> 3           </span>
              <span class="bar-block">
                <span id="bar-three" class="bar">
                  <span><?php echo $product_rating->star_3; ?></span>&nbsp;
                </span> 
              </span>
            </div>

            <div class="two histo-rate">
              <span class="histo-star">
                <i class="active icon-star"></i> 2           </span>
              <span class="bar-block">
                <span id="bar-two" class="bar">
                  <span><?php echo $product_rating->star_2; ?></span>&nbsp;
                </span> 
              </span>
            </div>

            <div class="one histo-rate">
              <span class="histo-star">
                <i class="active icon-star"></i> 1           </span>
              <span class="bar-block">
                <span id="bar-one" class="bar">
                  <span><?php echo $product_rating->star_1; ?></span>&nbsp;
                </span> 
              </span>
            </div>
          </div>
        </div>
    </div>
  <?php } ?>
    
    
	<div class="single-product-area">
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
                
                <p style="padding: 15px;">                
                
                <?php if($logInStatus && $is_rated == FALSE){ ?>
                    <h1 style="margin-left: 40px;">Rate it</h1>
                    <form method="POST"  action="Feedback.php" style="margin-left: 40px; width: 400px;">                       
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input required type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        </fieldset>
                        <input name="product_id" type="hidden" value="<?php echo $current_id;?>">
                        <input name="user_email" type="hidden" value="<?php echo $user_email;?>">
                        <p style="padding: 3px;">                       
                        <textarea rows="5" placeholder="feedback" name="feedback" maxlength="2500" required style="width: 450px;"></textarea>                                        
                        <p style="padding: 5px;">
                        <input type="submit" value="Submit Feedback" name="submit">        
                    </form>

                    <p style="padding: 15px;">
                <?php } ?>
                    
                        
                        
                <p style="padding: 15px;">
                <div class="col-lg-5">
                    <h1 style="margin-left: 40px;">Feedback</h1>
                    <?php
                        $j=0;
                        foreach($feed_list->children() as $feed) {
                            $j++;
                    ?> 
                     
                    <div class="media" style="margin-left: 20px; margin-right: 150px; margin-top: 50px; width: 1000px;">
                        <a class="pull-left" href="#">
                            <?php         
                                $user_id = $feed->user_id;
                                $src = 'http://localhost:8080/BookersHeaven/Presentation/GetUserImage.php?id='.$user_id;
                            ?>
                            <img class="media-object dp img-circle" src="<?php echo $src; ?>" style="width: 95px;height:95px;">                
                        </a>
                        <div class="media-body">
                            <h3 class="media-heading"><?php echo $feed->user_name; ?></h3>
                            <div class="rating-stars">
                                
                                <?php $i=0;
                                    $rating = $feed->rating;
                                for(;$i<$rating; $i++) { ?>
                                <span><i class="active icon-star"></i></span>
                                <?php } ?>
                                <?php for(;$i<5; $i++) { ?>
                                <span><i class="icon-star"></i></span>
                                <?php } ?>                                
                            </div>
                            <p><?php echo $feed->feedback; ?></p>
                        </div>
                    </div>
                    
                        <?php } 
                        
                            if($j==0){
                        ?>
                            <h3 style="margin-left: 80px;">Not yet Rated</h3>
                        <?php } ?>
                    
                    <p style="padding: 15px;">
                    
                    
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
                        <p>&&copy; 2016 BookersHeaven. All Rights Reserved. Md.Ashif Al Nowajesh & Abu Sayed</p>
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