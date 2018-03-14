<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges_user extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->is_login();
	}

	/**
	* function index priviliges user default role 1 = admin
	* @return view priviliges user
	*/
	public function index()
	{
		$this->functions->check_access($this->session->role_id, $this->uri->segment(1));
		$data['priv']		= $this->functions->check_priv($this->session->role_id, $this->uri->segment(1));
		$data['user_priv'] 	= $this->global->getCondJoin(
								'user_privileges as up','up.id as user_priv_id, up.priv_create, priv_read, priv_update, priv_delete, m.menu, m.level, m.menu_order',
								['role_id' => 1],
								['menus as m' => 'up.menu_id = m.id'],
								['m.menu_order','ASC'])->result_array();
		$this->slice->view('v_privileges_user', $data);				
	}

	/**
	* function group || role
	* @param role_id, get from session and encode role id
	* @return view group || role by role id
	*/
	public function group($role_id)
	{
		$role_id = decode($role_id);
		$data['user_priv'] 	= $this->global->getCondJoin(
								'user_privileges as up','up.id as user_priv_id, up.priv_create, priv_read, priv_update, priv_delete, m.menu, m.level, m.menu_order',
								['role_id' => $role_id],
								['menus as m' => 'up.menu_id = m.id'],
								['m.menu_order','ASC'])->result_array();
		$this->slice->view('v_privileges_user', $data);
	}

	/**
	* function check group
	* @return json error|url
	*/
	public function check_group()
	{
		$role_id = $this->input->post('role_id');
		if($role_id == 1) {
			$result['error'] 	= FALSE;
			$result['url'] 		= base_url() . 'privileges_user';
		} else {
			$result['error'] 	= FALSE;
			$result['url'] 		= base_url() . 'privileges_user/group/' .encode($role_id);
		}
		echo json_encode($result);
	}

	/**
	* function update priv
	* update priv_create, read, update, delete 0 or 1
	* @return json error|message
	*/
	public function update_priv()
	{
		$id 		= $this->input->post('id');
		$priv 		= $this->input->post('priv'); // value 0,1
		$priv_is 	= $this->input->post('priv_is'); // value priv_create, priv_create, priv_update, priv_delete 

		if($priv_is == 'priv_create') {
			$data_priv = [
				'priv_create'	=> $priv,
			];
		} elseif($priv_is == 'priv_read') {
			$data_priv = [
				'priv_read'		=> $priv,
			];
		} elseif($priv_is == 'priv_update') {
			$data_priv = [
				'priv_update'	=> $priv,
			];
		} else {
			$data_priv = [
				'priv_delete'	=> $priv,
			];
		}

		$this->global->update('user_privileges', $data_priv, ['id' => $id]);
		noted_log($data_priv, $id);

		$result['error'] 	= FALSE;
		$result['message']	= 'Update privileges user successed!';

		echo json_encode($result);

	}

	/**
	* function get roles
	* @return get all table roles
	*/
	public function get_roles()
	{
		if(!$this->input->is_ajax_request()) show_404();

		echo json_encode($this->global->get('roles','*',['created_at'=>'ASC'])->result_array());
	}
}

/* End of file Privileges_user.php */
/* Location: ./application/modules/privileges_user/controllers/Privileges_user.php */