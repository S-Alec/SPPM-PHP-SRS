<?php
/**
 *	This Class provides the queries required to insert data
 *	into their appropriate tables.
 */
?>
<?php

class InsertData
{
	/**
	 *	Role
	 *	Insert String for the Role Table
	 */
	public static function insertAccountType( $aRole )
	{
		$insertString = "INSERT INTO ROLE (role)
			VALUES ('$aRole')";

		return $insertString;
	}

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
	 * Product
	 */
	public static function insertProduct( $aBarcode, $aProductName, $aBrand, $aCategory, $aDescription )
	{
		$insertString = "INSERT INTO PRODUCT ( barcode, pname, brand, category, description )
		VALUES ('$aBarcode', '$aProductName', '$aBrand', '$aCategory', '$aDescription')";

		return $insertString;
	} 

	/**
	 *	Stock Order
	 */
	public static function insertStockOrder( $aPID, $aOrderAmount )
	{
		$insertString = "INSERT INTO STOCKORDER ( pid, orderamount )
		VALUES ('$aPID', '$aOrderAmount')";

		return $insertString;
	}

	/**
	 *	Sale Item
	 */
	public static function insertSaleItem( $aPID, $aPrice, $aStockAmount )
	{
		$insertString = "INSERT INTO SALEITEM ( pid, salesprice, stockamount )
		VALUES ('$aPID', '$aPrice', '$aStockAmount')";

		return $insertString;
	}

	/**
	 *	Receipt
	 */
	public static function insertReceipt( $aUid, $aTotalPrice )
	{
		$insertString = "INSERT INTO RECEIPT ( uid, totalspent )
		VALUES ('$aUid', '$aTotalPrice')";

		return $insertString;
	}

	/**
	 *	Transaction
	 */
	public static function insertTransaction( $aReceiptCode, $aPID, $aSalesPrice, $aQuantity )
	{
		$insertString = "INSERT INTO TRANSACTION (receiptcode, pid, salesprice, quantity)
		VALUES ('$aReceiptCode', '$aPID', '$aSalesPrice', '$aQuantity')";

		return $insertString;
	}
}
?>