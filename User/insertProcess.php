<?php
/**
 *	Handle Insert User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

 if(isset($_POST['username']) && $_POST['password']) && isset($_POST['lname']) && isset($_POST['role']) )
 {
   $username = $_POST['username'];
   $password = $_POST['password'];
   $lname = $_POST['lname'];
   $role = $_POST['role'];

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

   $insert = $userPro->insertUser($username , $lname, $password, $role);

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
