<?php
/**
 *	Handle update User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

 if(isset($_POST['uid']))
 {
   $uid = $_POST['uid'];

   $mysqli = new mysqli (
     $host,
     $user,
     $pwd,
     $sql_db
   );

   $userModel = new UserModel;

   /* Check Connection */
   if( $mysqli->connect_errno )
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }

   $query = $userModel->deleteUser($uid);

   if( $mysqli->query($query) === FALSE )
   {
     printf("Data Handler Failed: %s\n", $mysqli->error);
     $return = 'the user cannot be deleted';
   }
   else {
     $return = 'true';
   }
   $mysqli->close();

   echo $return;
 }


?>
