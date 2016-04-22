<?php
	session_start();
	require("../SQL/settings.php");
	require_once("../SQL/QueryDB.php");

	// Check Session
	if( !$_SESSION['loggedin']['role'] === "MANAGER" )
	{
		header("location: ../");
	}

	// http://code.stephenmorley.org/php/creating-downloadable-csv-files/
	$filename = date('d-m-Y')."-StockLevels.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$filename);

	/* Connect to DB */
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

  $lQuery = new QueryDB;
  
  /* Perform Query */
  $result = $mysqli->query( $lQuery->getAllStockQuantity() );

  if( $result )
  {
  	// Open file pointer connected to the output stream
  	$output = fopen('php://output', 'w');

  	// output the column headings
  	fputcsv($output, array('Product', 'Stock Level', 'Brand', 'Category', 'Barcode', 'Price'));

  	while( $row = $result->fetch_assoc() )
  	{
  		fputcsv($output, array($row['pname'], $row['stockamount'], $row['brand'], $row['category'], $row['barcode'], $row['salesprice']));
  	}
  }
?>