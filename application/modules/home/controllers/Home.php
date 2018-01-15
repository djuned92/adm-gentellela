<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->is_login();
	}

	public function index()
	{
		$data['menus'] 	= $this->functions->generate_menu();
		$this->slice->view('v_home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/modules/welcome/controllers/Home.php */