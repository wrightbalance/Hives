<?

class Contacts extends CI_Controller
{
	private $user;
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('mongo_db');
		$this->load->model('users_db');
		$this->load->model('chat_db');
		$this->load->model('timeline_db');
		
		$this->user = $this->session->userdata('user');
		
		$this->load->driver('cache',array('adapter'=>'memcached','backup'=>'file'));
	}
	
	public function index()
	{
		$this->benchmark->mark('code_start');
		
		$chat			= $this->chat_db->getChatbox(array('id'=>(string)$this->user[0]['_id'],'status'=>1));
			
		$user = $this->users_db->getUser(array('_id'=>$this->user[0]['_id']));
		$this->users_db->save(array('online'=>1),(string)$this->user[0]['_id']);
	
		$data['user'] 	= $user[0];

		$data['buddys'] = $this->users_db->buddyList();
		$data['timelines'] = $this->timeline_db->getTimeline();
		
		if($chat)
		{
			$data['chatbox'] 	= $chat;
			$data['chatboxids'] = $this->chat_db->getChatboxIDs(array('id'=>(string)$this->user[0]['_id'],'status'=>1));
		}
		
		if( !$data['sidebar'] = $this->cache->get('sidebar') )
			{
				$data['sidebar'] = $this->load->view('widget/sidebar',$data,true);
				$this->cache->save('sidebar',$data['sidebar'],7200);
			}
		$data['content'] = $this->load->view("pages/contacts",$data,true);
		$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		
		$this->load->vars($data);
		$this->load->view('default',$data);
		
		
		$this->minify->html();

	}
}
