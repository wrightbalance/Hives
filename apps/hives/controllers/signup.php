<?php

class Signup extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('mongo_db');
	}
	
	function post()
	{
		if(!$this->input->is_ajax_request());
		$this->load->model('users_db');
		
		$this->form_validation->set_rules('firstname','First Name','required');
		$this->form_validation->set_rules('lastname','Last Name','required');
		$this->form_validation->set_rules('gender','Gender','required');
		$this->form_validation->set_rules('email','E-mail','required|valid_email');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = $this->form_validation->_error_array;
			$data['action'] = "retry";
			$this->form_validation->set_error_delimiters('<p class="cerror">','</p>');
			$data['message'] = validation_errors();
		}
		else
		{
			
			$first 				= trim(ucwords($this->input->post('firstname')));
			$last				= trim(ucwords($this->input->post('lastname')));
			
			$db['email'] 		= trim($this->input->post('email'));
			$db['password'] 	= trim(md5($this->input->post('password')));
			$db['name'] 		= array('first'=>$first,'last'=>$last); 
			$db['gender'] 		= trim($this->input->post('gender'));
			$db['created'] 		= date('Y-m-d H:i:s');
			$db['updated'] 		= date('Y-m-d H:i:s');
			$db['last_ip'] 		= $this->input->ip_address();
			$db['online']		= 1;
			$db['online_status'] = 'online';
			$db['custom_status'] = '';
			$db['vanity']		= url_friendly(strtolower($first.'-'.$last.'-'.uniqid()));
			
			$objid = $this->users_db->save($db);
			
			$db['id'] = $objid;
			
			$user = array($db);
			
			$this->session->set_userdata('user',serialize($user));
			
			$data['action'] = "reload";
			$data['url'] = site_url();
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
}
