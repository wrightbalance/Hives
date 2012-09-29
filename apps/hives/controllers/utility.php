<?php

class Utility extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	
		$user = $this->session->userdata('user');
		
		if(!$user)
		{
			if($this->input->is_ajax_request())
				checkSession();
			else
				redirect();
		}
	}
	
	function setSidebar()
	{
		$toggle = $this->input->post('toggle');
		if($toggle == 1)
		{
			$data = array(
				'padding_zero'=>'padding_zero',
				'content_expand'=>'content_expand',
				'width34'=>'width34',
				'left200'=>'left200'
				);
			$this->session->set_userdata('sidebar',$data);
		}
		else
		{
			$this->session->unset_userdata('sidebar','');
		}
		
		
	}
	
	
}
