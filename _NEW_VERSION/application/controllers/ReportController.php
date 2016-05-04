<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportController extends CI_Controller {

  //construction
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
		$this->load->model('ProductModel', 'productModel');
		$this->load->model('ReceiptModel', 'receiptModel');
		$this->load->library('session');
    $this->load->helper('url');
		$this->load->library('Graph');
		$this->load->library('SortedGraph');
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
				$data['pageTitles'] = 'Report';
				//$data['users'] = $this->userModel->getAll();
				//load contens into page
				$this->load->view('templates/header', $data);
				$this->load->view('Report/index', $data);
				$this->load->view('templates/footer');
		  }
		}
		else
		{
			header('Location: /');
		}
	}

	/**
	 * handle get all stock quantity request
	 */
	public function getStockQuantity()
	{
		$result = $this->productModel->getAllStockQuantity();
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	/**
	 * handle get statistical data
	 */
	 public function getStatisticalData()
	 {

			$lDateFrom = $this->input->post('datefrom');
			$lDateTo = $this->input->post('dateto');

			/* Perform Query */
			$result = $this->receiptModel->findTransactionDetails($lDateFrom, $lDateTo);

			if($result)
			{

				foreach ($result as $row)
				{
				   	$lGraphData[] = new Graph($row['pname'], $row['date'], $row['quantity']);
				}

				$lSortedGraphData = new SortedGraph($lGraphData);
				$lRangedGraphData = array();
				$lProductNames = array();
				//echo $lSortedGraphData;
				foreach($lSortedGraphData as $key => $lSingleItem)
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
		 }

		if( count($lProductNames) )
		{
			// Send the results back to the client
			echo json_encode( array("data" => $lRangedGraphData, "labels" => $lProductNames) );
		}
	 }

	 public function downloadCSVFile()
	 {
			 //set timezone
			 if( ! ini_get('date.timezone') )
			 {
					 date_default_timezone_set('GMT');
			 }
			// http://code.stephenmorley.org/php/creating-downloadable-csv-files/
			$filename = date('d-m-Y')."-StockLevels.csv";

			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename='.$filename);


			/* Perform Query */
		  $result = $this->productModel->getAllStockQuantity();

		  if($result)
		  {
		  	// Open file pointer connected to the output stream
		  	$output = fopen('php://output', 'w');

		  	// output the column headings
		  	fputcsv($output, array('Product', 'Stock Level', 'Brand', 'Category', 'Barcode', 'Price'));

				foreach ($result as $index=>$item)
				{
					fputcsv($output, array($item->pname, $item->stockamount, $item->brand, $item->category, $item->barcode, $item->salesprice));
				}
		  }

	 }




}
?>
