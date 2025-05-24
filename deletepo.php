<?php  
 require 'dbconnection.php'; 
      
           $deleteId = $_GET['id']; 
            $po = $_GET['po'];  
        
      // check record exists  
     $dbquery_del  = "UPDATE purchase_order_item SET deleteitem='1' where id=".$deleteId;
   // $result_del   = $conn->query($dbquery_del);
           if ($conn->query($dbquery_del)) { 
               echo 1;
               $ststus='?status=succd';
                header("Location:modifypo.php?id=".$po); 
                exit;  
           }else{  
                echo 0;  
                exit;  
           }  
 ?>