<?

class Preferences extends CI_Controller
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
		$this->benchmark->mark('code_start');
		
		$data['buddys'] = $this->users_db->buddyList();

		if( !$data['sidebar'] = $this->cache->get('sidebar') )
		{
			$data['sidebar'] = $this->load->view('widget/sidebar',$data,true);
			$this->cache->save('sidebar',$data['sidebar'],7200);
		}
		
		$data['user'] = $this->user[0];
		$data['jsgroup'] = "preferences";
		
		$data['content'] = $this->load->view("pages/preferences",$data,true);
		$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		
		$this->load->vars($data);
		$this->load->view('default',$data);

		
		$this->minify->html();

	}
}
