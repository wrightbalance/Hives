<?php

class Main extends CI_Controller
{
	private $user;
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('mongo_db');
		$this->load->model('users_db');
		$this->load->model('chat_db');
		$this->load->model('timeline_db');
		
		$user_session = $this->session->userdata('user');
		$this->user = unserialize($user_session);
		$this->load->driver('cache',array('adapter'=>'memcached','backup'=>'file'));
	
	}
	
	public function index()
	{
		
		if(isset($this->user[0]))
		{	
			
			$data['buddys'] = $this->users_db->buddyList();
	
			if( !$data['sidebar'] = $this->cache->get('sidebar') )
			{
				$data['sidebar'] = $this->load->view('widget/sidebar',$data,true);
				$this->cache->save('sidebar',$data['sidebar'],7200);
			}
			
			$data['user'] = $this->user[0];
			
			$data['content'] = $this->load->view("pages/home",$data,true);
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			
			$this->load->vars($data);
			$this->load->view('default',$data);
		}
		else
		{
			$data['title'] = "Hives ® | Social Group Collaboration  | www.joinhives.com";
			$data['jsgroup'] = "main";
			$data['cssgroup'] = "main";
			$data['content'] = $this->load->view('pages/register',$data,true);
			
			
			$this->load->view('pages/main',$data);
		}
			
		
       $this->minify->html();

        

	}
	
	function login()
	{
		$data['title'] = "Hives ® | Social Group Collaboration  | www.joinhives.com";
		$data['jsgroup'] = "main";
		$data['cssgroup'] = "main";
		
		if($this->input->is_ajax_request())
		{
			$this->load->view('pages/login',$data);
		}
		else
		{
			$data['content'] = $this->load->view('pages/login',$data,true);
			$this->load->view('pages/main',$data);
		}
	}
	
	function demo($passkey)
	{
		if(empty($passkey))
		{
			redirect();
		}
		else
		{
			if($passkey == "out")
			{
				$this->session->unset_userdata('demo','');
			}
			
			if($passkey == "ilovehives")
			{
				$this->session->set_userdata('demo',1);
				redirect('');
			}
			else
			{
				redirect('');
			}
		}
	}
	
	function refresh($id)
	{
		sleep(2);
		redirect();
	}

	function test()
	{
		//echo 'test';
		$this->load->driver('cache',array('adapter'=>'memcached'));
		
		$this->cache->save('foo','vars',10);
		
		echo $this->cache->get('foo');
		
		//var_dump($this->cache->memcached->is_supported());
		exit();
	}
	
}
