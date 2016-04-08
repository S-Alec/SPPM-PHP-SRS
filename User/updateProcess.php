<?php
/**
 *	Handle update User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

 if(isset($_POST['uid']) and isset($_POST['username']) and isset($_POST['password']) and isset($_POST['lname']) and isset($_POST['role']) )
 {
   $uid = $_POST['uid'];
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

   $userModel = new UserModel;

   /* Check Connection */
   if( $mysqli->connect_errno)
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }

	 //check if username exist or not
	 $query = $userModel->getUserByUsername($username);
	 $query = $query . " AND uid != '$uid'";
	 $result = $mysqli->query($query);
	 if ($result->num_rows == 0) {
		   $query = $userModel->updateUser($uid, $username, $lname, $password, $role);
			 if ($mysqli->query($query) === false) {
					 printf("Data Handler Failed: %s\n", $mysqli->error);
					 $return = 'the user cannot be updated';
			 } else {
					 $return = 'true';
			 }
	 } else {
		 $return = 'the username is already used';
	 }

   $mysqli->close();

   echo $return;
 }


?>
