<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_global extends CI_Model {

	/**
	* set condition
	* @param cond array
	* @return this
	*/
	private function _condition($cond)
	{
		if(!is_array($cond))
            return $this;
        
        if(!count($cond))
            return $this;
        
        foreach($cond as $field => $value){
            if(is_array($value)){
                $this->db->where_in("`$field`", $value);
                
            }elseif(is_object($value)){
                $value = (array)$value;
                $operator = $value[0];
                $wildcard = array_key_exists(2, $value) ? $value[2] : 'both';
                $value = $value[1];
                
                if(in_array($operator, array('>', '<', '!=', '=', '>=', '<=', 'IS NOT', 'IS')))
                    $this->db->where("`$field` $operator", $value);
                elseif($operator == 'LIKE')
                    $this->db->like("`$field`", $value, $wildcard);
                elseif($operator == 'NOT LIKE')
                    $this->db->not_like("`$field`", $value, $wildcard);
                elseif($operator == 'IN')
                    $this->db->where_in("`$field`", $value);
                elseif($operator == 'NOT IN')
                    $this->db->where_not_in("`$field`", $value);  
            }else{
                $this->db->where("`$field`", $value);   
            }
        }
        return $this;
	}

	/**
	* set condition left join
	* @param cond array 
	* @param type_join default left join
	* @return this 
	*/
	private function _condJoinLeft($cond, $type_join = 'LEFT')
	{
		foreach ($cond as $field => $value) {
			$this->db->join($field, $value, $type_join);
		}
		return $this;
	}

	/**
	* set order by
	* @param orderBy array
	* @return this
	*/
	private function _orderBy($orderBy) 
	{
        foreach($orderBy as $field => $ord) {
            $this->db->order_by($field, $ord);
        }

        return $this;
	}

	/**
	* get table
	* @param table, name table from db
	* @param field, set field for show, default *
	* @param orderBy, set order by table field DESC or ASC, default table.id DESC
	* @return get all record table
	*/
	public function get($table, $field = FALSE, $orderBy = FALSE)
	{
		if(!$orderBy) {
			$this->db->order_by("`$table`.`id`",'DESC');
		} else {
			$this->_orderBy($orderBy);
		}

		if(!$field) {
			$this->db->select('*');
		} else {
			$this->db->select($field);
		}

		return $this->db->get($table);
	}

	/**
	* get all record table where condition
	* @param table, name table from db
	* @param field, set field for show, default *
	* @param cond, condition array
	* @param orderBy, set order by table field DESC or ASC, default table.id DESC
	* @return get all record table
	*/
	public function getCond($table, $field = FALSE, $cond = FALSE, $orderBy = FALSE)
	{
		$this->_condition($cond);
		
		if(!$orderBy) {
			$this->db->order_by("`$table`.`id`",'DESC');
		} else {
			$this->_orderBy($orderBy);
		}

		if(!$field) {
			$this->db->select('*');
		} else {
			$this->db->select($field);
		}

		return $this->db->get($table);
	}

	/**
	* get record left join table
	* @param table, name table from db
	* @param field, set field for show, default *
	* @param condJoinLeft, condition join left array
	* @param orderBy, set order by table field DESC or ASC, default table.id DESC
	* @return get all record table
	*/
	public function getJoin($table, $field = FALSE, $condJoinLeft = FALSE, $orderBy = FALSE)
	{
		$this->_condJoinLeft($condJoinLeft);
		
		if(!$orderBy) {
			$this->db->order_by("`$table`.`id`",'DESC');
		} else {
			$this->_orderBy($orderBy);
		}

		if(!$field) {
			$this->db->select('*');
		} else {
			$this->db->select($field);
		}
		
		return $this->db->get($table);
	}

	/**
	* get record join table where condition
	* @param table, name table from db
	* @param field, set field for show, default *
	* @param cond, condition array
	* @param condJoinLeft, condition join left array
	* @param orderBy, set order by table field DESC or ASC, default table.id DESC
	* @return get all record table
	*/
	public function getCondJoin($table, $field = FALSE, $cond = FALSE, $condJoinLeft = FALSE, $orderBy = FALSE)
	{
		$this->_condition($cond);
		$this->_condJoinLeft($condJoinLeft);
		
		if(!$orderBy) {
			$this->db->order_by("`$table`.`id`",'DESC');
		} else {
			$this->_orderBy($orderBy);
		}

		if(!$field) {
			$this->db->select('*');
		} else {
			$this->db->select($field);
		}
		
		return $this->db->get($table);
	}

	/**
	* get record join table where condition
	* @param table, name table from db
	* @param orderBy, set order by table field DESC or ASC, default table.id DESC field must name id and auto increment
	* @return get last record table
	*/
	public function getLastRecord($table, $orderBy = FALSE, $limit = 1)
	{
		if(!$orderBy) {
			$this->db->order_by("`$table`.`id`",'DESC');
		} else {
			$this->_orderBy($orderBy);
		}

		$this->db->limit(1);

		return $this->db->get($table);
	}

	/**
	* create new data
	* @param table, name table from db
	* @param data, data array  for a new row to insert
	* @param last_id, default false if need last record id set TRUE
	* @return create a new data
	*/
	public function create($table, $data, $last_id = FALSE) 
	{
		$this->db->insert($table, $data);
		
		if($last_id = TRUE) {
			return $this->db->insert_id();
		} else {
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}

	}

	/**
	* create new multiple data
	* @param table, name table from db
	* @param data, data array  for a multiple row to insert
	* @return create a new multiple data
	*/
	public function create_batch($table, $data)
	{
		$this->db->insert_batch($table, $data);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	/**
	* update spesific data
	* @param table, name table from db
	* @param data, data array  for a update row to insert
	* @param id, array for update spesific data
	* @return update spesific data
	*/
	public function update($table, $data, $id)
	{
		$this->db->update($table, $data, $id);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	/**
	* delete spesific data
	* @param table, name table from db
	* @param id, array for delete spesific data
	* @return delete spesific data
	*/
	public function delete($table, $id)
	{
		$this->db->delete($table, $id);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
}

/* End of file M_global.php */
/* Location: ./application/models/M_global.php */