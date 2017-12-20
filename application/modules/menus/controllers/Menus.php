<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_menus','menus');
	}

	/**
	* function index menus
	* @return view menus
	*/
	public function index()
	{
		$data['menus'] = $this->global->getJoin(
							'menus as m','m.*, m1.menu as menu_parent',
							['menus as m1' => 'm.parent = m1.id'],
							['id'=> 'ASC'])->result_array();
		$this->template->set_layout('backend')
						->title('Menus - Gentella')
						->build('v_menus', $data);
	}

	/**
	* function add menus
	* create row menus and create rows user privileges as much record roles
	* @return json, code|error|type|message
	*/
	public function add()
	{
		$this->form_validation->set_rules('menu', 'Menu', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$d['menus'] = $this->menus->get_all();
			$this->template->set_layout('backend')
							->title('Add Menu - Gentella')
							->build('f_menus', $d);
		} else {
			$this->db->trans_begin();
			
			$value = [
				'menu'			=> $this->input->post('menu'),
				'parent'		=> $this->input->post('parent'),
				'link'			=> $this->input->post('link'),
				'is_published'	=> 1,
				'menu_order'	=> $this->input->post('menu_order'),
				'icon'			=> $this->input->post('icon'),
			];

			$parent = $this->input->post('parent');

			if($parent == '' || $parent == 0) {
				$value['level'] = 0; 
			} else {
				$value['level'] = $this->menus->get_level_menu($parent);
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

			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['code']		= 501;
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Menu fail to created!';
	        } else {
	        	$this->db->trans_commit();
				$result['code']		= 200;
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
	* @return json, code|error|type|message
	*/
	public function update()
	{
		$this->form_validation->set_rules('menu', 'Menu', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$id 		= decode($this->uri->segment(3));
			$d['menus'] = $this->menus->get_all();
			$d['menu'] 	= $this->global->getCond('menus', '*', ['id' => $id])->row_array();
			$this->template->set_layout('backend')
							->title('Update Menu - Gentella')
							->build('f_menus', $d);
		} else {
			$this->db->trans_begin();
			
			$value = [
				'menu'			=> $this->input->post('menu'),
				'parent'		=> $this->input->post('parent'),
				'link'			=> $this->input->post('link'),
				'is_published'	=> 1,
				'menu_order'	=> $this->input->post('menu_order'),
				'icon'			=> $this->input->post('icon'),
			];

			$parent = $this->input->post('parent');

			if($parent == '' || $parent == 0) {
				$value['level'] = 0; 
			} else {
				$value['level'] = $this->menus->get_level_menu($parent);
			}

			$data_menu = $value;
			$id = decode($this->input->post('id'));

			$this->global->update('menus', $data_menu, ['id' => $id]);
			// print_r($this->db->last_query());die();
			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['code']		= 501;
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Menu fail to updated!';
	        } else {
	        	$this->db->trans_commit();
				$result['code']		= 200;
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
	* @return json, code|error|type|message
	*/
	public function update_is_published() 
	{
		$id 	= decode($this->input->post('id'));
		$data_menu = [
			'is_published'	=> $this->input->post('is_published'),
		];

		$this->global->update('menus', $data_menu, array('id' => $id));

		$result['code'] 	= 200;
		$result['error']	= FALSE;
		$result['type']		= 'success';
		$result['message']	= 'Menus has been updated!';

		echo json_encode($result);
	}

	/**
	* function delete menus
	* delete row menus and delete rows user privileges where menu_id
	* @return json, code|error|type|message
	*/
	public function delete()
	{
		$id = decode($this->input->post('id'));

		if($id != NULL || $id != '') {
			$result['code'] 	= 200;
			$result['error']	= FALSE;
			$result['type']		= 'success';
			$result['message']	= 'Menu has been deleted!';
			$this->global->delete('menus', array('id' => $id));
			$this->global->delete('user_privileges', array('menu_id' => $id));
		} else {
			$result['code'] 	= 404;
			$result['error']	= TRUE;
			$result['type']		= 'success';
			$result['message']	= 'Menu fail to delete!';	
		}
		echo json_encode($result);
	}
}

/* End of file Menus.php */
/* Location: ./application/modules/menus/controllers/Menus.php */