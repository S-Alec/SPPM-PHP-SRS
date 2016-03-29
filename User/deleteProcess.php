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
   $uid = $_POST['$uid'];

   $return = false;

   $mysqli = new mysqli (
     $host,
     $user,
     $pwd,
     $sql_db
   );

   $userPro = UserProcess;

   /* Check Connection */
   if( $mysqli->connect_errno )
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }

   $insert = $userPro->deleteUser($uid, $lname, $password, $role);

   if( $mysqli->query($insert) === FALSE )
   {
     printf("Data Handler Failed: %s\n", $mysqli->error);
     result
   }
   else {
      $return = true;
   }
   $mysqli->close();

   echo $return;
 }


?>
