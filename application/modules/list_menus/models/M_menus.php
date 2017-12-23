<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menus extends CI_Model {

	public function get_level_menu($parent)
	{
		$result = $this->db->get_where('menus',['id' => $parent])->row_array();
		
		return $result['level'] + 1;
	}

	public function get_all()
	{
		$this->db->select('id, menu as text');
        $this->db->from('menus');
        $this->db->order_by('menu_order','ASC');

        $no_parent = array('id' => '0', 'text' => 'No Parent / Root Menu');
        $result = $this->db->get()->result_array();
        array_unshift($result, $no_parent);

        return json_encode($result);
	}
}

/* End of file M_menus.php */
/* Location: ./application/modules/menus/models/M_menus.php */