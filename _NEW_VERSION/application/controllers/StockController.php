<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockController extends CI_Controller {

  //construction
	public function __construct()
	{
		parent::__construct();
	  $this->load->model('UserModel', 'userModel');
		$this->load->model('ProductModel', 'productModel');
		$this->load->library('session');
    $this->load->helper('url');
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
				//get all of stocks
				$data['pageTitles'] = 'Stock Management';
				$data['stocks'] = $this->productModel->getAll();
				//load contens into page
				$this->load->view('templates/header', $data);
				$this->load->view('Stock/index', $data);
				$this->load->view('templates/footer');
			}

		}
		else
		{
			header('Location: /');
		}
	}

	/**
	 * handle add request
	 */
	public function add()
	{
		$oProduct = new productModel();
		$oProduct->barcode = $this->input->post('barcode');
		$oProduct->pname = $this->input->post('pname');
		$oProduct->category = $this->input->post('category');
  	$oProduct->brand = $this->input->post('brand');
		$oProduct->description = $this->input->post('description');
    $oProduct->salesprice = $this->input->post('salesprice');
    $oProduct->quantity = $this->input->post('quantity');

		echo $this->productModel->add($oProduct);
	}

	/**
	 * handle update request
	 */
	public function update()
	{
		$oProduct = new productModel();
		$oProduct->pid = $this->input->post('pid');
    $oProduct->barcode = $this->input->post('barcode');
    $oProduct->pname = $this->input->post('pname');
    $oProduct->category = $this->input->post('category');
  	$oProduct->brand = $this->input->post('brand');
    $oProduct->description = $this->input->post('description');
    $oProduct->salesprice = $this->input->post('salesprice');
    $oProduct->quantity = $this->input->post('quantity');

		echo $this->productModel->update($oProduct);
	}

	/**
	 * handle delete request
	 */
	public function delete()
	{
		echo $this->productModel->delete($this->input->post('pid'));
	}


}
?>
