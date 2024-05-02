<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class M_auth extends CI_Model {

	public function check_login($username)
	{
		$query = $this->db->get_where('users', array('username'=>$username));
		
		if($query->num_rows() > 0)
            $result = $query->row_array();
        else
            $result = array();

        return $result;

	}

	public function dd($username)
	{
		$query = $this->db->get_where('users', array('username'=>$usernamee));

        return $query->num_rows() > 0 ? $query->row_array() : [];
	}
}

/* End of file M_auth.php */
/* Location: ./application/modules/auth/models/M_auth.php */