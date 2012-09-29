<?php


class Mini extends CI_Controller {

	public function css($id)
	{
		$this->minify->outputByGroup('css',$id);
	}
	
	public function js($id)
	{
		$this->minify->outputByGroup('js',$id);
	}
}

