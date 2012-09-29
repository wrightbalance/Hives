<?php

class Users extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('mongo_db');
		$this->load->model('users_db');
	}
	
	public function signin()
	{
		$this->form_validation->set_rules('username','User name','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] 	= $this->form_validation->_error_array;
			$data['action'] = "retry";
			
			$data['message']  = "";
			$data['message']  = "<div class=\"alert alert-error\">";
			$data['message'] .=	"<a class=\"close\" data-dismiss=\"alert\" onclick=\"return showForm()\">×</a>";
			$data['message'] .=	validation_errors();
			$data['message'] .=  "</div>";
		}
		else
		{
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			
			$user = $this->users_db->getUser(array('username'=>$username,'password'=>$password));
			
			$db['nickname'] = $user[0]['nickname'];
			$db['id'] = $user[0]['id'];
			$db['username'] = $user[0]['username'];
			
			$data['db'] = $db;
			$this->session->set_userdata('users',$db);
			
			$data['action'] = "retry";
			$data['url'] = site_url('refresh/'.uniqid());
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
		//exit();
	}
	
	public function register()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('username','User name','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('nickname','Nickname','required');
		
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$nickname = $this->input->post('nickname');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] 	= $this->form_validation->_error_array;
			$data['action'] = "retry";
			
			$data['message']  = "";
			$data['message']  = "<div class=\"alert alert-error\">";
			$data['message'] .=	"<a class=\"close\" data-dismiss=\"alert\" onclick=\"return showForm()\">×</a>";
			$data['message'] .=	validation_errors();
			$data['message'] .=  "</div>";
		}
		else
		{
			$db['username'] = $username;
			$db['password'] = $password;
			$db['nickname'] = $nickname;
			
			$id = $this->users_db->save($db);
			
			$db['id'] 	= $id;
			
			$this->session->set_userdata('users',$db);
			
			$data['action'] = "forward";
			$data['url'] = site_url();
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	function get_users($id)
	{
		$users = $this->users_db->getUser(array('id'=>(int)$id));
		
		print_r($users); exit();
	}
	
	function setStatus()
	{
		if(!$this->input->is_ajax_request()) exit();

		checkSession();

		$status = $this->input->post('status');
		$user = $this->session->userdata('user');
		$custom_status = $this->input->post('custom_status');
		
		$this->users_db->save(array('online_status'=>$status,'custom_status'=>$custom_status),(string)$user[0]['_id']);

		$data['users'] = $user;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
}
