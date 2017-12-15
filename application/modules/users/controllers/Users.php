<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->module('api/api_users');
		$this->load->library('curl');
	}

	public function index()
	{
		$url 			= base_url() .'api/api_users/get_all';
		$json 			= $this->curl->simple_get($url);
		$users 			= json_decode($json, TRUE);
		$data['users'] 	= $users['users'];

		
		$this->template->set_layout('backend')
						->title('Home - Gentella')
						->build('v_users', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gemder', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$this->api_users->add();
		} else {
			$this->template->set_layout('backend')
							->title('Home - Gentella')
							->build('f_users');	
		}
	}

	public function update()
	{
		$id 			= decode($this->uri->segment(3));
		$url 			= base_url() . 'api/api_users/get_by_id/' . $id;
		$user 			= json_decode($this->curl->simple_get($url), TRUE);
		$d['user'] 		= $user['user'];
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gemder', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$this->api_users->update();
		} else {
			$this->template->set_layout('backend')
							->title('Home - Gentella')
							->build('f_users', $d);	
		}	
		
	}

	public function delete()
	{
		$this->api_users->delete();
	}

}

/* End of file Users.php */
/* Location: ./application/modules/users/controllers/Users.php */