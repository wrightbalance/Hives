<?php

class Uploader extends CI_Controller
{
	
	function index()
	{
		$user		 		= $this->session->userdata('user');
		$targetFolder 		= "../upload";
		$data['response'] 	= "false";

		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

			$fileTypes = array('jpg','png','gif');
			
			$fileName 	= $_FILES['Filedata']['name'];
			$fileParts 	= pathinfo($fileName);
			
			if (in_array($fileParts['extension'],$fileTypes)) 
			{
				if(move_uploaded_file($tempFile,$targetFile))
				{
					$data['response'] = "true";
					
					$targ_w = $targ_h = 150;
					$jpeg_quality = 90;

					$src = $targetFolder.'/'.$fileName;
					$src_dist = '/photos/50/';
					
					resizeimage($src, $src_dist,50,50,true);
					
				}
			} 
		}

		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		exit();
	}
}
