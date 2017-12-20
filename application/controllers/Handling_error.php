<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handling_error extends CI_Controller {

	/**
	* custom error 404
	*/
	public function _404()
	{
		$this->output->set_status_header('404');
        $this->load->view('errors/error_404');
	}

}

/* End of file Handling_error.php */
/* Location: ./application/controllers/Handling_error.php */