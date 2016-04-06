<?php
/**
 *	Handle insert new user to database
 *
 */
?>

<?php
class UserModel
{
	/**
	 *	Users
	 *	Insert String for the User Table
	 * 	Salts + Hashes the Users password before inserting it
	 *	into the table
	 */
	public static function insertUser( $aUsername, $aLName, $aPassword, $aRole )
	{
		$lHashedSaltedPassword = password_hash($aPassword, PASSWORD_DEFAULT);

		$insertString = "INSERT INTO USER ( username, lname, password, role )
			VALUES ('$aUsername', '$aLName', '$lHashedSaltedPassword', '$aRole' )";

		return $insertString;
	}

	/**
	 *	Users
	 *	Update String for the User Table
	 * 	Salts + Hashes the Users password before updateing it
	 *	into the table
	 */
	public static function updateUser( $aId, $aUsername, $aLName, $aPassword, $aRole)
	{
		$insertString = "UPDATE USER SET lname = '$aLName'";
		//check is change password
		if(empty($aPassword))
		{
			$lHashedSaltedPassword = password_hash($aPassword, PASSWORD_DEFAULT);
			$insertString .= ", password = '$lHashedSaltedPassword'";
		}
		$insertString .= ", username = '$aUsername'";
		$insertString .= ", role = '$aRole'";
		$insertString .= " WHERE uid = '$aId'";

		return $insertString;
	}

	/**
	 *	Users
	 *	Update String for the User Table
	 * 	Salts + Hashes the Users password before updateing it
	 *	into the table
	 */
	public static function deleteUser($aId)
	{
		$insertString = "DELETE FROM USER WHERE uid = $aId";
		return $insertString;
	}

	/**
	 *	Users
	 *	Update String for the User Table
	 * 	Salts + Hashes the Users password before updateing it
	 *	into the table
	 */
	public static function getUserList()
	{
		$insertString = "SELECT uid, username, lname, role FROM USER";
		return $insertString;
	}

	/**
	 *	Users
	 *	Update String for the User Table
	 * 	Salts + Hashes the Users password before updateing it
	 *	into the table
	 */
	public static function getUserByUsername($username)
	{
		$insertString = "SELECT uid FROM USER WHERE username = '$username'";
		return $insertString;
	}
}
?>
