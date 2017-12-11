<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->module('api/api_users');
	}

	public function index()
	{
		$name = ['Pintu Air'];
		$x 	= $this->global->get_group_by(
				'pintu_air',
				'measureDateTime',
				'measureDateTime',
				array('id'=>'DESC'),
				3)->result_array();

		$measureDateTime = [];
		foreach($x as $key) {
			$date = date_create($key['measureDateTime']);
			$measureDateTime[] = date_format($date, 'Y-m-d H:i');
		}

		$y	= $this->global->get_group_by(
				'pintu_air',
				'gaugeNameId, measureDateTime',
				'gaugeNameId',
				array('id'=>'DESC'),
				12)->result_array();

		$z 	= $this->global->get_group_by(
				'pintu_air',
				'gaugeNameId, depth',
				NULL,
				array('id'=>'DESC'),
				36)->result_array();

		$value = [];
		
		foreach($y as $key => $val) {
			$value[$key][] = $val['gaugeNameId'];
			foreach($z as $r) {
				if($val['gaugeNameId'] == $r['gaugeNameId']) {
					$value[$key][] = $r['depth'];
					// array_merge($value)
				}
			}
		}

		$data['tanggal'] = array_merge($name, $measureDateTime);
		$data['measureDateTime'] = $value;

		// print_r($data['measureDateTime'][0][0]);die();

		$data['pintu_air'] = $this->global->get_group_by(
								'pintu_air',
								'gaugeNameId, measureDateTime, warningNameId',
								NULL,
								array('id'=>'DESC'),
								12)->result_array();
		$this->template->set_layout('backend')
						->title('Home - Gentella')
						->build('v_home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/modules/welcome/controllers/Home.php */