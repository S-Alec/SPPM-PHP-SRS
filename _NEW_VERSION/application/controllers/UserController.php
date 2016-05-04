<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

  //construction
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
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
				//get all of users
				$data['pageTitles'] = 'User Management';
				$data['users'] = $this->userModel->getAll();
				//load contens into page
				$this->load->view('templates/header', $data);
				$this->load->view('User/index', $data);
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
		$oUser = new userModel();
		$oUser->username = $this->input->post('username');
		$oUser->password = $this->input->post('password');
		$oUser->lname = $this->input->post('lname');
		$oUser->role = $this->input->post('role');

		echo $this->userModel->add($oUser);
	}

	/**
	 * handle update request
	 */
	public function update()
	{
		$oUser = new userModel();
		$oUser->uid = $this->input->post('uid');
		$oUser->username = $this->input->post('username');
		$oUser->password = $this->input->post('password');
		$oUser->lname = $this->input->post('lname');
		$oUser->role = $this->input->post('role');

		echo $this->userModel->update($oUser);
	}

	/**
	 * handle delete request
	 */
	public function delete()
	{
		echo $this->userModel->delete($this->input->post('uid'));
	}


}
?>
