<?php
	session_start();
	require("../SQL/settings.php");
	require_once("../SQL/QueryDB.php");
  require_once("GraphData.php");
  require_once("SortedGraphDataIterator.php");

	// Check Session
	if( !$_SESSION['loggedin']['role'] === "MANAGER" )
	{
		header("location: ../");
	}

  if( !isset($_POST['datefrom']) && !isset($_POST['dateto']) )
  {
    exit();
  }

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
  $lDateFrom = $_POST['datefrom'];
  $lDateTo = $_POST['dateto'];

  /* Perform Query */
  $result = $mysqli->query( $lQuery->findTransactionDetails($lDateFrom, $lDateTo) );

  if( $result )
  {
  	while( $row = $result->fetch_assoc() )
  	{
      $lGraphData[] = new GraphData($row['pname'], $row['date'], $row['quantity']);
    }

    $lSortedGraphData = new SortedGraphDataIterator($lGraphData);

    $lRangedGraphData = array();
    $lProductNames = array();
    foreach( $lSortedGraphData as $key => $lSingleItem )
    {
      // Store single item in multidimensional array
      $lRangedGraphData[] = $lSingleItem;

      //Get all keys within array
      foreach( array_keys($lSingleItem) as $lProductName )
      {
        if( $lProductName != "date" )
        {
          $lProductNames[] = $lProductName;
        }
      }
    }

    // Sort Product Name Keys
    for( $i = 0; $i < count($lProductNames); $i++ )
    {
      for( $j = 0; $j < count($lProductNames); $j++ )
      {
        if( $i != $j )
        {
          if( $lProductNames[$i] === $lProductNames[$j] )
          {
            // Remove duplicate data
            unset($lProductNames[$j]);

            // Rebuild array
            $lProductNames = array_values($lProductNames);

            // decrement j
            $j--;
          }
        }
      }
    }

    if( count($lProductNames) )
    {
      // Send the results back to the client
      echo json_encode( array("data" => $lRangedGraphData, "labels" => $lProductNames) ); 
    }
  }
?>