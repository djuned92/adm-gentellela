<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_auth','auth');
		$this->load->module('api/api_users');
	}

	public function index()
	{	
		$this->load->view('v_login');
	}

	public function add()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');	
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');	
		
		if ($this->form_validation->run() == FALSE) {
			$result['error'] 	= TRUE;
			$result['message'] 	= validation_errors();
		} else {
			$this->api_users->add();
		}
	}
	
	public function do_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			$result['error'] 	= TRUE;
			$result['message'] 	= validation_errors();
		} else {
			$this->m_auth->login();
		}
	}

	public function do_logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}

/* End of file Auth.php */
/* Location: ./application/modules/auth/controllers/Auth.php */