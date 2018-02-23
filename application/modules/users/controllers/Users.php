<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->is_login();
	}

	public function index()
	{
		$this->functions->check_access($this->session->role_id, $this->uri->segment(1)); // access read
		$data['priv']		= $this->functions->check_priv($this->session->role_id, $this->uri->segment(1)); // for button show and hide
		
		$data['users'] 	= $this->global->getJoin('profiles','*',['users'=>'users.id = profiles.user_id'])->result_array();
		$this->slice->view('v_users', $data);
	}

	public function add()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2));
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gemder', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->slice->view('f_users',$data);
		} else {
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
				'role_id'	=> 2,
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
			$activity = array_merge($data, $data_profile);
			noted_log($activity);
			
			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'Failed registered!';
	        } else {
	        	$this->db->trans_commit();
				$result['error']	= FALSE;
				$result['type']		= 'success';
				$result['message']	= 'Success registered!';
	        }
	        echo json_encode($result);	
		}
	}

	public function update()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2)); // access add, update, delete
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gemder', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$id 			= decode($this->uri->segment(3));
			$data['user'] 	= $this->global->getCondJoin('profiles','*',['profiles.user_id'=> $id],['users'=>'users.id = profiles.user_id'])->row_array();
			(isset($data['user'])) ? $data['user'] : show_404();
			$this->slice->view('f_users', $data);	
		} else {
			$this->db->trans_begin();

			$id_user 	= decode($this->input->post('id'));
			$username 	= $this->input->post('username');
			$password 	= $this->input->post('password');

			if(!is_null($password)) {
				$options = [
				    'cost' => 11,
				    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				];
				$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
				
				$data_user = [
					'username'	=> $username,
					'password'	=> $password_hash,
				];

				$this->global->update('users', $data_user, array('id' => $id_user));
			} elseif(!is_null($username)) {
				$data_user = [
					'username'	=> $username,
				];

				$this->global->update('users', $data_user, array('id' => $id_user));
			} else {
				$options = [
				    'cost' => 11,
				    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				];
				$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
				
				$data_user = [
					'username'	=> $username,
					'password'	=> $password_hash,
				];

				$this->global->update('users', $data_user, array('id' => $id_user));
			}
			
			$data_profile = [
				'fullname'	=> $this->input->post('fullname'),
				'address'	=> $this->input->post('address'),
				'phone'		=> $this->input->post('phone'),
				'gender'	=> $this->input->post('gender'),
				'created_at'=> date('Y-m-d H:i:s'),
			];

			$this->global->update('profiles', $data_profile, array('user_id' => $id_user));
			$activity = array_merge($data_user, $data_profile);
			noted_log($activity, $id_user);

			if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
				$result['error']	= TRUE;
				$result['type']		= 'error';
				$result['message']	= 'User failed to updated!';
	        } else {
	        	$this->db->trans_commit();
				$result['error']	= FALSE;
				$result['type']		= 'success';
				$result['message']	= 'User has been updated!';
	        }
			echo json_encode($result);
		}	
		
	}

	public function delete()
	{
		$this->functions->check_access2($this->session->role_id, $this->uri->segment(1), $this->uri->segment(2)); // access add, update, delete
		
		$id = decode($this->input->post('id'));
		$activity = $this->global->getCondJoin('profiles','*',
								['profiles.user_id'=> $id],
								['users'=>'users.id = profiles.user_id'])
								->row_array();
		noted_log($activity, $id);

		if($id != NULL || $id != '') {
			$result['error']	= FALSE;
			$result['type']		= 'success';
			$result['message']	= 'User has been deleted!';
			$this->global->delete('users', array('id' => $id));
			$this->global->delete('profiles', array('user_id' => $id));
		} else {
			$result['error']	= TRUE;
			$result['type']		= 'error';
			$result['message']	= 'User fail to delete!';	
		}
		echo json_encode($result);
	}

}

/* End of file Users.php */
/* Location: ./application/modules/users/controllers/Users.php */