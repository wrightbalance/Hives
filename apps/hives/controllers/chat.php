<?php

class Chat extends CI_Controller
{
	private $user;
		
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('mongo_db');
		$this->load->model('chat_db');
		
		$this->user = $this->session->userdata('user');
	}
	
	function save_chat()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		checkSession();
		
		$sender 		= $this->input->post('sender');
		$id 			= $this->input->post('id');
		$msg			= $this->input->post('msg');

		// From Sender

		$db['from']  	= $sender;
		$db['to']		= $id;
		$db['message']  = trim($msg);
		$db['created']	= date('Y-m-d H:i:s');
		$db['status']	= 1;	
		$db['chattype']	= 1;

		$this->chat_db->saveChat($db);

		// To Sender
		
		$xdb['id']   	= $sender;
		$xdb['sender'] 	= $id;
		$xdb['created']	= date('Y-m-d H:i:s');
		$xdb['status']	= 1;
		$xdb['winstate'] = "max";
		
		$this->chat_db->saveChatBox($xdb);
		
		$ydb['id'] 		= $id;
		$ydb['sender']  = $sender;
		$ydb['created']	= date('Y-m-d H:i:s');
		$ydb['status']	= 1;
		$ydb['winstate'] = "max";
		
		$this->chat_db->saveChatBox($ydb);

		$data['response'] 	= 1;
		$data['json'] 		= $data;
		$this->load->view('ajax/json',$data);

	}
	
	
	function newmessage()
	{
		$sender 		= $this->input->post('sender');
		$id 			= $this->input->post('id');
		
		$db['sender']   = $sender;
		$db['id'] 		= $id;
		$db['created']	= date('Y-m-d H:i:s');
		$db['status']	= 1;
		
		$chatid = $this->chat_db->saveChatBox($db);
		
		$data['response'] 	= time();
		$data['chatid'] 	= $chatid;
		$data['json'] 		= $data;
		$this->load->view('ajax/json',$data);
	}
	
	
	function chatlog($fid = "",$tid = "")
	{

		$from_id =  $this->input->post('from_id');
		$id  	 =  $this->input->post('to_id');
		
		if(!$from_id) 
		{
			$from_id = $fid;
			$id		 = $tid;
		}	
		
		$db['from_id']  = $from_id;
		$db['id'] 		= $id;
		
		$this->chat_db->logChatBox($db);
		
		$cond = array(
			'id'		=>	(string)$id,
			'from_id'	=>	(string)$from_id
		);
		
		$chatboxes = $this->chat_db->getChatLog($cond);
		
		$data = array();
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	function boxAction()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$boxtitle = $this->input->post('boxid');
		$action	  = $this->input->post('action');
		
		if($action != "close")
		{
			$data['winstate'] = $action;
		}
		else
		{
			$data['status'] = 0;
		}
		
		$boxid = $this->mongo_db->mongoID($boxtitle);
		
		$cond = array('_id'=>$boxid);
		$this->chat_db->chatboxUpdate($cond,$data);
		
		$data['boxid'] = $cond;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function checkchatexist()
	{
		if(!$this->input->is_ajax_request()) exit();
		$data['exist'] = "false";
		
		$from =  $this->input->post('from');

		$chatboxes = $this->chat_db->getChatbox(array('id'=>(string)$this->user[0]['_id'],'sender'=>$from));
		
		if($chatboxes)
		{
			$data['exist'] = "true";
			
			$cond = array('sender'=>$from);
			$db['status'] = 1;
			$this->chat_db->chatboxUpdate($cond,$db);
		}
		
		$data['chatboxes'] = $chatboxes;
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	
}
