<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// function get
		$data = $this->global->get('roles')->result_array();
		
		// function getCond 
		$data = $this->global->getCond('menus','*',
							// ['id'=>[8,9,20]]) // where_in
							['id'=>(object)['<', 9]]) // opreator <
							// ['menu'=>(object)['LIKE','Menu']]) // opreator LIKE
							// ['menu'=>'List User']) // where
							->result_array();
		
		// function getJoin
		$data = $this->global->getJoin(
								'users as u',
								'u.username, p.fullname, p.gender, p.address', 
								['profiles as p'=>'p.user_id = u.id'],
								['u.id'=>'ASC'])->result_array();
		
		// function getLastRecord
		// $data = $this->global->getLastRecord('menus')->row_array();
		
		dd($data);
	}
}
