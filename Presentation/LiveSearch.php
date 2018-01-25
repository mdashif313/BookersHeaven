<?php
    session_start();


/**
 * ©copyright 2016 Ashif & Sayed
 */

require_once '../BussinessLogic/Product.php';

    if(!empty($_GET['q'])){
        $xml = '<product>';
        $xml = $xml.'<key>'.$_GET['q'].'</key>';            
        $xml = $xml.'</product>';
        
        $product = new Product();
        
        $resultxml = $product->LiveSearch($xml);
        $result = simplexml_load_string($resultxml);
        
        foreach($result->children() as $product){
            $string = str_replace(" ", "%20", $product->key);
            echo '<a href=http://localhost:8080/BookersHeaven/Presentation/SearchPage.php?q='.$string.'>'.$product->key.'</a><br>';
        }
    }

