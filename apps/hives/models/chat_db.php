<?php

class Chat_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function saveChat($db)
	{
		$this->mongo_db->insert('chat',$db);
	}
	
	function saveChatBox($db)
	{
		$cond 	= array('sender'=>$db['sender'],'id'=>$db['id']);
		$query 	= $this->mongo_db->where($cond)->get('chatbox');
	
		if(!$query)
		{
			$id = $this->mongo_db->insert('chatbox',$db);
		}
		else
		{
			$id = (string)$query[0]['_id'];
		}
		
		return $id;
	}
	
	function getChatboxIDs($cond)
	{
		$chatboxes = $this->mongo_db->where($cond)->get('chatbox');
		$c = array();
		
		foreach($chatboxes as $k=>$v)
		{
			$c[] = $v['sender'];
		}
		
		return $c;
	}
	
	function getChatbox($cond)
	{
		$chatboxes = $this->mongo_db->where($cond)->get('chatbox');
		$chats		= array();
		
		$user = $this->session->userdata('user');
		
		foreach($chatboxes as $key=>$val)
		{
			//echo "<pre>";print_r($chatboxes); exit();
			$chat = array();
			
		
			$chat = $this->chatDetails($val['sender'],$val['id']);
			
			$chatboxname = $this->userDetails($this->mongo_db->mongoID($val['sender']));
			$chatboxname2 = $this->userDetails($this->mongo_db->mongoID($val['id']));
			
			
			
			$chats[] = array(
						'boxid'			=>  $val['_id'],
						'sender'		=>	$val['sender'],
						'id'			=>	$val['id'],
						'chatboxname'	=>	$chatboxname['firstname'].' '.$chatboxname['lastname'],
						'chatboxfname'	=>	ucwords($chatboxname2['firstname']),
						'winstate'		=>	$val['winstate'],
						'chat'			=> 	$chat,
						'photo'			=>	$chatboxname['photo'],
					);

		}
			
		return $chats;
	}
	
	function chatDetails($sender)
	{
		$user = $this->session->userdata('user');
		
		$cond 			= array('to'=>(string)$user[0]['_id'],'from'=>(string)$user[0]['_id']);
	
		$chatDetails 	= $this->mongo_db->or_where($cond)->get('chat');
		

		
		$chatmessages	= array();
		
		foreach($chatDetails as $key=>$val)
		{
			
			if($sender == $val['from'] || $sender == $val['to'])
			{
				$to = $val['from'];
				$suser = $this->userDetails($this->mongo_db->mongoID($to));
				
				$photo = "";
	
				if(isset($suser['photo']))
				{
					if(file_exists('./upld/photo/'.$suser['_id'].'/'.$suser['photo'].'_32.jpg'))
					{
						$photo = "<img src='".resource_url('images/photo/'.$suser['_id'].'/'.$suser['photo'].'_32.jpg')."'/>";
					}
				}
				
				$chatmessages[] = array(
								'from'			=> $val['from'],
								'to'			=> $val['to'],
								'sender_name' 	=> $suser['firstname'].' '.$suser['lastname'],
								'sender_id'		=> $suser['_id'],
								'message'		=> $val['message'],
								'loggedid'		=> (string)$user[0]['_id'],	
								'photo'			=> $suser['photo'],
								'photo2'		=> $photo
								);
			}
	
		}
		
		
		return $chatmessages;
	}
	
	
	function userDetails($id)
	{
		$user = $this->mongo_db->where(array('_id'=>$id))->get('users');
		
		return $user[0];
	}
	
	function chatboxUpdate($cond,$data)
	{
		$this->mongo_db->where($cond)->set($data)->update('chatbox');
	}
	

}
