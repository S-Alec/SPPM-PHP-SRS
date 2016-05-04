<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderTransactionController extends CI_Controller {

  //construction
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
		$this->load->model('ProductModel', 'productModel');
		$this->load->model('ReceiptModel', 'receiptModel');
		$this->load->model('TransactionModel', 'transactionModel');
		$this->load->model('SaleItemModel', 'saleItemModel');
		$this->load->library('session');
    $this->load->helper('url');
		$this->load->library('Pdf');
	}

	/**
	 * index page
	 */
	public function index()
	{

		if ($this->session->has_userdata('loggedin'))
		{

			//get all of users
			$data['pageTitles'] = 'Order Transaction Management';
			//$data['users'] = $this->userModel->getAll();
			//load contens into page
			$this->load->view('templates/header', $data);
			$this->load->view('OrderTransaction/index', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			header('Location: /');
		}
	}

	/**
	 * handle find products request
	 */
	public function find()
	{
		$result = $this->productModel->find($this->input->post('searchterm'));
		//return json format
		header('Content-Type: application/json');
		echo json_encode($result);
	}


	/**
	 * handle print receipt
	 */
	public function printReceipt()
	{
		//set timezone
		if( ! ini_get('date.timezone') )
		{
				date_default_timezone_set('GMT');
		}

		$lReceiptCode = $this->input->get('receiptcode');
		// create new pdf document
		ob_start();
  	$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
		$html = "<style> tr {line-height: 30px;} td { border-top-color:#000000;border-top-width:1px;border-top-style:solid; 1px solid black;}</style>";
  	$html .= "<h1>Receipt No. ".$lReceiptCode."</h1>
	  <table border='1'>
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
	  $result = $this->transactionModel->getTransactionDetails($lReceiptCode);

	  $lTotal = 0;
  	foreach ($result as $index => $row)
		{
			$subtotal = $row->salesprice * $row->quantity;

			$html .= "<tr>
			<td>".$row->barcode."</td>
			<td>".$row->brand."</td>
			<td>".$row->pname."</td>
			<td>".$row->category."</td>
			<td>".number_format($row->salesprice, 2, '.', '')."</td>
			<td>".$row->quantity."</td>
			<td>$".number_format(($subtotal), 2, '.', '' )."</td></tr>";

			$lTotal += ($subtotal);
		}

	  $html .= "<tr>
		  <td></td><td></td><td></td><td></td><td></td>
	    <td>
	      <strong>Total :</strong>
	    </td>
	    <td><strong>$".number_format($lTotal, 2, '.', '')."</strong></td></tr>";
		$html .= "</table>";

		$pdf->setPageMark();
		$pdf->writeHTML($html, true, false, false, false, '');

		// reset pointer to the last page
		$pdf->lastPage();

		// Close and output PDF document
	  $lFileName = "Receipt_".$lReceiptCode.".pdf";
		ob_end_clean();
		$pdf->Output($lFileName, 'D');
	}
	/**
	 * handle add a transaction request
	 */
	public function addTransaction()
	{
		$lJsonObject = $this->input->post('json');
		$lDecodedObjects = json_decode($lJsonObject);
		$lErrorMessage = '';


    $lTotal = 0;
    $lValid = 1;

  	/* Parse Json object into arrays */
  	foreach( $lDecodedObjects as $lDecodedArray)
  	{
  		$lPid[] = $lDecodedArray->{'pid'};
  		$lQuantity[] = $lDecodedArray->{'quantity'};
  	}

    /* Check if Pid and quantity has been provided */
    if( count($lPid) == 0 || count($lQuantity) == 0 )
    {
      $lValid = 0;
      $lErrorMessage .= "<li>Cart is empty</li>";
    }
    else
    {
      /* Check for duplicate pids */
    	for( $i = 0; $i < count($lPid); $i++ )
    	{
    		for( $y = 0; $y < count($lPid); $y++ )
    		{
          if( $i != $y )
    			{
    				if( $lPid[$i] == $lPid[$y] )
    				{
              // Add Quantity to first $lPid
    					$lQuantity[$i] += $lQuantity[$y];

    					// Remove Pid index and quantity
    					unset($lPid[$y]);
    					unset($lQuantity[$y]);

    					// Reorder arrays
    					$lPid = array_values($lPid);
    					$lQuantity = array_values($lQuantity);

              // Test the same index
              $y--;
    				}
    			}
    		}
    	}

    	/* Validate Transactions */
    	for( $i = 0; $i < count($lPid); $i++ )
    	{
    		$result = $this->productModel->getProductNamePriceQuantity($lPid[$i]);

    		// Check if PID is available (only 1 row)
    		if(sizeof($result) != 1)
    		{
    			$lErrorMessage .= "<li>Product not found: ".$lPid[$i]."</li>";
    			$lValid = 0;
    		}
    		else
    		{
    			$row = $result[0];

    			// Check if stock exists
    			if($row->stockamount < $lQuantity[$i])
    			{
    				$lErrorMessage .= "<li>Insufficient Stock for: ". $row->pname ."</li>";

    				$lValid = 0;
    			}
    			else
    			{
    				// Store salesprice
    				$lSalesPrice[] = $row->salesprice;

    				// Evaluate Total
    				$lTotal += ($lSalesPrice[$i] * $lQuantity[$i]);
    			}
    		}
    	}

    	if($lValid)
    	{
				/* Insert receipt into Receipt table */
				$oReceipt = new receiptModel();
				$loggedin = $this->session->userdata('loggedin');
				$oReceipt->uid = $loggedin->uid;
				$oReceipt->totalspent = $lTotal;
				$result = $this->receiptModel->add($oReceipt);
				if($result != false)
				{
						//GET CODE
						$lReceiptCode = $result;
				}

    		for( $i = 0; $i < count($lPid); $i++ )
    		{
  	  		/* Insert transaction into transaction table */
					$oTransaction = new transactionModel();
					$oTransaction->receiptcode = $lReceiptCode;
					$oTransaction->pid = $lPid[$i];
					$oTransaction->salesprice = $lSalesPrice[$i];
					$oTransaction->quantity = $lQuantity[$i];

					if($this->transactionModel->add($oTransaction))
					{
						/* Update stock amount in sales table */
						$this->saleItemModel->deductStock($lPid[$i], $lQuantity[$i]);
					}
  	  	}
			}

			$lJsonString = array('valid' => $lValid, 'errors' => $lErrorMessage, 'receiptcode' => $lReceiptCode);

  		echo json_encode($lJsonString);
		}
	}


}
?>
