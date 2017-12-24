<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges_user extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$data['user_priv'] 	= $this->global->getCondJoin(
								'user_privileges as up','up.id as user_priv_id, up.priv_create, priv_read, priv_update, priv_delete, m.menu, m.level, m.menu_order',
								['role_id' => 1],
								['menus as m' => 'up.menu_id = m.id'],
								['m.menu_order','ASC'])->result_array();
		$data['menus'] 		= $this->functions->generate_menu();
		$this->template->set_layout('backend')
						->title('Privileges User - Gentella')
						->build('v_privileges_user', $data);				
	}

	public function group($role_id)
	{
		$role_id = decode($role_id);
		$data['user_priv'] 	= $this->global->getCondJoin(
								'user_privileges as up','up.id as user_priv_id, up.priv_create, priv_read, priv_update, priv_delete, m.menu, m.level, m.menu_order',
								['role_id' => $role_id],
								['menus as m' => 'up.menu_id = m.id'],
								['m.menu_order','ASC'])->result_array();
		$data['menus'] 		= $this->functions->generate_menu();
		$this->template->set_layout('backend')
						->title('Privileges User - Gentella')
						->build('v_privileges_user', $data);
	}

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
		
		$result['error'] 	= FALSE;
		$result['message']	= 'Update privileges user successed!';

		echo json_encode($result);

	}

	public function get_roles()
	{
		if(!$this->input->is_ajax_request()) show_404();

		echo json_encode($this->global->get('roles','*',['created_at'=>'ASC'])->result_array());
	}
}

/* End of file Privileges_user.php */
/* Location: ./application/modules/privileges_user/controllers/Privileges_user.php */