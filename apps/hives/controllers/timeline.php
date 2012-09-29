<?php

class Timeline extends CI_Controller
{
	private $user;

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('mongo_db');
		$this->user = $this->session->userdata('user');
		$this->load->model('users_db');
		$this->load->model('timeline_db');
		
	}
	
	function post()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		checkSession();
		
		$type = $this->input->post('type');
		$data['action'] = "none";
		
		switch($type)
		{
			case 'status':
				$data['db'] = $this->_saveStatus();
				$data['action'] = "success";
				break;
			case 'share_photo':
				$data['db'] = $this->_sharePhoto();
				$data['action'] = "success";
				break;
		}
		
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
	
	function getDetails()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$tid = $this->input->post('tid');
		
		$timelineId = $this->mongo_db->mongoID($tid);
		
		$data['db'] = $this->timeline_db->getTimeline($timelineId);
		
		$data['tid'] = $timelineId;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}

	function _saveStatus()
	{
		$status = $this->input->post('status');	
		$userid = $this->input->post('id');
		
		$getUser 	= $this->users_db->getUser(array('_id'=>$this->mongo_db->mongoID($userid)));
		$user 		= $getUser[0];
		
		$photo		= "";
		
		if(isset($user['photo'])) 
		{
		
			if(isset($user['photo']))
			{
				if(file_exists('./upld/photo/'.$user['_id'].'/'.$user['photo'].'_32.jpg'))
				{
					$photo = resource_url('images/photo/'.$user['_id'].'/'.$user['photo']);
				}
			}
	
		} 
		
		$name = ucwords($user['firstname'].' '.$user['lastname']);
		
		$type = $this->input->post('type');
		
		$data['content'] 	= word_limiter($status,20,'...');
		$data['icon'] 		= 'ico-message';
		$data['label']		= 'Status Post';
		$data['det_up']		= '<a href="">'.$name.'</a> posted <a href="">new status message</a>';
		$data['comment']	= 0;
		$data['det_down']	= '';
		$data['photo']		= $photo;
		$data['type']		= $type;
		
		$tdb['type'] 		= $type;
		$tdb['id']			= $user['_id'];
		$tdb['comments'] 	= 0;
		$tdb['icon']		= 'ico-message';
		$tdb['label']		= 'Status Post';
		$tdb['content']		= $status;
		$tdb['created']		= date('Y-m-d H:i:s');
		
		$tid = $this->timeline_db->save($tdb);
		
		$data['tid'] = (string)$tid;
		
		return $data;
	}
	
	function _sharePhoto()
	{
		$status = $this->input->post('status');	
		$userid = $this->input->post('id');
		
		$getUser 	= $this->users_db->getUser(array('_id'=>$this->mongo_db->mongoID($userid)));
		$user 		= $getUser[0];
		$photo		= "";
		
		if(isset($user['photo'])) 
		{
		
			if(isset($user['photo']))
			{
				if(file_exists('./upld/photo/'.$user['_id'].'/'.$user['photo'].'_32.jpg'))
				{
					$photo = resource_url('images/photo/'.$user['_id'].'/'.$user['photo']);
				}
			}
	
		} 

		
		$name 				= ucwords($user['firstname'].' '.$user['lastname']);
		$share_photo		= $this->input->post('photo_filename');
		$type 				= $this->input->post('type');
		
		$data['content'] 	= '<img src="'.site_url('upld/share/thumb/'.$share_photo).'"/>';
		$data['icon'] 		= 'ico-photo';
		$data['label']		= '1 Photo';
		$data['det_up']		= word_limiter($status,5,'...');;
		$data['comment']	= 0;
		$data['det_down']	= '<a href="">'.$name.'</a>';
		$data['photo']		= $photo;
		$data['type']		= $type;
		
		$tdb['type'] 		= $type;
		$tdb['id']			= $user['_id'];
		$tdb['comments'] 	= 0;
		$tdb['icon']		= 'ico-photo';
		$tdb['label']		= '1 Photo';
		$tdb['content']		= $share_photo;
		$tdb['caption']		= $status;
		$tdb['created']		= date('Y-m-d H:i:s');
		
		$tid = $this->timeline_db->save($tdb);
		
		$data['tid'] = (string)$tid;
		
		return $data;
	}
	
	function getTimeline()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$tid = $this->input->post('tid');
		
		$timeline_id = $this->mongo_db->mongoID($tid);
	
		$timeline = $this->timeline_db->getTimeline($timeline_id);
		
		$data['db'] = $timeline[0];
		
		$data['timeline_id'] = $tid;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getForm()
	{
		$data['user'] = $this->user[0];
		$data['jsgroup'] = "timeline";
		$this->load->view('pane/timeline',$data);
	}
}
