<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{

		$user = unserialize($this->session->userdata('user'));

		echo getphoto($user[0]['_id'],$size=50);
		exit();
	}
}
