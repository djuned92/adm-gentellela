<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// $this->load->view('welcome_message');
		
		// $data = $this->global->getJoin(
		// 						'users',
		// 						'*', 
		// 						['profiles as p'=>'p.user_id = users.id'],
		// 						['users.id'=>'ASC'])->result_array();
		// $data = $this->global->get(
		// 			'users',
		// 			'*', 
		// 			['username'=>(object)['LIKE','test2']])->result_array();
			$data = $this->global->getLastRecord('menus')->row_array();
		// $data = $this->global->getCond('pintu_air','*',['gaugeNameId'=>['Pasar Ikan','Waduk Pluit']])->result_array();
		// dd(decode('3IeCNQFaIBxnPlXABBb5VGUKzAV-A_DT_TsA3uG_83m-cvPkNc4dQZy1p-P_aPpJ2bS3_YRfIVtGz2aO4AzoSg~~'));
		dd($data);
		// $this->load->view('welcome_message');
	}

	public function _404()
	{
		$this->output->set_status_header('404');
        $this->load->view('errors/error_404');
	}
}
