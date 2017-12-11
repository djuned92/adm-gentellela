<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_auth extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');
		$device_token = $this->input->post('device_token');
		$user 		= $this->global->check_login($username);
		
		if(!empty($user)) {
			if(password_verify($password, $user['password'])) {
				// set session
				$sess_data = [
					'logged_in' => TRUE,
					'id'		=> $user['id'],
					'username'	=> $user['username'],
					'device_token' => $device_token,
				];
				$this->session->set_userdata($sess_data);

				// update last login
				$data['last_login'] = date('Y-m-d H:i:s');
				$data['device_token'] = ($device_token != null) ? $device_token : NULL;
				(isset($user['id'])) ? $this->global->update('users', $data, array('id'=> $user['id'])) : '';

				$result['code']  	= 200;
				$result['error'] 	= FALSE;
				$result['user']  	= $sess_data;
			} else {
				$result['code'] 	= 400;
				$result['error'] 	= TRUE;
				$result['message'] 	= 'Wrong password';
			}
		} else {
			$result['code'] 	= 404;
			$result['error'] 	= TRUE;
			$result['message']	= 'User not found';
		}

		echo json_encode($result);
	}

	public function logout()
	{
		$id 		= $this->input->post('id');
		$username 	= $this->input->post('username');

		$user = $this->global->check_login($username);
		
		if($id != NULL) {
			// update last login
			$data['last_login'] 	= date('Y-m-d H:i:s');
			$data['device_token'] 	= NULL;
			(isset($user['id'])) ? $this->global->update('users', $data, array('id'=> $user['id'])) : '';

			$result['code']  	= 200;
			$result['error'] 	= FALSE;
			$result['message']  = 'Success Logout';
		}

		echo json_encode($result);
	}
}

/* End of file Api_auth.php */
/* Location: ./application/modules/api/controllers/Api_auth.php */