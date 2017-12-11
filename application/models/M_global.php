<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_global extends CI_Model {

	public function fetch($table, $select = NULL, $join = NULL, $where = NULL, $order_by = NULL, $limit = NULL)
	{
		if($select !== NULL) {
			$this->db->select($select);
		}

		if($join !== NULL) {
			foreach ($join as $key => $value) {
				$this->db->join($key, $value);
			}		
		}

		if($where !== NULL) {
			$this->db->where($where);
		}

		if($order_by !== NULL) {
			foreach ($order_by as $key => $value) {
				$this->db->order_by($key, $value);
			}	
		}

		if($limit != NULL) {
			$this->db->limit($limit);
		}

		return $this->db->get($table);
	}

	public function get_limit($table, $select = NULL, $limit = NULL, $start = NULL, $where = NULL)
	{
		if($select != NULL) {
			$this->db->select($select);
		}

		if($limit != NULL) {
			$this->db->limit($limit);
		}

		if($limit != NULL && $start != NULL) {
			$this->db->limit($limit, $start);
		}

		if($where != NULL) {
			$this->db->where($where);
		}

		return $this->db->get($table);
	}

	public function get_last_record($table, $limit = NULL, $order_by = NULL)
	{
		if($limit != NULL) {
			$this->db->limit($limit);
		}

		if($order_by !== NULL) {
			foreach ($order_by as $key => $value) {
				$this->db->order_by($key, $value);
			}	
		}

		return $this->db->get($table);
	}

	public function get_group_by($table, $select = NULL, $group_by = NULL, $order_by = NULL, $limit = NULL)
	{
		if($select !== NULL) {
			$this->db->select($select);
		}

		if($group_by !== NULL) {
			$this->db->group_by($group_by);
		}

		if($order_by !== NULL) {
			foreach ($order_by as $key => $value) {
				$this->db->order_by($key, $value);
			}	
		}

		if($limit !== NULL) {
			$this->db->limit($limit);
		}

		return $this->db->get($table);
	}

	public function add($table, $data, $last_id = FALSE) 
	{
		$this->db->insert($table, $data);
		if($last_id)
			return $this->db->insert_id();
	}

	public function add_batch($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}

	public function update($table, $data, $id)
	{
		$this->db->update($table, $data, $id);
	}

	public function delete($table, $id)
	{
		$this->db->delete($table, $id);
	}

	public function check_login($username)
	{
		$query = $this->db->get_where('users', array('username'=>$username));
		
		if($query->num_rows() > 0)
            $result = $query->row_array();
        else
            $result = array();

        return $result;

	}
}

/* End of file M_global.php */
/* Location: ./application/models/M_global.php */