<?php
/**
 *	Handle Insert User.
 */
?>
<?php
    require_once '../SQL/settings.php';
    require_once 'model.php';
 if (isset($_POST['username']) and isset($_POST['password']) and isset($_POST['lname']) and isset($_POST['role'])) {
     $username = $_POST['username'];
     $password = $_POST['password'];
     $lname = $_POST['lname'];
     $role = $_POST['role'];

     $return = 'false';

     $mysqli = new mysqli(
     $host,
     $user,
     $pwd,
     $sql_db
   );

     $userPro = new UserModel();

   /* Check Connection */
   if ($mysqli->connect_errno) {
       printf("Connection Failed: %s\n", $mysqli->connect_error);
       exit();
   }

     //check if username exist or not
	   $sql = $userPro->getUserByUsername($username);
		 $result = $mysqli->query($sql);
     if ($result->num_rows == 0) {
         $insert = $userPro->insertUser($username, $lname, $password, $role);
         if ($mysqli->query($insert) === false) {
             printf("Data Handler Failed: %s\n", $mysqli->error);
             $return = 'false';
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
