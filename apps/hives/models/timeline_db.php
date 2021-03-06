<?php

class Timeline_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('users_db');
	}
	
	function save($data)
	{
		$tid = $this->mongo_db->insert('timeline',$data);
		
		return $tid;
	}
	
	function getTimeline($tid = "")
	{
		$get_user = false;
		$user_details = array();
		if(empty($tid))
		{
			$results = $this->mongo_db->order_by(array('_id'=>'DESC'))->offset(0)->limit(10)->get('timeline');
		}
		else
		{
			$results = $this->mongo_db->where(array('_id'=>$tid))->offset(0)->limit(10)->get('timeline');
			$get_user = true;
		}
		$timeline = array();
		
		foreach($results as $key=>$row)
		{
			
			$user 		= $this->users_db->getUser(array('_id'=>new MongoID($row['id'])));
			$name		= $user[0]['name'];
			$posted_by 	= $name['first'].' '.$name['last'];
			$caption = isset($row['caption']) ? $row['caption'] : '';
			$comments = array();
		
			$det_arr = array(
						'type'		=>	$row['type'],
						'posted'	=>	$posted_by,
						'content'	=>	$row['content'],
						'caption'	=>	$caption,
						);
			
			$det_content = $this->_belowTbar($det_arr);
			
			$size = 32;
			
			if($tid)
				$size = 50;
			
			if(!$photo = getphoto($row['id'],$size))
			{
				$photo = '';
			}
			
			if($row['comments'])
			{
				foreach($row['comments'] as $comment)
				{
					$comment_id  = new MongoID($comment['comment_id']);
					
					$comments[] = array(
						'id'	=> $comment['id'],
						'tid'	=> $row['id'],
						'comment' => $comment['comment'],
						'comment_by'=>$comment['comment_by'],
						'created' => $comment['created'],
						'photo' => getphoto($comment_id,32)
					);
				}
			}
			
			$timeline[] = array(
				'type' 			=> $row['type'],
				'content' 		=> $this->_content($row['type'],$row['content']),
				'fullcontent'	=> "<p>".nl2br($row['content'])."</p>",
				'description' 	=>  $caption,
				'comments' 		=> $comments,
				'comment_count' 		=> $row['comment_count'],
				'icon'			=> $row['icon'],
				'label'			=> $row['label'],
				'det_content'	=> $det_content,
				'_id'			=> $user[0]['_id'],
				'photo'			=> $photo,
				'tid'			=> $row['_id'],
				'user'			=> $user_details,
				'posted_by'		=> ucwords($posted_by),
				'share_photo' 	=> $row['type'] == "share_photo" ?  $row['content'] : '',
				'userid' 		=> (string)$user[0]['_id'],
				'caption'		=> $caption,
			);
		}
		
		return $timeline;
	}
	
	function _belowTbar($data)
	{
		$det_content = "";
		switch($data['type'])
		{
			case 'status':
				$det_content = '<p><a href="">'.ucwords($data['posted']).'</a> posted <a href="">new status message</a></p><p></p>';
				break;
			case 'share_photo':
				$det_content = '<p>'.character_limiter($data['caption'],40,'...').'</p>';
				$det_content .= '<p><a href="">'.ucwords($data['posted']).'</a></p>';
				break;
		}
		
		return $det_content;
	}
	
	function _content($type,$cont)
	{
		$content = "";
		
		switch($type)
		{
			case 'status':
				$content = "<p>".character_limiter($cont,80,'...')."<p>";
				break;
			case 'share_photo':
				$content = "<img src='".$cont."' alt=\"\"/>";
				break;
										
		}
		
		return $content;
	}
	
	function comment_save($db,$id)
	{
		$id = new MongoID($id);
		$this->mongo_db->where(array('_id'=>$id))->inc(array('comment_count'=>1))->update('timeline');
		
		$query = $this->mongo_db->where(array('_id'=>$id))->get('timeline');
		$row = $query[0];
		$db['id'] = $id.'_'.$row['comment_count'];
		
		$this->mongo_db->where(array('_id'=>$id))->push('comments',$db)->update('timeline');

		
		return $db['id'] ;
		
	}
}
