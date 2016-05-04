<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AuthenticationController extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('UserModel', 'userModel');
      $this->load->library('session');
      $this->load->helper('url');
    }

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
            redirect(base_url('/report'), 'location');
          }
      }
      else
      {
          $this->load->view('Authentication/index');
      }
    }

    /**
     * handle login request
     */
    public function login()
    {
      $result = $this->userModel->authenticate($this->input->post('username'), $this->input->post('password'));

      if($result != false && password_verify($this->input->post('password'), $result->password))
      {
        //set session
        $this->session->set_userdata('loggedin', $result);

        //redirect
        if($result->role === "STAFF")
        {
          echo 1;
          //redirect(base_url('ordertransaction/index'), 'location');
        }
        else if($result->role === "MANAGER")
        {
          echo 2;
          //redirect(base_url('report/index'), 'location');
        }
      }
      else {
        echo 0;
      }
    }

    /**
     * handle logout request
     */
    public function logout()
    {
      $this->session->unset_userdata('loggedin');
      redirect('/', 'location');
    }

}
 ?>
