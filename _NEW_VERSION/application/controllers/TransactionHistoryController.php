<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionHistoryController extends CI_Controller {

  //construction
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
		$this->load->model('ReceiptModel', 'receiptModel');
		$this->load->model('TransactionModel', 'transactionModel');
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
    	$loggedin = $this->session->userdata('loggedin');
      if($loggedin->role === "STAFF")
      {
        redirect(base_url('/ordertransaction'), 'location');
      }
      else if($loggedin->role === "MANAGER")
      {
        //get all of users
  			$data['pageTitles'] = 'Transaction History';
  			//$data['users'] = $this->userModel->getAll();
  			//load contens into page
  			$this->load->view('templates/header', $data);
  			$this->load->view('TransactionHistory/index', $data);
  			$this->load->view('templates/footer');
      }

		}
		else
		{
			header('Location: /');
		}
	}

	/**
	 * handle find receipts request
	 */
	public function findReceipt()
	{
		$searchterm = $this->input->post('searchterm');

		$result =  $this->receiptModel->getMatchingReceipts($searchterm);

		//return json format
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	/**
	 * handle find receipts request
	 */
	public function findReceiptRange()
	{
		$dateForm = $this->input->post('datefrom');
		$dateTo = $this->input->post('dateto');

		$result = $this->receiptModel->getReceiptsWithinRange($dateForm, $dateTo);

		//return json format
		header('Content-Type: application/json');
		echo json_encode($result);
	}


	public function populateModal()
	{
			$receiptCode = $this->input->post('receiptcode');

			$result = $this->transactionModel->getTransactionDetails($receiptCode);

			//return json format
			header('Content-Type: application/json');
			echo json_encode($result);
	}

	public function printReport()
	{

		//set timezone
		if( ! ini_get('date.timezone') )
		{
				date_default_timezone_set('GMT');
		}

		//get data based on search condition
		$subTitle = ' ';
		if(!empty($this->input->get('datefrom')) && !empty($this->input->get('dateto')))
		{
			$dateForm = $this->input->get('datefrom');
			$dateTo = $this->input->get('dateto');

			$result = $this->receiptModel->getReceiptsWithinRange($dateForm, $dateTo);

			$subTitle = $dateForm . ' _ ' . $dateTo;

		}
		else if(!empty($this->input->get('searchterm'))) {
			$searchterm = $this->input->get('searchterm');
			$result = $this->receiptModel->getMatchingReceipts($searchterm);

			$subTitle = '';
		}

		ob_start();
  	$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  	// set document information
  	$pdf->SetCreator(PDF_CREATOR);
  	$pdf->SetAuthor('SPPM-PHP-SRS');
  	$pdf->SetTitle('Transaction History');
  	$pdf->SetSubject('Transaction History');
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
    $html .= '<h3 style="text-align:center">Order Transaction Report</h3>';
		$html .= '<h4 style="text-align:center">' . $subTitle . '</h4>';

		foreach ($result as $key => $item) {
			$html .= '<table>';
			$html .= 		'<tr>';
			$html .=			'<th width="20%"><strong>Staff:</strong> '. $item->username . '</th>';
			$html .=			'<th width="30%"><strong>Recipe Number:</strong> '. $item->receiptcode . '</th>';
			$html .=			'<th width="50%"><strong>Transaction Date:</strong> '. $item->transactiondate . '</th>';
			$html .= 		'</tr>';
			$html .= '</table>';
			$html .= '<table border="1">';
			$html .= 		'<tr>';
			$html .=			'<th><strong> Barcode</strong></th>';
			$html .=			'<th><strong> Brand</strong></th>';
			$html .=			'<th><strong> Product</strong></th>';
   		$html .=			'<th><strong> Price</strong></th>';
			$html .=			'<th><strong> Quantity</strong></th>';
			$html .=			'<th><strong> Total</strong></th>';
			$html .= 		'</tr>';

			//get sub data
			$subResult = $this->transactionModel->getTransactionDetails($item->receiptcode);
			$lTotal = 0;
			foreach ($subResult as $subKey => $subItem) {
				$subTotal = ($subItem->salesprice * $subItem->quantity);
				$html .= 		'<tr>';
				$html .=			'<td> ' . $subItem->barcode . '</td>';
				$html .=			'<td> ' . $subItem->brand . '</td>';
				$html .=			'<td> ' . $subItem->pname . '</td>';
				$html .=			'<td> ' . number_format($subItem->salesprice ,2,'.','') . '</td>';
				$html .=			'<td> ' . $subItem->quantity . '</td>';
				$html .=			'<td> ' . number_format($subTotal,2,'.','') . '</td>';
				$html .= 		'</tr>';
				$lTotal += $subTotal;
			}
			$html .= 		'<tr>';
			$html .= 			'<td></td>';
			$html .= 			'<td></td>';
			$html .= 			'<td></td>';
			$html .= 			'<td></td>';
			$html .= 			'<td><strong>Total:</strong></td>';
			$html .= 			'<td> ' . number_format($lTotal,2,'.','') . '</td>';
			$html .= 		'</tr>';

			$html .= '</table><br><br><br>';
		}


		$pdf->setPageMark();
		$pdf->writeHTML($html, true, false, false, false, '');

		// reset pointer to the last page
		$pdf->lastPage();

		// Close and output PDF document
		$lFileName =  date('d-m-Y'). "OrderTransaction.pdf";
		ob_end_clean();
		$pdf->Output($lFileName, 'D');
	}
}

?>
