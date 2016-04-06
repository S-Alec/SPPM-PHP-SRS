<?php
/**
 *	Handle Insert Stock.
 */
?>
<?php
    require_once '../SQL/settings.php';
    require_once 'model.php';

 if (isset($_POST['barcode']) and isset($_POST['pname']) and isset($_POST['brand']) and isset($_POST['category']) and isset($_POST['description'])) {
     $barcode = $_POST['barcode'];
     $pname = $_POST['pname'];
     $brand = $_POST['brand'];
     $category = $_POST['category'];
     $description = $_POST['description'];

     $return = 'false';

     $mysqli = new mysqli(
     $host,
     $stock,
     $pwd,
     $sql_db
   );

     $stockPro = new ProductModel();

   /* Check Connection */
   if ($mysqli->connect_errno) {
       printf("Connection Failed: %s\n", $mysqli->connect_error);
       exit();
   }

   $insert = $stockPro->insertProduct($barcode, $pname, $brand, $category, $description);
   if ($mysqli->query($insert) === false) {
       printf("Data Handler Failed: %s\n", $mysqli->error);
       $return = 'the product cannot be insearted';
   } else {
       $return = 'true';
   }

   $mysqli->close();
   echo $return;
 }

?>
