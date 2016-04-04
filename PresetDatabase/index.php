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
	else
	{
		/* Populate product table */
		$insert = "INSERT INTO PRODUCT (barcode, pname, brand, category, description)
					VALUES ('0000000000', 'TestMed1', 'Test', 'Skin', 'Use on Skin'),
						   ('0000000001', 'TestMed2', 'Test', 'Skin', 'Use on Skin if allergic to #1'),
						   ('0000000002', 'TestMed3', 'Test', 'Face', 'Use on Face'),
						   ('0000000003', 'TestMed4', 'Med1', 'Hands', 'Use on Hands'),
						   ('0000000004', 'TestMed5', 'RELIEF', 'Tablet', 'Swallow with water')";

		if( $mysqli->query($insert) === FALSE )
		{
			printf("Data Insertion Failed: %s\n", $mysqli->error);	
		}
	}

	/* Create Stock Order Table */
	if( $mysqli->query($lCreateTable->createStockOrderTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}
	else
	{
		/* Populate Stock order table */
		/* Populate product table */
		$insert = "INSERT INTO STOCKORDER (pid, orderamount)
					VALUES ('1', '100'),
						   ('2', '100'),
						   ('3', '100'),
						   ('4', '100'),
						   ('5', '100')";

		if( $mysqli->query($insert) === FALSE )
		{
			printf("Data Insertion Failed: %s\n", $mysqli->error);	
		}
	}

	/* Create Sale Item Table */
	if( $mysqli->query($lCreateTable->createSaleItemTable()) === FALSE )
	{
		printf("Table Creation Failed: %s\n", $mysqli->error);
	}
	else
	{
		/* Populate Sales Item table */
		$insert = "INSERT INTO SALEITEM (pid, salesprice, stockamount)
					VALUES ('1', '10.50', '100'),
						   ('2', '5.50', '100'),
						   ('3', '7.99', '100'),
						   ('4', '2.00', '100'),
						   ('5', '80', '100')";

		if( $mysqli->query($insert) === FALSE )
		{
			printf("Data Insertion Failed: %s\n", $mysqli->error);	
		}	
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