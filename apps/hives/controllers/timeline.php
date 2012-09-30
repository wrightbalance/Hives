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
			case 'photo':
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
		$user = unserialize($this->session->userdata('user'));
		
		$photo		= "";
		
		if(getphoto($user[0]['_id'],32) !== false)
		{
			$photo = getphoto($user[0]['_id'],32);
		}
		
		$uname = $user[0]['name'];
		
		$name = ucwords($uname['first'].' '.$uname['last']);
		
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
		$tdb['id']			= $user[0]['_id'];
		$tdb['comment_count'] 	= 0;
		$tdb['comments'] 	= array();
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
		$user = unserialize($this->session->userdata('user'));

		$photo		= "";

		if(getphoto($user[0]['_id'],32) !== false)
		{
			$photo = getphoto($user[0]['_id'],32);
		}
		
		$uname = $user[0]['name'];
		
		$name = ucwords($uname['first'].' '.$uname['last']);

		$filename		= $this->input->post('filename');
		$type 				= $this->input->post('type');
		
		$content =  getshare($user[0]['vanity'],$filename);
		
		$data['content'] 	= "<img src='".$content."' width=\"272\" height=\"135\"/>";
		$data['icon'] 		= 'ico-photo';
		$data['label']		= '1 Photo';
		$data['det_up']		= word_limiter($status,5,'...');;
		$data['comment']	= 0;
		$data['det_down']	= '<a href="">'.$name.'</a>';
		$data['photo']		= $photo;
		$data['type']		= 'share_photo';
		
		$tdb['type'] 		= 'share_photo';
		$tdb['id']			= $user[0]['_id'];
		$tdb['comment_count'] 	= 0;
		$tdb['comments'] 	= array();
		$tdb['icon']		= 'ico-photo';
		$tdb['label']		= '1 Photo';
		$tdb['content']		= $content;
		$tdb['caption']		= $status;
		$tdb['created']		= date('Y-m-d H:i:s');
		
		$tid = $this->timeline_db->save($tdb);
		
		$data['tid'] = (string)$tid;
		
		return $data;
	}
	
	function upload_share_photo()
	{
		$this->load->library('mongo_db');
		
		$user_sess		 	= $this->session->userdata('user');
		$user				= unserialize($user_sess);	
		$targetFolder 		= "../upload";
		$data['response'] 	= "false";

		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

			$fileTypes = array('jpg','png','gif');
			
			$fileName 	= $_FILES['Filedata']['name'];
			$fileParts 	= pathinfo($fileName);
			$ext		= $fileParts['extension'];
			
			if (in_array($fileParts['extension'],$fileTypes)) 
			{
				if(move_uploaded_file($tempFile,$targetFile))
				{
					$vanity = $user[0]['vanity'];
					$data['response'] = "true";
					
					if(!is_dir('./photos/'.$vanity))
					{
						mkdir('./photos/'.$vanity.'/share',0777,true);
					}
					else
					{
						if(!is_dir('./photos/'.$vanity.'/share'))
						{
							mkdir('./photos/'.$vanity.'/share',0777,true);
						}
					}
					
					$src = $targetFolder.'/'.$fileName;
					$fname = md5(uniqid()).'.'.$ext;
					
					$src_dist = './photos/'.$vanity.'/share/'.$fname;
					
					$data['fileparts'] = $fileParts;
					$data['filename'] = $fname;
					
					resizeimage($src,$src_dist,800,600,false);
	
					
					unlink($src);
					
				}
			} 
		}

		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
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
	
	function getAllTimeline()
	{
		if(!$this->input->is_ajax_request()) exit();
	
		$timeline = $this->timeline_db->getTimeline();
		
		$data['db'] = $timeline;

		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getForm()
	{
		$data['user'] = $this->user[0];
		$data['jsgroup'] = "timeline";
		$this->load->view('pane/timeline',$data);
	}
	
	function comment()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$tid = trim($this->input->post('tid'));
		$db['comment'] = trim($this->input->post('comment'));
		$db['comment_by'] = $this->input->post('comment_by');
		$db['comment_id'] = $this->input->post('comment_id');
		$db['created']	= date('Y-m-d H:i:s');
		
		$comment_id = $this->timeline_db->comment_save($db,$tid);
		
		$data['tid'] = $tid;
		$data['comment_id'] = $comment_id;
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
	
	function delete_comment()
	{
		$tid = $this->input->post('tid');
		$cid = $this->input->post('comment_id');
		
		$this->mongo_db->pull('comments',array('id'=>(string)$cid))->update('timeline');
		
		
		
	}
}
