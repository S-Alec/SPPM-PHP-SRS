<?php
  if( isset($_POST['json']) )
  {
  	$lJsonObject = $_POST['json'];
  	printf($lJsonObject);

  	$lDecoded = json_decode($lJsonObject);
  	print_r($lDecoded);
  }
?>