<?php
/**
 *	Running this file will create the database and preset any 
 *	any of the tables.
 */
?>
<?php
	require_once("../SQL/settings.php");
	require_once("../SQL/CreateTable.php");
	require_once("../SQL/InsertData.php");

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

	$lCreateTable = new CreateTable;
	$lInsertData = new InsertData;

	/* Create Role Table */
	if( $mysqli->query($lCreateTable->createRoleTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}
	else
	{
		/* Populate the Role Table */

		// MANAGER - Functions like an admin account
		// STAFF   - Standard employee account
		$insert = "INSERT INTO ROLE (role)
					VALUES ('MANAGER'),
						   ('STAFF')";

		if( $mysqli->query($insert) === FALSE )
		{
			printf("Data Insertion Failed: %s\n", $mysqli->error);	
		}
	}

	/* Create the User Table */
	if( $mysqli->query($lCreateTable->createUserTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}
	else
	{
		/* Inserts admin account */
		
		// USERNAME : ADMIN
		// PASSWORD : PASSWORD
		$insert = $lInsertData->insertUser('ADMIN', 'ADMIN', 'PASSWORD', 'MANAGER');

		if( $mysqli->query($insert) === FALSE )
		{
			printf("Data Insertion Failed: %s\n", $mysqli->error);
		}

	}

	/* Create Product Table */
	if( $mysqli->query($lCreateTable->createProductTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}

	/* Create Stock Order Table */
	if( $mysqli->query($lCreateTable->createStockOrderTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}

	/* Create Sale Item Table */
	if( $mysqli->query($lCreateTable->createSaleItemTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}

	/* Create Receipt Table */
	if( $mysqli->query($lCreateTable->createReceiptTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}

	/* Create Transaction Table */
	if( $mysqli->query($lCreateTable->createTransactionTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}

	$mysqli->close();	

	printf("Database Modified");
?>