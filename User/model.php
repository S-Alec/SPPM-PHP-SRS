<?php
/**
*	Handle sql query in user secntion
*  return CRUD query string
*
*/
?>

<?php
class UserModel
{
	/**
		*	Users
		*	return sql query for inserting a user
	 */
	public static function insertUser( $aUsername, $aLName, $aPassword, $aRole )
	{
		$lHashedSaltedPassword = password_hash($aPassword, PASSWORD_DEFAULT);

		$query = "INSERT INTO USER ( username, lname, password, role )
			VALUES ('$aUsername', '$aLName', '$lHashedSaltedPassword', '$aRole' )";

		return $query;
	}

	/**
	 *	Users
	 *	return sql query for updating a user
	 */
	public static function updateUser( $aId, $aUsername, $aLName, $aPassword, $aRole)
	{
		$query = "UPDATE USER SET lname = '$aLName'";
		//check is change password
		if(empty($aPassword))
		{
			$lHashedSaltedPassword = password_hash($aPassword, PASSWORD_DEFAULT);
			$query .= ", password = '$lHashedSaltedPassword'";
		}
		$query .= ", username = '$aUsername'";
		$query .= ", role = '$aRole'";
		$query .= " WHERE uid = '$aId'";

		return $query;
	}

	/**
	 *	Users
	 *	return sql query for deleteing a user
	 */
	public static function deleteUser($aId)
	{
		$query = "DELETE FROM USER WHERE uid = $aId";
		return $query;
	}

	/**
	 *	Users
 	 *	return sql query for selecting all of user
	 */
	public static function getUserList()
	{
		$query = "SELECT uid, username, lname, role FROM USER";
		return $query;
	}

	/**
	 *	Users
	 *	return sql query for checking existance of username
	 */
	public static function getUserByUsername($username)
	{
		$query = "SELECT uid FROM USER WHERE username = '$username'";
		return $query;
	}
}
?>
