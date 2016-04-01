<?php
	session_start();
	require("../SQL/settings.php");
	require_once("../SQL/QueryDB.php");
	require_once("tcpdf_include.php"); // pdf creator

	if( !isset($_SESSION['loggedin']) )
	{
		exit();
	}

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

  if( isset($_GET['receiptcode']) )
  {
  	$lReceiptCode = $_GET['receiptcode'];
    $lQuery = new QueryDB;

  	// create new pdf document
  	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  	// set document information
  	$pdf->SetCreator(PDF_CREATOR);
  	$pdf->SetAuthor('SPPM-PHP-SRS');
  	$pdf->SetTitle('Receipt: '.$lReceiptCode);
  	$pdf->SetSubject('Customer Receipt');
  	$pdf->SetKeywords('Receipt');

  	// remove default header/footer
  	$pdf->setPrintHeader(false);
  	$pdf->setPrintFooter(false);

  	// set default monospaced font
  	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  	// set margins
  	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

  	// set auto page breaks
  	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  	$pdf->AddPage();

  	// html content to print
  	$html = "<h1>Receipt No. ".$lReceiptCode."</h1>
    <table border=\"1\">
    <tr>
      <th><strong>Barcode</strong></th>
      <th><strong>Brand</strong></th>
      <th><strong>Name</strong></th>
      <th><strong>Category</strong></th>
      <th><strong>Price</strong></th>
      <th><strong>Quantity</strong></th>
      <th><strong>Total</strong></th>
    </tr>";

    /* Get Receipt details */
    $result = $mysqli->query( $lQuery->getTransactionDetails($lReceiptCode) );

    $lTotal = 0;

    while( $row = mysqli_fetch_assoc($result) )
    {
      $html .= "<tr>
      <td>".$row['barcode']."</td>
      <td>".$row['brand']."</td>
      <td>".$row['pname']."</td>
      <td>".$row['category']."</td>
      <td>".$row['salesprice']."</td>
      <td>".$row['quantity']."</td>
      <td>$".($row['salesprice'] * $row['quantity'])."</td></tr>";

      $lTotal += ($row['salesprice'] * $row['quantity']);
    }

    $html .= "<tr>
      <td colspan=\"6\">
        <strong>Total :</strong>
      </td>
      <td><strong>$".$lTotal."</strong></td></tr>";

  	$pdf->writeHTML($html, true, false, true, false, '');

  	// reset pointer to the last page
  	$pdf->lastPage();

  	// Close and output PDF document
    $lFileName = $lReceiptCode.".pdf";
  	$pdf->Output($lFileName, 'D');
  }

  $mysqli->close();
?>