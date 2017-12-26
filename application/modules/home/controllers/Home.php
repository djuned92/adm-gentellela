<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->is_login();
		$this->load->module('api/api_users');
	}

	public function index()
	{
		$data['menus'] 	= $this->functions->generate_menu();
		$data['active'] = TRUE;
		// dd($data); 
		$data['pintu_air'] = []; 
		$this->template->set_layout('backend')
						->title('Home - Gentella')
						->build('v_home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/modules/welcome/controllers/Home.php */