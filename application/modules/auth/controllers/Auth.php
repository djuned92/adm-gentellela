<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_auth','auth');
		$this->load->module('api/api_auth');
	}

	public function index()
	{	
		$this->load->view('v_login');
	}

	/*
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
	*/
	
	public function do_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			$result['error'] 	= TRUE;
			$result['message'] 	= validation_errors();
		} else {
			$username 	= $this->input->post('username');
			$password 	= $this->input->post('password');
			// $device_token = $this->input->post('device_token');
			$user 		= $this->auth->check_login($username);
			
			if(!empty($user)) {
				if(password_verify($password, $user['password'])) {
					// set session
					$sess_data = [
						'logged_in' => TRUE,
						'role_id'	=> $user['role_id'],
						'id'		=> $user['id'],
						'username'	=> $user['username'],
						'redirect_back' => $_SERVER['HTTP_REFERER'],
						// 'device_token' => $device_token,
					];
					$this->session->set_userdata($sess_data);

					// update last login
					$data['last_login'] = date('Y-m-d H:i:s');
					// $data['device_token'] = ($device_token != null) ? $device_token : NULL;
					(isset($user['id'])) ? $this->global->update('users', $data, array('id'=> $user['id'])) : '';

					$result['error'] 	= FALSE;
					$result['user']  	= $sess_data;
				} else {
					$result['error'] 	= TRUE;
					$result['message'] 	= 'Wrong password';
				}
			} else {
				$result['error'] 	= TRUE;
				$result['message']	= 'User not found';
			}
			echo json_encode($result);
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