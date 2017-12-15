<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_users extends MX_Controller {

	public function get_all()
	{
		$users =  $this->global->getJoin('profiles','*',['users'=>'users.id = profiles.user_id']);		
		
		if($users->num_rows() > 0) {
			$result['code'] 	= 200;
			$result['error']	= FALSE;
			$result['message']	= 'Success';
			$result['users'] 	= $users->result_array();
		} else {
			$result['code'] 	= 204;
			$result['error']	= FALSE;
			$result['message']	= 'No content users';
		}
		echo json_encode($result, JSON_NUMERIC_CHECK);	
	}

	public function get_by_id($id)
	{
		$user = $this->global->getCondJoin('profiles','*',['profiles.user_id'=> $id],['users'=>'users.id = profiles.user_id']);
		
		if($user->num_rows() > 0) {
			$result['code'] 	= 200;
			$result['error']	= FALSE;
			$result['message']	= 'Success';
			$result['user'] 	= $user->row_array();
		} else {
			$result['code'] 	= 404;
			$result['error']	= TRUE;
			$result['message']	= 'Not found user';
		}
		echo json_encode($result, JSON_NUMERIC_CHECK); 
	}

	public function add()
	{
		$this->db->trans_begin();
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$options = [
		    'cost' => 11,
		    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
		
		$data = [
			'username'	=> $username,
			'password'	=> $password_hash,
			'role'		=> 2,
			'created_at'=> date('Y-m-d H:i:s'),
		];

		$user_id = $this->global->create('users', $data, TRUE);

		$data_profile = [
			'user_id'	=> $user_id,
			'fullname'	=> $this->input->post('fullname'),
			'address'	=> $this->input->post('address'),
			'phone'		=> $this->input->post('phone'),
			'gender'	=> $this->input->post('gender'),
			'created_at'=> date('Y-m-d H:i:s'),
		];

		$this->global->create('profiles', $data_profile);
		
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['code']		= 501;
			$result['error']	= FALSE;
			$result['message']	= 'Failed registered!';
        } else {
        	$this->db->trans_commit();
			$result['code']		= 200;
			$result['error']	= FALSE;
			$result['message']	= 'Success registered!';
        }

		echo json_encode($result);		
	}

	public function update()
	{
		$this->db->trans_begin();

		$id_user 	= decode($this->input->post('id'));
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');

		// print_r($_POST);
		if($password != NULL) {
			$options = [
			    'cost' => 11,
			    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
			];
			$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
			
			$data = [
				'username'	=> $username,
				'password'	=> $password_hash,
			];

			$this->global->update('users', $data, array('id' => $id_user));
		}
		
		$data_profile = [
			'fullname'	=> $this->input->post('fullname'),
			'address'	=> $this->input->post('address'),
			'phone'		=> $this->input->post('phone'),
			'gender'	=> $this->input->post('gender'),
			'created_at'=> date('Y-m-d H:i:s'),
		];

		$this->global->update('profiles', $data_profile, array('user_id' => $id_user));

		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['code']		= 501;
			$result['error']	= FALSE;
			$result['message']	= 'User failed to updated!';
        } else {
        	$this->db->trans_commit();
			$result['code'] 	= 200;
			$result['error']	= FALSE;
			$result['message']	= 'User has been updated!';
        }

		echo json_encode($result);
	}

	public function delete()
	{
		$id = decode($this->input->post('id'));

		if($id != NULL || $id != '') {
			$result['code'] 	= 200;
			$result['error']	= FALSE;
			$result['message']	= 'User has been deleted!';
			$this->global->delete('users', array('id' => $id));
			$this->global->delete('profiles', array('user_id' => $id));
			$this->global->delete('user_pintu_air', array('user_id' => $id));
		} else {
			$result['code'] 	= 404;
			$result['error']	= TRUE;
			$result['message']	= 'User fail to delete!';	
		}
		echo json_encode($result);
	}
}

/* End of file Api_user.php */
/* Location: ./application/modules/api/controllers/Api_user.php */