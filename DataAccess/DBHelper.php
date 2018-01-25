<?php
/**
 * Main Class to implement
 * Data Access Layer
 *
 * ©copyright 2016 Ashif & Sayed
 */
class DBHelper {
    private $host = "localhost";
    private $db_name = "bookersheaven";
    private $username = "root";
    private $password = "";
    private $conn;
    
    
    function __construct() {
        $this->conn = NULL;
        
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
    
    
    
    /*
     * function to check if the
     * given email is in database
     */
    function DbEmailValidityCheck($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
            
    
    /*
     * Data Access function for securing password
     */
    function PassHash($password,$user_email) {
        $myfile = fopen("salt.txt", "r");
        $salt1 = md5(fgets($myfile).$user_email);
        $salt2 = md5($user_email.fgets($myfile));
        fclose($myfile);
        return hash('sha512',  $salt1.md5($password).$salt2);
    }
    
    
    
    /*
     * Dataaccess layer function 
     * to activate user account 
     */
    function DbActivateUserAccount($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_id = $xml->id;
        
        $sql = "SELECT user_id FROM user WHERE MD5(user_id) = '$user_id'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            
            if($row['user_status']==0){
                $update = "UPDATE user SET user_status = 1 
                        WHERE MD5(user_id) = '$user_id'";
                $this->conn->exec($update);
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }


    /*
     * This function update user
     * password for the given id
     */
    function DbChangePassword($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_id = $xml->id;        
        
        $sql = "SELECT * FROM user WHERE MD5(user_id) = '$user_id'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $token = $this->DbTokenGenerator($row['user_name'], $row['user_email']);
            $password = $this->PassHash($xml->password,$row['user_email']);
            
            $update = "UPDATE user SET password = '$password', token = '$token' 
                        WHERE MD5(user_id) = '$user_id'";
            $this->conn->exec($update);
            
            return TRUE;
        }
        
        return FALSE;
    }

    /*
     * Data Access layer
     * function to retrieve
     * user name for spacific
     * registered email address
     */
    function DbGetUserName($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        
        $sql = "SELECT user_name FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $user_name = $row['user_name'];
            $result = '<user>';
            $result = $result.'<name>'.$user_name.'</name>';
            $result = $result.'</user>';             
            return $result;
        }                
    }



    /*
    * This function return user id
    * for the given email address
    */
    function DbGetUserId($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $user_id = md5($row['user_id']);
            $result = '<user>';
            $result = $result.'<id>'.$user_id.'</id>';
            $result = $result.'</user>';             
            return $result;
        }                
    }

    
    
    /*
    * This function return token
    * for the given user email
    */
   function DbGetToken($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
       
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);

