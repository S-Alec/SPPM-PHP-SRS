<?php
/**
 *	Handle Insert Stock.
 */
?>
<?php
    require_once '../SQL/settings.php';
    require_once 'model.php';

 if (isset($_POST['barcode']) and isset($_POST['pname'])
 and isset($_POST['brand']) and isset($_POST['category'])
 and isset($_POST['description']) and isset($_POST['salesprice'])
 and isset($_POST['quantity'])
 ) {
     $barcode = $_POST['barcode'];
     $pname = $_POST['pname'];
     $brand = $_POST['brand'];
     $category = $_POST['category'];
     $description = $_POST['description'];
     $salesprice = $_POST['salesprice'];
     $quantity = $_POST['quantity'];

     $return = 'false';

     $mysqli = new mysqli(
         $host,
         $user,
         $pwd,
         $sql_db
       );

     $productModel = new ProductModel();

   /* Check Connection */
   if ($mysqli->connect_errno) {
       printf("Connection Failed: %s\n", $mysqli->connect_error);
       exit();
   }

   $query = $productModel->insertProduct($barcode, $pname, $brand, $category, $description);
   if ($mysqli->query($query) === false) {
       printf("Data Handler Failed: %s\n", $mysqli->error);
       $return = 'the product cannot be insearted';
   } else {
       $pid = $mysqli->insert_id;
       // insert sale price and amount
       $query = $productModel->inseartSaleItem($pid, $salesprice, $quantity);
       if ($mysqli->query($query) === false) {
           printf("Data Handler Failed: %s\n", $mysqli->error);
           $return = 'the product saleprices and amount cannot be insearted';
       } else {
         $query = $productModel->insertStockOrder($pid, $quantity);
         if ($mysqli->query($query) === false) {
             printf("Data Handler Failed: %s\n", $mysqli->error);
             $return = 'the product saleprices and amount cannot be insearted';
         } else {
            $return = 'true';
         }
       }
   }

   $mysqli->close();
   echo $return;
 }

?>
