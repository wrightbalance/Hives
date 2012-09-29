<?php 

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('mongo_db');
	}
	
	function post()
	{
		
		$this->load->model('users_db');
		
		$this->form_validation->set_rules('email','E-mail','required|valid_email');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = $this->form_validation->_error_array;
			$data['action'] = "retry";
			$data['message'] = validation_errors();
		}
		else
		{
			$data['action'] = "reload";
			$data['url'] = site_url();
			
			$email = trim($this->input->post('email'));
			$password = trim(md5($this->input->post('password')));
			
			$cond = array('email'=>$email,'password'=>$password);
			
			$user = $this->users_db->getUser($cond);
			
			if($user)
			{
				$this->session->set_userdata('user',$user);
			}
			else
			{
				$data['error'] = array('email'=>'Not found','password'=>'notfound');
				$data['action'] = "retry";
				$data['message'] = "Email/password is invalid";
				
			}
				
		}
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function signout()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('users_db');
			$id = $this->input->post('sid');
			$this->users_db->save(array('online'=>0),$id);
		} 
		else
		{ 
			$this->load->model('users_db');
			$user = $this->session->userdata('user');
			$this->users_db->save(array('online'=>0),(string)$user[0]['_id']);
			
			$this->session->sess_destroy();
			
			redirect('');
		}
	}
}