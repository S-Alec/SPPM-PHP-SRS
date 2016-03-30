<?php
/**
 *	This class is responsible for generating the neccessary queries
 *	required to create the tables for the database.
 */
?>
<?php
	
class CreateTable
{
	/**
	 *	Create the Role Table
	 *	Field Descriptions-
	 *		role : Users role in the system [STAFF | MANAGER]
	 */
	public static function createRoleTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS ROLE (
			role 	VARCHAR(7) NOT NULL,

			PRIMARY KEY (role)
		);";

		return $create;
	}

	/**
	 *	Create the User Table
	 *	Field Descriptions-
	 *		uid 		: User id
	 *		username 	: Usually the users first name
	 *		lname 		: Users last name
	 *		password 	: User defined password, hashed
	 *		role 		: FK defining users role in system
	 *		remove 		: specifies temporary delete INT 
	 */
	public static function createUserTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS USER (
			uid 		INT AUTO_INCREMENT NOT NULL,
			username 	VARCHAR(20) NOT NULL,
			lname 		VARCHAR(20) NOT NULL,
			password  	VARCHAR(256) NOT NULL,
			role 		VARCHAR(7) NOT NULL,
			remove 		INT(1) NOT NULL DEFAULT 0,

			FOREIGN KEY (role) REFERENCES ROLE (role),
			PRIMARY KEY (uid)

		);";

		return $create;
	}

	/**
	 *	Create the Product Table
	 *	Field Descriptions-
	 *		pid 		: product id
	 *		barcode 	: 10 Character barcode
	 *		pname 		: product name
	 *		brand 		: product brand
	 *		category 	: category of product application
	 *		description : description of how to apply product  
	 */
	public static function createProductTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS PRODUCT (
			pid 		INT AUTO_INCREMENT NOT NULL,
			barcode 	VARCHAR(10) NOT NULL,
			pname 		VARCHAR(20) NOT NULL,
			brand 		VARCHAR(20) NOT NULL,
			category 	VARCHAR(20) NOT NULL,
			description VARCHAR(100) NOT NULL,

			PRIMARY KEY (pid)
		);";

		return $create;
	}

	/**
	 *	Create table Stock Order table
	 *	Field Descriptions-
	 *		sid 		: stock id
	 *		pid 		: FK Product id
	 *		orderdate 	: datetime ordered
	 *		orderamount : original amount
	 */
	public static function createStockOrderTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS STOCKORDER (
			sid 		INT AUTO_INCREMENT NOT NULL,
			pid 		INT NOT NULL,
			orderdate	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			orderamount INT(5) NOT NULL,

			FOREIGN KEY (pid) REFERENCES PRODUCT (pid),
			PRIMARY KEY (sid, pid)
		);";

		return $create;
	}

	/**
	 *	Create table Sale item table
	 *	Field Descriptions-
	 *		pid 		: FK product id
	 *		salesprice	: current price of product
	 *		stockamount : Current stock amount
	 */
	public static function createSaleItemTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS SALEITEM (
			pid 		INT NOT NULL,
			salesprice decimal(6,3) NOT NULL,
			stockamount INT(5) NOT NULL,

			FOREIGN KEY (pid) REFERENCES PRODUCT (pid),
			PRIMARY KEY (pid)
		);";

		return $create;
	}

	/**
	 *	Create table Receipt Table
	 *	Field Descriptions-
	 *		receiptcode 	: transaction code auto generated
	 *		transactiondate : date time when item was inserted
	 *		totalspent		: total amount spent on all products
	 */
	public static function createReceiptTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS RECEIPT (
			receiptcode 	INT AUTO_INCREMENT NOT NULL,
			transactiondate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			totalspent 		decimal(5,3) NOT NULL,

			PRIMARY KEY (receiptcode)
		);";

		return $create;
	} 

	/**
	 *	Create table Transaction Table
	 *	Field Descriptions-
	 *		receiptcode 	: FK identifier
	 *		pid 			: FK product id
	 *		salesprice 		: Price that item was bought at
	 *		quantity 		: quantity of items bought
	 */
	public static function createTransactionTable()
	{
		$create = "CREATE TABLE IF NOT EXISTS TRANSACTION (
			receiptcode INT NOT NULL,
			pid 		INT NOT NULL,
			salesprice 	DECIMAL(3,3),
			quantity 	INT(3) NOT NULL,

			FOREIGN KEY (pid) REFERENCES PRODUCT (pid),
			FOREIGN KEY (receiptcode) REFERENCES RECEIPT (receiptcode),
			PRIMARY KEY (receiptcode)
		);";

		return $create;
	}
}
?>