        if($query->rowCount()>0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $token = $row['token'];
            $result = '<user>';
            $result = $result.'<token>'.$token.'</token>';
            $result = $result.'</user>';             
            return $result;
        }
       
   }

    /*
     * function to generate user
     * specific token string
     */
    function DbTokenGenerator($user_name, $user_email){
        $token = base64_encode(hash('ripemd320', rand().'The quick'.microtime().' brown'.$user_name.' fox'.time(). 'jumped over'.$user_email.' the lazy'.rand().' dog.')
                .  md5('rtgrgr'.rand().'gergs43'.microtime().'56NUIr4'.$user_name.'GR 34fhdm*'.time(). ' vrf Ijhefb3438'.$user_email.'c f*F8CB*$('.rand().'hf#()cnefn#(#)')
                .hash('sha512','BFwefbwh^'.rand().'&f sfi'.microtime().'34grgr'.$user_name.'5g'.time(). '5e4ygerg'.$user_email.'B%#&sdf47vfvdjfdvjd'.rand().'f&$R&##VF&VE')
                .hash('whirlpool','feJNf348&'.rand().'RF4f4f&fi'.microtime().'|PR[fe]}'.$user_name.'RUIWRIUverg[]gherywktJGEgw356t)($5j0'.time(). '"GRR$$NFUIEvfndf*(*%90jg'.$user_email.'FN$*tf843)*#&$%FNe'.rand().'JKgwrjfgn|"|ETe]r')
                );
        
        return $token;
    }


    
    function DbTokenMatch($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_id = $xml->id;
        $token = $xml->token;
        
        $sql = "SELECT * FROM user WHERE MD5(user_id) = '$user_id'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            
            if($row['token'] == $token){                                        
                return TRUE;
            } 
        } else {
            return FALSE;
        }        
    }


    /*
     * this is Data Access layer
     * that handle tasks of new 
     * user account creation
     */
    function DbSignUp($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        $user_name = $xml->user_name;
        //$password = $xml->password;
        $password = $this->PassHash(base64_decode($xml->password),$user_email);
        
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()>0){
            $result = '<signin>
                        <status>Invalid</status>
                      </signin>'; 
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }        
        
        $token = $this->DbTokenGenerator($user_name, $user_email);
        $insert = ("INSERT INTO user (user_email, user_name, password, token)
                    VALUES ('$user_email', '$user_name', '$password', '$token')");          
        $this->conn->exec($insert);
        
        $result = '<signin>
                    <status>valid</status>
                  </signin>'; 
        $simplexml = simplexml_load_string($result);
        return $simplexml;
    }



    /*
     * this is dataaccess layer function
     * to check log in email & password
     */    
    function DbLogIn($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        //$password = $xml->password;
        $password = $this->PassHash(base64_decode($xml->password),$user_email);
        
        $sql = "SELECT * FROM user WHERE user_email = '$user_email'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()==0){
            $result = '<status>
                        <password>Invalid</password>
                      </status>'; 
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        } 
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        if($row['user_status']==0){
            $result = '<status>
                        <password>Inactive</password>
                      </status>'; 
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }
        
        if($row['password']==$password){
            $result = '<status>
                        <password>Valid</password>
                      </status>';             
            $simplexml = simplexml_load_string($result);
            return $simplexml;
        }
        $result = '<status>
                <password>Invalid</password>
              </status>'; 
        $simplexml = simplexml_load_string($result);
        return $simplexml;                        
    }
    
    /*
     * DataAccess Layer Function to
     * handle Admin LogIn
     */
    function DbAdminLogIn($samplexml){
        $xml = simplexml_load_string($samplexml);
        $user_name = $xml->user_name;
        $password = $xml->password;
        //$password = $this->PassHash(base64_decode($xml->password),$user_email);
        
        $sql = "SELECT * FROM restricted WHERE user_name = '$user_name'";
        $query = $this->conn->query($sql);
        
        if($query->rowCount()==0){
            return FALSE;
        }
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        if($row['password']==$password){
            return TRUE;
        }        
    }
    
    
    
    /*
     * This function update 
     * Admin password
     */
    function DbAdminChangePassword($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_name = 'DarkKnight';        
        $password = $xml->password;
            
        $update = "UPDATE restricted SET password = '$password'
                    WHERE user_name = '$user_name'";
        $this->conn->exec($update);
        
    }
    
    
    /*
     * Data access layer function to
     * add product to database
     */
    function DbAddProduct($simplexml,$image_file){
        $xml = simplexml_load_string($simplexml);
        
        $product_name = $xml->product_name;
        $category = $xml->category;
        $author_name = $xml->author_name;
        $publisher_name = $xml->publisher_name;
        $isbn_no = $xml->isbn_no;
        $product_price = $xml->product_price;
        $general_price = $xml->general_price;
        $product_detail = $xml->product_detail;
        $img_type = $xml->img_type;

        $insert = ("INSERT INTO product (product_name, category, author_name, publisher_name, isbn_no,
                        product_price, general_price, product_detail, img_type, product_image)
                    VALUES ('$product_name', '$category', '$author_name', '$publisher_name', '$isbn_no',
                 $product_price, $general_price, '$product_detail', '$img_type', '$image_file')");
        
        $this->conn->exec($insert);
        
    }
    
    
    
    /*
     * Data Access layer function
     * to get list of all products
     */
    function DbGetProductList(){
        $query = $this->conn->query("SELECT * FROM product");        
        
        $xml = '<products>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
            $xml = $xml.'<product>';
            $xml = $xml.'<product_id>'.$row['product_id'].'</product_id>';
            $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';            
            $xml = $xml.'<author_name>'.$row['author_name'].'</author_name>';
            $xml = $xml.'<publisher_name>'.$row['publisher_name'].'</publisher_name>';
            $xml = $xml.'<isbn_no>'.$row['isbn_no'].'</isbn_no>';
            $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
            $xml = $xml.'</product>'; 
        }
        $xml = $xml.'</products>';
                
        return $xml;
    }



    /*
     * Data Access function to Delete
     * product from Database
     */
    function DbDeleteProduct($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        
        $sql = "DELETE FROM product WHERE product_id = $product_id";
        $this->conn->exec($sql);       
    }


    /*
     * Data Access function to
     * get product image type
     */
    function DbGetProductImageType($simplexml){
        $samplexml = simplexml_load_string($simplexml);
        $product_id = $samplexml->product_id;
        
        $sql = "SELECT img_type FROM product WHERE product_id = $product_id";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $xml = '<product>';
        $xml = $xml.'<img_type>'.$row['img_type'].'</img_type>';
        $xml = $xml.'</product>'; 
        
        return $xml;
    }

    
    /*
     * DataAccess function to return 
     * product image
     */
    function DbGetProductImage($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        
        $sql = "SELECT product_image FROM product WHERE product_id = $product_id";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $image = $row['product_image'];
        
        return $image;
    }
    
    /*
     * DataAccess layer function to
     * get product information
     */
    function DbGetProductBasicInfo($simplexml){
        $samplexml = simplexml_load_string($simplexml);
        $product_id = $samplexml->product_id;
        
        $sql = "SELECT * FROM product WHERE product_id = $product_id";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $xml = '<product>';
        $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';            
        $xml = $xml.'<author_name>'.$row['author_name'].'</author_name>';
        $xml = $xml.'<isbn_no>'.$row['isbn_no'].'</isbn_no>';
        $xml = $xml.'</product>';
        
        return $xml;
    }

    
    /*
     * dataaccess function to 
     * update product image
     */
    function DbUpdateProductImage($image,$product_id,$img_type){
        $update = "UPDATE product SET product_image = '$image', img_type = '$img_type' 
                        WHERE product_id = $product_id";
        $this->conn->exec($update);
    }

    
    /*
     * Dataaccess layer function 
     * to update product info
     */
    function DbUpdateProductInfo($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        
        $sql = "SELECT * FROM product WHERE product_id = $product_id";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $product_name = $row['product_name'];
        $category = $row['category'];
        $author_name = $row['author_name'];
        $publisher_name = $row['publisher_name'];
        $isbn_no = $row['isbn_no'];
        $product_price = $row['product_price'];
        $general_price = $row['general_price'];
        $product_detail = $row['product_detail'];

        if(strlen(trim($xml->product_name))>0){
            $product_name = $xml->product_name;
        }
        if(strlen(trim($xml->category))>0){
            $category = $xml->category;
        }
        if(strlen(trim($xml->author_name))>0){
            $author_name = $xml->author_name;
        }
        if(strlen(trim($xml->publisher_name))>0){
            $publisher_name = $xml->publisher_name;
        }
        if(strlen(trim($xml->isbn_no))>0){
            $isbn_no = $xml->isbn_no;
        }
        if($xml->product_price>0){
            $product_price = $xml->product_price;
        }
        if($xml->general_price>0){
            $general_price = $xml->general_price;
        }
        if(strlen(trim($xml->product_detail))>0){
            $product_detail = $xml->product_detail;
        }
        
        $update = ("UPDATE product SET  product_name='$product_name', category='$category', author_name='$author_name'
            ,publisher_name='$publisher_name', isbn_no='$isbn_no',product_price=$product_price, general_price=$general_price
                , product_detail='$product_detail' WHERE product_id = $product_id");
        
        $this->conn->exec($update);
    }


    /*
     * DataAccess Layer function
     * to return all product info
     */
    function DbGetAllProductInfo($simplexml){
        $samplexml = simplexml_load_string($simplexml);
        $product_id = $samplexml->product_id;
        
        $sql = "SELECT * FROM product WHERE product_id = $product_id";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $xml = '<product>';
        $xml = $xml.'<product_id>'.$row['product_id'].'</product_id>';
        $xml = $xml.'<category>'.$row['category'].'</category>';
        $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';            
        $xml = $xml.'<author_name>'.$row['author_name'].'</author_name>';
        $xml = $xml.'<publisher_name>'.$row['publisher_name'].'</publisher_name>';
        $xml = $xml.'<isbn_no>'.$row['isbn_no'].'</isbn_no>';
        $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
        $xml = $xml.'<general_price>'.$row['general_price'].'</general_price>';
        $xml = $xml.'<product_detail>'.$row['product_detail'].'</product_detail>';
        $xml = $xml.'<img_type>'.$row['img_type'].'</img_type>';
        $xml = $xml.'</product>';         
        
        
        return $xml;
    }
    
    
    
    /*
     * Data Access Layer function
     * to implement checkout
     */
    function DbCheckout($simplexml){
        $xml = simplexml_load_string($simplexml);
        $shipment_address = $xml->shipment_address;
        $shipment_date = $xml->shipment_date;
        $mobile_no = $xml-> mobile_no;
        $time_slot = $xml->time_slot;
        $user_email = $xml->user_email;
        $total = 0;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];        
        
        $order_list = "";
        $counter = 0;
        $query = $this->conn->query("SELECT product_id,quantity,price FROM temp_order WHERE user_id = $user_id");
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $total += $row['price'];
            
            $product_details = $this->conn->query("SELECT product_name
                     FROM product WHERE product_id = $product_id");
            $product = $product_details->fetch(PDO::FETCH_ASSOC);
            
            $counter++;
            $order_list = $order_list.$counter.') '.$product['product_name'].' '.$quantity.' copy ';
            
        }
        
        $this->conn->exec("INSERT INTO shipment (user_id, order_list,order_cost,shipment_address, shipment_date, mobile_no, time_slot)
                    VALUES ($user_id, '$order_list', $total,'$shipment_address', '$shipment_date', '$mobile_no', '$time_slot')");                               
        
        return TRUE;
    }
    
    
    
    /*
     * Product Delivery function
     */
    function DbProductDelivery($simplexml){
        $xml = simplexml_load_string($simplexml);        
        $shipment_id = $xml->shipment_id;
        
        $this->conn->exec("UPDATE shipment SET shipping_status = 1
                        WHERE shipment_id = $shipment_id");
    }
    
    
    /*
     * Data Access layer function 
     * to get order list
     */
    function DbGetOrderHistory(){
        $query = $this->conn->query("SELECT * FROM shipment");
        
        $xml = '<shipment_list>';
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $xml = $xml.'<shipment>';
            $xml = $xml.'<shipment_id>'.$row['shipment_id'].'</shipment_id>';
            $xml = $xml.'<order_list>'.$row['order_list'].'</order_list>';
            $xml = $xml.'<shipment_date>'.$row['shipment_date'].'</shipment_date>';
            $xml = $xml.'<time_slot>'.$row['time_slot'].'</time_slot>';
            $xml = $xml.'<shipment_address>'.$row['shipment_address'].'</shipment_address>';
            $xml = $xml.'<mobile_no>'.$row['mobile_no'].'</mobile_no>';
            $xml = $xml.'<shipping_status>'.$row['shipping_status'].'</shipping_status>';
            $xml = $xml.'</shipment>';
        }        
        $xml = $xml.'</shipment_list>'; 
        
        return $xml;
    }
    
    
    /*
     * Data Access layer function 
     * to get order list
     */
    function DbGetOrderList($simplexml){
        $xml = simplexml_load_string($simplexml);        
        $user_email = $xml->user_email;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id']; 
        
        $query = $this->conn->query("SELECT * FROM shipment WHERE user_id = $user_id");
        
        $xml = '<shipment_list>';
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $xml = $xml.'<shipment>';
            $xml = $xml.'<shipment_id>'.$row['shipment_id'].'</shipment_id>';
            $xml = $xml.'<order_list>'.$row['order_list'].'</order_list>';
            $xml = $xml.'<shipment_date>'.$row['shipment_date'].'</shipment_date>';
            $xml = $xml.'<time_slot>'.$row['time_slot'].'</time_slot>';
            $xml = $xml.'<shipment_address>'.$row['shipment_address'].'</shipment_address>';
            $xml = $xml.'<mobile_no>'.$row['mobile_no'].'</mobile_no>';
            $xml = $xml.'<shipping_status>'.$row['shipping_status'].'</shipping_status>';
            $xml = $xml.'</shipment>';
        }        
        $xml = $xml.'</shipment_list>'; 
        
        return $xml;
    }
    
    
    
    /*
     * Data Access layer function 
     * to retrieve product details
     */
    function DbGetProductDetails($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        
        $sql = "SELECT * FROM product WHERE product_id = $product_id";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $xml = '<product>';
        $xml = $xml.'<category>'.$row['category'].'</category>';
        $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';            
        $xml = $xml.'<author_name>'.$row['author_name'].'</author_name>';
        $xml = $xml.'<publisher_name>'.$row['publisher_name'].'</publisher_name>';
        $xml = $xml.'<isbn_no>'.$row['isbn_no'].'</isbn_no>';
        $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
        $xml = $xml.'<general_price>'.$row['general_price'].'</general_price>';
        $xml = $xml.'<product_detail>'.$row['product_detail'].'</product_detail>';
        $xml = $xml.'</product>';   
        
        return $xml;
    }





    /*
     * Data Access layer function
     * to find common search
     */
    function DbCommonSearch($simplexml){
        $xml = simplexml_load_string($simplexml);       
        $high = $xml->page*12;
        $low = $high - 11;
        $query = $this->conn->query("SELECT product_name,product_id,product_price,general_price FROM product");        
        
        $j = 0;
        $xml = '<products>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
           $j++;
           
           if($j>=$low && $j<=$high){
                $xml = $xml.'<product>';
                $xml = $xml.'<product_id>'.$row['product_id'].'</product_id>';
                $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';  
                $xml = $xml.'<general_price>'.$row['general_price'].'</general_price>';
                $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
                $xml = $xml.'</product>'; 
            }
           
        }
        $xml = $xml.'<count>'.floor($j/12+1).'</count>';
        $xml = $xml.'<high>'.$j.'</high>';
        $xml = $xml.'</products>';
                
        return $xml;    
    }
    
    
    /*
     * Data Access layer function
     * to find common search
     */
    function DbSearchProduct($simplexml){
        $xml = simplexml_load_string($simplexml);   
        $match = $xml->key;
        $key = str_replace(" ", "_", $match);
        
        
        $high = $xml->page*12;
        $low = $high-11;
        $query = $this->conn->query("SELECT product_name,product_id,product_price,general_price FROM product
                WHERE (product_name LIKE '%$key%') OR (author_name LIKE '%$key%') OR (publisher_name LIKE '%$key%')
                OR (isbn_no LIKE '%$key%') OR (product_detail LIKE '%$key%') OR (category LIKE '%$key%')");        
        
        $j = 0;
        $xml = '<products>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
           $j++;
           
           if($j>=$low && $j<=$high){
                $xml = $xml.'<product>';
                $xml = $xml.'<product_id>'.$row['product_id'].'</product_id>';
                $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';  
                $xml = $xml.'<general_price>'.$row['general_price'].'</general_price>';
                $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
                $xml = $xml.'</product>'; 
            }
           
        }
        
        if($j==0){
            $k = 0;
            $str = "";            
            
            $query = $this->conn->query("SELECT product_name,author_name FROM product");
            
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $string = "".$row['product_name'];
                similar_text($string,$match,$l);
                
                if($l>$k  && strlen($match)<=strlen($string)){
                    $k = $l;
                    $str = $row['product_name'];
                }
                $string = "".$row['author_name'];
                similar_text($string,$match,$l);
                
                if($l>$k && strlen($match)<=strlen($string)){
                    $k = $l;
                    $str = $row['author_name'];
                }
                
            }
            $xml = $xml.'<mean>'.$str.'</mean>';
        }
        
        $xml = $xml.'<count>'.floor($j/12+1).'</count>';
        $xml = $xml.'<high>'.$j.'</high>';
        $xml = $xml.'</products>';
                
        return $xml;    
    }
    
    /*
     * Data Access layer function
     * to implement livesearch
     */
    function DbLiveSearch($simplexml){
        $xml = simplexml_load_string($simplexml);
        $key = str_replace(" ", "_", $xml->key);;
        $query = $this->conn->query("SELECT product_name FROM product WHERE product_name LIKE '%$key%'");        
        
        $xml = '<products>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
            $xml = $xml.'<product>';
            $xml = $xml.'<key>'.$row['product_name'].'</key>';            
            $xml = $xml.'</product>'; 
        }
        
        $query = $this->conn->query("SELECT author_name FROM product WHERE author_name LIKE '$key%'");        
         
        $count = -1;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){ 
            $count++;
            $temp[$count] = $row['author_name'];
            $status = TRUE;
            for($i=0;$i<$count;$i++){
                if($temp[$i] == $temp[$count]){
                    $status = FALSE;
                    break;
                }
            }
            
            if($status){
                $xml = $xml.'<product>';
                $xml = $xml.'<key>'.$row['author_name'].'</key>';            
                $xml = $xml.'</product>'; 
            }
        }                
        
        $query = $this->conn->query("SELECT publisher_name FROM product WHERE publisher_name LIKE '$key%'");        
             
        $count = -1;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){ 
            $count++;
            $temp[$count] = $row['publisher_name'];
            $status = TRUE;
            for($i=0;$i<$count;$i++){
                if($temp[$i] == $temp[$count]){
                    $status = FALSE;
                    break;
                }
            }
            
            if($status){
                $xml = $xml.'<product>';
                $xml = $xml.'<key>'.$row['publisher_name'].'</key>';            
                $xml = $xml.'</product>'; 
            }
        }
        
        $query = $this->conn->query("SELECT isbn_no FROM product WHERE isbn_no LIKE '$key%'");             
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
            $xml = $xml.'<product>';
            $xml = $xml.'<key>'.$row['isbn_no'].'</key>';            
            $xml = $xml.'</product>'; 
        }
        
        $query = $this->conn->query("SELECT category FROM product WHERE category LIKE '$key%'");        
         
        $count = -1;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){ 
            $count++;
            $temp[$count] = $row['category'];
            $status = TRUE;
            for($i=0;$i<$count;$i++){
                if($temp[$i] == $temp[$count]){
                    $status = FALSE;
                    break;
                }
            }
            
            if($status){
                $xml = $xml.'<product>';
                $xml = $xml.'<key>'.$row['category'].'</key>';            
                $xml = $xml.'</product>'; 
            }
        }
        
        $xml = $xml.'</products>';
                
        return $xml;
    }

    
    /*
     * Data Access function to
     * get cart total
     */
    function DbGetCartTotal($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_id = $xml->user_id;
        $total = 0;
        $items = 0;
        
        $query = $this->conn->query("SELECT * FROM temp_order WHERE MD5(user_id) = '$user_id'");
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $items += $row['quantity'];
            $total += $row['price'];
        }
        
        $xml = '<cart>';
        $xml = $xml.'<total>'.$total.'</total>';
        $xml = $xml.'<items>'.$items.'</items>';
        $xml = $xml.'</cart>';
        
        return $xml;
    }

    
    /*
     * Data Access function to
     * get simply cart total
     */
    function DbGetTotal($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        $total = 0;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        
        $query = $this->conn->query("SELECT * FROM temp_order WHERE user_id = $user_id");
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $total += $row['price'];
        }
        
        $xml = '<cart>';
        $xml = $xml.'<total>'.$total.'</total>';
        $xml = $xml.'</cart>';
        
        return $xml;
    }


    /*
     * Data Access function to
     * Latest to product
     */
    function DbLatestTwoProducts(){
        $query = $this->conn->query("SELECT product_id FROM product");
        $N = $query->rowCount()-2;
        
        $query = $this->conn->query("SELECT product_id,product_name,general_price,product_price
                 FROM product LIMIT 2 OFFSET $N");
        
        $xml = '<products>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
            $xml = $xml.'<product>';
            $xml = $xml.'<product_id>'.$row['product_id'].'</product_id>';
            $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';  
            $xml = $xml.'<general_price>'.$row['general_price'].'</general_price>';
            $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
            $xml = $xml.'</product>';           
        }
        $xml = $xml.'</products>';
        
        return $xml;
    }
    
    
    /*
     * Data Access function to
     * Latest nine product
     */
    function DbLatestNineProducts(){
        $query = $this->conn->query("SELECT product_id FROM product");
        $N = $query->rowCount()-9;
        
        $query = $this->conn->query("SELECT product_id,product_name,author_name,general_price,product_price
                 FROM product order by product_id desc LIMIT 9");
        
        $xml = '<products>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
            $xml = $xml.'<product>';
            $xml = $xml.'<product_id>'.$row['product_id'].'</product_id>';
            $xml = $xml.'<product_name>'.$row['product_name'].'</product_name>';  
            $xml = $xml.'<author_name>'.$row['author_name'].'</author_name>';
            $xml = $xml.'<general_price>'.$row['general_price'].'</general_price>';
            $xml = $xml.'<product_price>'.$row['product_price'].'</product_price>';
            $xml = $xml.'</product>';           
        }
        $xml = $xml.'</products>';
        
        return $xml;
    }



    /*
     * Data Access Layer function to
     * add element to temporary cart      
     */
    function DbAddToCart($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        $user_email = $xml->user_email;
        
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        
        $query = $this->conn->query("SELECT product_price FROM product WHERE product_id = $product_id");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $product_price = $row['product_price'];
        $quantity = 1;
        
        $query = $this->conn->query("SELECT quantity,price FROM temp_order WHERE product_id = $product_id AND user_id = $user_id");                
        
        if($query->rowCount() > 0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $quantity = $quantity + $row['quantity'];
            $product_price = $product_price + $row['price'];
            
            $this->conn->exec("UPDATE temp_order SET quantity = $quantity, price = $product_price 
                        WHERE product_id = $product_id AND user_id = $user_id");
        } else {
            $this->conn->exec("INSERT INTO temp_order (product_id, user_id, quantity, price)
                    VALUES ($product_id, $user_id, $quantity, $product_price)");
        }
                
    }
    
    
    /*
     * Data Access Layer function to
     * minus element to temporary cart      
     */
    function DbLessToCart($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        $user_email = $xml->user_email;
        
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        
        $query = $this->conn->query("SELECT product_price FROM product WHERE product_id = $product_id");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $product_price = $row['product_price'];
        $quantity = 1;
        
        $query = $this->conn->query("SELECT quantity,price FROM temp_order WHERE product_id = $product_id AND user_id = $user_id");                
        
        if($query->rowCount() > 0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $quantity = $row['quantity'] - $quantity;
            if($quantity>0){
                $product_price = $row['price'] - $product_price;
                $this->conn->exec("UPDATE temp_order SET quantity = $quantity, price = $product_price 
                        WHERE product_id = $product_id AND user_id = $user_id");
            } 
        } 
                
    }
    
    
    
    
    
    /*
     * Data Access layer function
     * to get cart details
     */
    function DbGetCartDetails($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;        
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        
        $xml = '<products>';        
        $query = $this->conn->query("SELECT product_id FROM temp_order WHERE user_id = $user_id");
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $product_id = $row['product_id'];
            $xml = $xml.'<product>';
            
            $product_details = $this->conn->query("SELECT product_name,author_name,publisher_name,
                    product_price FROM product WHERE product_id = $product_id");
            $product = $product_details->fetch(PDO::FETCH_ASSOC);
            
            $xml = $xml.'<product_id>'.$product_id.'</product_id>';
            $xml = $xml.'<product_name>'.$product['product_name'].'</product_name>';
            $xml = $xml.'<author_name>'.$product['author_name'].'</author_name>';
            $xml = $xml.'<publisher_name>'.$product['publisher_name'].'</publisher_name>';
            $xml = $xml.'<product_price>'.$product['product_price'].'</product_price>';
            
            $quantity = $this->conn->query("SELECT quantity FROM temp_order WHERE product_id = $product_id");
            $number = $quantity->fetch(PDO::FETCH_ASSOC);
            $xml = $xml.'<quantity>'.$number['quantity'].'</quantity>';
            $xml = $xml.'</product>';
        }
        $xml = $xml.'</products>';  
        
        return $xml;
    }



    /*
     * Data Access Layer function
     * to remove element from cart
     */
    function DbRemoveItemFromCart($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        $user_email = $xml->user_email;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        
        $query = $this->conn->exec("DELETE FROM temp_order WHERE product_id = $product_id AND user_id = $user_id");
    }
    
    
    
    



    /*
     * DataAccess layer function to
     * clear temorary cart table
     */
    function DbFreeTempCart($simplexml){
        $xml = simplexml_load_string($simplexml);
        $user_email = $xml->user_email;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        
        $query = $this->conn->exec("DELETE FROM temp_order WHERE user_id = $user_id");   
    }



    /*
     * Data Access layer function
     * to return details rating
     */
    function DbGetRatingDetails($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        
        $query = $this->conn->query("SELECT * FROM rating WHERE product_id = $product_id");
        $xml = '<rating>';
        $total_rating = 0;
        
        if($row = $query->fetch(PDO::FETCH_ASSOC)){
            $xml = $xml.'<star_1>'.$row['star_1'].'</star_1>';
            $xml = $xml.'<star_2>'.$row['star_2'].'</star_2>';
            $xml = $xml.'<star_3>'.$row['star_3'].'</star_3>';
            $xml = $xml.'<star_4>'.$row['star_4'].'</star_4>';
            $xml = $xml.'<star_5>'.$row['star_5'].'</star_5>';
            $xml = $xml.'<avarage>'.$row['avarage'].'</avarage>';
            $total_rating += $row['total_rating'];            
        }                        
        $xml = $xml.'<total_rating>'.$total_rating.'</total_rating>';
        $xml = $xml.'</rating>';
        
        return $xml;
    }


    
    /*
     * Data Access function to
     * add new rating in database
     */
    function DbAddRating($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        $user_email = $xml->user_email;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
                
        $rating = $xml->rating;
        $feedback = $xml->feedback;
        
        $this->conn->exec("INSERT INTO feedback (user_id, product_id, rating, feedback)
                    VALUES ($user_id, $product_id ,$rating, '$feedback')");
        
        $a[1] = 0;
        $a[2] = 0;
        $a[3] = 0;
        $a[4] = 0;
        $a[5] = 0;
        
        for($i=1; $i<6; $i++){
            if($i==$rating){
                $a[$i] = 1;
            }  
        }
                
        $star_1 = $a[1];
        $star_2 = $a[2];
        $star_3 = $a[3];
        $star_4 = $a[4];
        $star_5 = $a[5];
        $total_rating = 1;
        $avarage = $rating;
                
        $query = $this->conn->query("SELECT * FROM rating WHERE product_id = $product_id");
        
        if($query->rowCount() > 0){
            $row = $query->fetch(PDO::FETCH_ASSOC);
            
            $star_1 += $row['star_1'];
            $star_2 += $row['star_2'];
            $star_3 += $row['star_3'];
            $star_4 += $row['star_4'];
            $star_5 += $row['star_5'];
            $total_rating += $row['total_rating'];
            $avarage = ($star_1*1 + $star_2*2 + $star_3*3 + $star_4*4 + $star_5*5)/$total_rating;
            
            $this->conn->exec("UPDATE rating SET star_1 = $star_1, star_2 = $star_2 ,star_3 = $star_3,
                star_4 = $star_4, star_5 = $star_5, total_rating = $total_rating, avarage = $avarage
                        WHERE product_id = $product_id");
            
        } else {
            $this->conn->exec("INSERT INTO rating (product_id, star_1, star_2, star_3, star_4, star_5, total_rating, avarage)
                    VALUES ($product_id,$star_1, $star_2, $star_3, $star_4, $star_5, $total_rating, $avarage)");
        }
        
    }



    /*
     * Data Access function to
     * recover rating status of
     * a specific product for 
     * specific user
     */
    function DbIsRated($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        $user_email = $xml->user_email;
        
        $query = $this->conn->query("SELECT user_id FROM user WHERE user_email = '$user_email'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['user_id'];
        $status = FALSE;        
        
        $query = $this->conn->query("SELECT feedback_id FROM feedback WHERE 
                product_id = $product_id AND user_id = $user_id");
        
        if($query->rowCount() > 0){
            $status = TRUE;
        }
        
        return $status;
    }
    
    
    
    /*
     * Data Access Layer function to
     * Get Feedback list for a product
     */
    function DbGetFeedback($simplexml){
        $xml = simplexml_load_string($simplexml);
        $product_id = $xml->product_id;
        
        $query = $this->conn->query("SELECT * FROM feedback WHERE product_id = $product_id");
        
        $xml = '<feed_list>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){            
            $user_id = $row['user_id'];
            
            $user_details = $this->conn->query("SELECT user_name FROM user WHERE user_id = $user_id");
            $user = $user_details->fetch(PDO::FETCH_ASSOC);
            
            $xml = $xml.'<feed>';
            $xml = $xml.'<user_id>'.md5($user_id).'</user_id>';
            $xml = $xml.'<user_name>'.$user['user_name'].'</user_name>';
            $xml = $xml.'<feedback>'.$row['feedback'].'</feedback>';
            $xml = $xml.'<rating>'.$row['rating'].'</rating>';
            $xml = $xml.'</feed>';
            
        }
        $xml = $xml.'</feed_list>';
        
        return $xml;
    }








    /*
     * this function manage
     * upload user image to
     * database
     */
    function DbUpdateUserImage($image,$user_email,$img_type){
        $update = "UPDATE user SET user_img = '$image', img_type = '$img_type' 
                        WHERE user_email = '$user_email'";
        $this->conn->exec($update);
    }
    
    
    /*
     * Data access layer function
     * to retrieve user image
     */
    function DbGetUserImage($user_id){
        $sql = "SELECT user_img,img_type FROM user WHERE MD5(user_id) = '$user_id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }
    
    
    
}
