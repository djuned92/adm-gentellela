<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_user extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->is_login();
	}

	/**
	* function index group user
	* @return view group_user
	*/
	public function index()
	{
		$this->functions->check_access($this->session->role_id, $this->uri->segment(1)); // access read
		$data['priv']		= $this->functions->check_priv($this->session->role_id, $this->uri->segment(1)); // for button show and hide
		
		$data['group_user'] = $this->global->get('roles')->result_array();
		$this->slice->view('v_group_user', $data);
	}

	/**
	* function add roles
	* create row roles and create rows user privileges as much record menus
	* @return json, error|type|message
	*/
	public function add()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2));
		$this->form_validation->set_rules('role', 'Roles', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->slice->view('f_group_user', $data);
		} else {
			$this->db->trans_begin();
			
			$data_roles = [
				'role'		=> $this->input->post('role'),
				'created_at'=> date('Y-m-d H:i:s'),
			]; 

			$role_id 	= $this->global->create('roles', $data_roles, TRUE);
			$menus 		= $this->global->get('menus')->result_array();
			$data_user_priv = [];
			foreach($menus as $key => $value) {
				$rows['role_id'] 		= $role_id;
				$rows['menu_id'] 		= $value['id'];
				$rows['priv_create'] 	= ($role_id == 1) ? 1 : 0;
				$rows['priv_read'] 		= ($role_id == 1) ? 1 : 0;
				$rows['priv_update'] 	= ($role_id == 1) ? 1 : 0;
				$rows['priv_delete'] 	= ($role_id == 1) ? 1 : 0;
				$rows['created_at']		= date('Y-m-d H:i:s');

				$data_user_priv[] = $rows;
			}

			$this->global->create_batch('user_privileges', $data_user_priv);
			$activity = array_merge($data_roles, $data_user_priv);
			noted_log($activity);

			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Role fail to created!';
	        } else {
	        	$this->db->trans_commit();
				$result['error']	= FALSE;
				$result['type']		= 'success';
				$result['message']	= 'Role success to created!';
	        }
			echo json_encode($result);
		}
	}

	/**
	* function update roles
	* update row roles
	* @return json, error|type|message
	*/
	public function update()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2));
		$this->form_validation->set_rules('role', 'Roles', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$id 				= decode($this->uri->segment(3));
			$data['role'] 		= $this->global->getCond('roles', '*', ['id' => $id])->row_array();
			(isset($data['role'])) ? $data['role'] : show_404();

			$this->slice->view('f_group_user', $data);
		} else {
			$this->db->trans_begin();
			
			$data_roles = [
				'role'	=> $this->input->post('role'),
			];
			$id = decode($this->input->post('id'));

			$this->global->update('roles', $data_roles, ['id' => $id]);
			noted_log($data_roles, $id);

			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Role fail to updated!';
	        } else {
	        	$this->db->trans_commit();
				$result['error']	= FALSE;
				$result['type']		= 'success';
				$result['message']	= 'Role success to upated!';
	        }
			echo json_encode($result);	
		}
	}

	/**
	* function delete roles
	* delete row roles
	* @return json, error|type|message
	*/
	public function delete()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2));
		
		$id = decode($this->input->post('id'));
		$activity = $this->global->getCond('roles','*',['id'=>$id])->row_array();
		noted_log($activity, $id);

		if($id != NULL || $id != '') {
			$result['error']	= FALSE;
			$result['type']		= 'success';
			$result['message']	= 'Role has been deleted!';
			$this->global->delete('roles', array('id' => $id));
			$this->global->delete('user_privileges', array('role_id' => $id));
		} else {
			$result['error']	= TRUE;
			$result['type']		= 'success';
			$result['message']	= 'Role fail to delete!';	
		}
		echo json_encode($result);
	}

}

/* End of file Group_user.php */
/* Location: ./application/modules/group_user/controllerls/Group_user.php */