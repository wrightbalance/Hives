<?php

class Uploader extends CI_Controller
{
	
	function index()
	{
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
					$data['response'] = "true";
					
					$targ_w = $targ_h = 150;
					$jpeg_quality = 90;

					$src = $targetFolder.'/'.$fileName;
					$src_dist = './photos/%d/'.$user[0]['vanity'].'.'.$ext;
					
					resizeimage($src, sprintf($src_dist,50),50,50,true);
					resizeimage($src, sprintf($src_dist,32),32,32,true);
					
					unlink($src);
					
				}
			} 
		}

		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
}
