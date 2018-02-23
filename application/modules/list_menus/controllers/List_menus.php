<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_menus extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->is_login();
		$this->load->model('m_menus');
	}

	/**
	* function index menus
	* @return view menus
	*/
	public function index()
	{
		$this->functions->check_access($this->session->role_id, $this->uri->segment(1)); // access read
		$data['priv']		= $this->functions->check_priv($this->session->role_id, $this->uri->segment(1)); // for button show and hide

		$data['list_menus'] = $this->global->getJoin(
							'menus as m','m.*, m1.menu as menu_parent',
							['menus as m1' => 'm.parent = m1.id'],
							['menu_order'=> 'ASC'])->result_array();
		$this->slice->view('v_list_menus', $data);
	}

	/**
	* function add menus
	* create row menus and create rows user privileges as much record roles
	* @return json, error|type|message
	*/
	public function add()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2)); // access add, update, delete		
		$this->form_validation->set_rules('menu', 'Menu', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data['list_menus'] = $this->m_menus->get_all();
			$this->slice->view('f_list_menus', $data);
		} else {
			$this->db->trans_begin();
			
			$value = [
				'menu'			=> $this->input->post('menu'),
				'parent'		=> $this->input->post('parent'),
				'link'			=> $this->input->post('link'),
				'is_published'	=> 1,
				'menu_order'	=> $this->input->post('menu_order'),
				'created_at'	=> date('Y-m-d H:i:s'),
			];

			$parent = $this->input->post('parent');

			if($parent == 0) {
				$value['level'] = 0; 
				$value['icon'] 	= $this->input->post('icon'); 
			} else {
				$value['level'] = $this->m_menus->get_level_menu($parent);
				$value['icon']	= NULL;
			}

			$data_menu = $value;

			$menu_id = $this->global->create('menus', $data_menu, TRUE);
			$roles = $this->global->get('roles')->result_array();
			$data_user_priv = [];
			foreach($roles as $key => $value) {
				$rows['role_id'] 		= $value['id'];
				$rows['menu_id'] 		= $menu_id;
				$rows['priv_create'] 	= ($value['id'] == 1) ? 1 : 0;
				$rows['priv_read'] 		= ($value['id'] == 1) ? 1 : 0;
				$rows['priv_update'] 	= ($value['id'] == 1) ? 1 : 0;
				$rows['priv_delete'] 	= ($value['id'] == 1) ? 1 : 0;
				$rows['created_at']		= date('Y-m-d H:i:s');

				$data_user_priv[] = $rows;
			}

			$this->global->create_batch('user_privileges', $data_user_priv);
			$activity = array_merge($data_menu, $data_user_priv);
			noted_log($activity);

			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Menu fail to created!';
	        } else {
	        	$this->db->trans_commit();
				$result['error']	= FALSE;
				$result['type']		= 'success';
				$result['message']	= 'Menu success to created!';
	        }
			echo json_encode($result);
		}
	}

	/**
	* function update menus
	* update row menus
	* @return json, error|type|message
	*/
	public function update()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2)); // access add, update, delete

		$this->form_validation->set_rules('menu', 'Menu', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$id 				= decode($this->uri->segment(3));
			$data['list_menus'] = $this->m_menus->get_all();
			$data['menu'] 		= $this->global->getCond('menus', '*', ['id' => $id])->row_array();
			(isset($data['menu'])) ? $data['menu'] : show_404();
			$this->slice->view('f_list_menus', $data);
		} else {
			$this->db->trans_begin();
			
			$value = [
				'menu'			=> $this->input->post('menu'),
				'parent'		=> $this->input->post('parent'),
				'link'			=> $this->input->post('link'),
				'is_published'	=> 1,
				'menu_order'	=> $this->input->post('menu_order'),
			];

			$parent = $this->input->post('parent');

			if($parent == 0) {
				$value['level'] = 0; 
				$value['icon'] 	= $this->input->post('icon'); 
			} else {
				$value['level'] = $this->m_menus->get_level_menu($parent);
				$value['icon']	= NULL;
			}

			$data_menu = $value;
			$id = decode($this->input->post('id'));

			$this->global->update('menus', $data_menu, ['id' => $id]);
			noted_log($data_menu, $id);

			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Menu fail to updated!';
	        } else {
	        	$this->db->trans_commit();
				$result['error']	= FALSE;
				$result['type']		= 'success';
				$result['message']	= 'Menu success to upated!';
	        }
			echo json_encode($result);	
		}
	}

	/**
	* function update field is published
	* update field is published on table menus
	* @return json, error|type|message
	*/
	public function update_is_published() 
	{
		$id 	= decode($this->input->post('id'));
		$data_menu = [
			'is_published'	=> $this->input->post('is_published'),
		];

		$this->global->update('menus', $data_menu, array('id' => $id));
		noted_log($data_menu, $id);

		$result['error']	= FALSE;
		$result['type']		= 'success';
		$result['message']	= 'Menu has been updated!';

		echo json_encode($result);
	}

	/**
	* function delete menus
	* delete row menus and delete rows user privileges where menu_id
	* @return json, error|type|message
	*/
	public function delete()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2)); // access add, update, delete

		$id 				= decode($this->input->post('id'));
		$menus 				= $this->global->getCond('menus','*',['id'=>$id])->row_array();
		$user_privileges 	= $this->global->getCond('user_privileges','*',['menu_id'=>$id])->row_array();
		$activity = array_merge($menus, $user_privileges);
		noted_log($activity, $id);

		if($id != NULL || $id != '') {
			$result['error']	= FALSE;
			$result['type']		= 'success';
			$result['message']	= 'Menu has been deleted!';
			$this->global->delete('menus', array('id' => $id));
			$this->global->delete('user_privileges', array('menu_id' => $id));
		} else {
			$result['error']	= TRUE;
			$result['type']		= 'success';
			$result['message']	= 'Menu fail to delete!';	
		}
		echo json_encode($result);
	}
}

/* End of file Menus.php */
/* Location: ./application/modules/menus/controllers/Menus.php */