<?php

class Users_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function save($db,$objid = "")
	{
		if(empty($objid))
		{
			$objid = $this->mongo_db->insert('users',$db);
		}
		else
		{
			$objid = $this->mongo_db->mongoID($objid);
			$this->mongo_db->where(array('_id'=>$objid))->set($db)->update('users');
		}
			
		return (string)$objid;
	}
	
	function getUser($cond)
	{
		//$select = array('id','nickname');
		$query = $this->mongo_db->where($cond)->get('users');
		
		return $query;
	}
	
	function _inc_id()
	{
		$id = $this->mongo_db->order_by(array('id'=>'desc'))->limit(1)->get('users');
		
		if($id)
			$id = (int)$id[0]['id'] + 1;
		else
			$id = 1;
		
		return $id;
	}
	
	function buddyList()
	{
		$user = unserialize($this->session->userdata('user'));
		$query = $this->mongo_db->where_ne('_id',$user[0]['_id'])->get('users');
		
		return $query;
	}
}
