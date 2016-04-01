<?php
  /** 
   *  Determines if the AJAX login request sent by the user is 
   *  valid and what privileges the account is.
   */
?>
<?php
  session_start();
  require_once("../SQL/QueryDB.php");
  require_once("../SQL/settings.php");

 if( isset($_POST['username']) && isset($_POST['password']) )
 {
 	$lUsername = $_POST['username'];
 	$lPassword = $_POST['password'];

 	// 0 : Fail | 1 : Staff | 2 : Manager
 	$lReturn = 0;
 	$lQuery = new QueryDB;

	// Connect to DB
	$mysqli = new mysqli (
	  $host,
	  $user,
	  $pwd,
	  $sql_db
	);

	/* Check Connection */
	if( $mysqli->connect_errno )
	{
	  printf("Connection Failed: %s\n", $mysqli->connect_error);
	  exit();
	}

	/* Get Username and Password */
	$result = $mysqli->query( $lQuery->getLoginDetails($lUsername) );
	
	if( $result )
	{
	  /* Ensure only a single row has been found */
	  if( $result->num_rows === 1 )
	  {
	    $row = $result->fetch_assoc();

	  	/* Verify Password */
		if( password_verify($lPassword, $row['password']) )
		{
		  $_SESSION['loggedin']['uid'] = $row['uid'];
		  $_SESSION['loggedin']['username'] = $row['username'];
		  $_SESSION['loggedin']['role'] = $row['role'];
		  $_SESSION['loggedin']['lname'] = $row['lname'];
		  $_SESSION['loggedin']['remove'] = $row['remove']; // Unless the user has been removed they are allowed to login

		  if( $row['role'] === "MANAGER" )
		  {
		  	$lReturn = 2;
		  }

		  if( $row['role'] === "STAFF" )
		  {
		  	$lReturn = 1;
		  }
		}
	  }
	}
	else
	{
	 printf("Query Failed: %s\n", $mysqli->error); 
	}

	echo $lReturn;
	$mysqli->close();
 }
 else
 {
   session_unset();
   session_destroy();
 }
?>