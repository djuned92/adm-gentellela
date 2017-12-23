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
		// print_r($this->functions->generate_menu());
		dd($this->functions->generate_menu());
		// $this->load->view('welcome_message');
	}

	public function _404()
	{
		$this->output->set_status_header('404');
        $this->load->view('errors/error_404');
	}

	public function asd()
	{
		$options = [
		    'cost' => 11,
		    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		$password_hash = password_hash('123', PASSWORD_BCRYPT, $options);
		// $password_hash = encode(123);
		$password_verify = password_verify('1234','$2y$11$OQxAxMsCKp3NAr4bQH0B.uXe7zpWxUJrGQnHEqtrdXaDDU//UHSyW');
		dd($password_verify);
	}
}
