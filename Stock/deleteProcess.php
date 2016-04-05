<?php
/**
 *	Handle update User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

 if(isset($_POST['pid']))
 {
   $uid = $_POST['pid'];

   $mysqli = new mysqli (
     $host,
     $user,
     $pwd,
     $sql_db
   );

   $userPro = new ProductModel();

   /* Check Connection */
   if( $mysqli->connect_errno )
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }

   $insert = $userPro->deleteProduct($uid);
	 //echo $insert;
   if( $mysqli->query($insert) === FALSE )
   {
     printf("Data Handler Failed: %s\n", $mysqli->error);
     $return = 'the product cannot be deleted';
   }
   else {
     $return = 'true';
   }
   $mysqli->close();

   echo $return;
 }


?>
