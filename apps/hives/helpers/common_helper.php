<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

function theme()
{
    $ci =& get_instance();
    
    $currentTheme = $ci->config->item('ThemeName');
    
    return 'themes/'.$currentTheme.'/';
    
}

if ( ! function_exists('resource_url'))
{
    function resource_url($uri = '',$folder = '')
    {
        $CI =& get_instance();

        $url = config_item('css_url');

        if (!$url) $url = base_url();
		
		if(!$folder) $folder = 'resource_folder';
		
        return $url.config_item($folder).$uri;
    }
}

function phpStat_inet_aton($ip)
{
$chunks = explode('.', $ip);
return $chunks[0]*pow(256,3) + $chunks[1]*pow(256,2) + $chunks[2]*256 + $chunks[3];
}

if ( ! function_exists('url_friendly'))
{
	function url_friendly($url)
		{
			$url = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $url), '-'));
			return $url;
		}
}

if ( ! function_exists('clean_filename'))
{
	function clean_filename($url)
		{
			$url = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '', $url), ''));
			return $url;
		}
}



if ( ! function_exists('resizeimage')) 
{ 
    function resizeimage($oldfile, $newfile, $max_w, $max_h, $crop = true) {
        // Get Image Info
        list($org_w, $org_h, $org_t) = getimagesize($oldfile);
        switch($org_t) {
            case IMAGETYPE_GIF:
                $image    = imagecreatefromgif($oldfile);
                break;
            case IMAGETYPE_JPEG:
                $image    = imagecreatefromjpeg($oldfile);
                break;
            case IMAGETYPE_PNG:
                $image    = imagecreatefrompng($oldfile);
                break;
            default:
                $image    = imagecreatefromjpeg($oldfile);
        }

        // Resize Image
        $oldw    = $org_w;
        $oldh    = $org_h;
        $neww    = $max_w;
        $newh    = $max_h;
        
        if ($oldw > $neww || $oldh > $newh) {
            $ratio = ($neww / $newh);

            if ($crop) {
                if ($oldw > ($oldh * $ratio)) {
                    $curw    = $oldh * $ratio;
                    $curh    = $oldh;
                } else {
                    $curw    = $oldw;
                    $curh    = $oldw / $ratio;
                }
        
                $curx    = ($oldw - $curw) / 4;
                $cury    = ($oldh - $curh) / 3;

                $resize    = imagecreatetruecolor($neww, $newh);
                imagecopyresampled($resize, $image, 0, 0, $curx, $cury, $neww, $newh, $curw, $curh);
            } else {
                if ($oldw > ($oldh * $ratio)) {
                    $curw    = $neww;
                    $curh    = $neww * $oldh / $oldw;
                } else {
                    $curw    = $newh * $oldw / $oldh;
                    $curh    = $newh;
                }

                $resize    = imagecreatetruecolor($curw, $curh);
                imagecopyresampled($resize, $image, 0, 0, 0, 0, $curw, $curh, $oldw, $oldh);
            }
        } else {
            $resize        = $image;
        }
        imagejpeg($resize, $newfile, 100);
    }
}

if(!function_exists('imageblob_thumb'))
{
    function imageblob_thumb($fileblob,$file_type,$width = 90, $height = 90, $quality = 100, $border_radius = 5, $background_color = 'FFFFFF')
    {
        $thumb = createThumbnailFromBLOB($file_type, $width, $height, $fileblob, $quality, $border_radius, $background_color);

        return $thumb;
    }
}
if(!function_exists('createThumbnailFromBLOB'))
{
    function createThumbnailFromBLOB($file_type, $max_width, $max_height, $blob, $quality = 100, $border_radius = 0, $background_color = 'FFFFFF')
    {
            $thumb = cropResizeImage($file_type, $max_width, $max_height, $blob, $quality);
            //if ($border_radius > 0)
                //$thumb = $this->_imageRoundBorder($thumb, $max_width, $max_height, $border_radius, $background_color);

            ob_start();
            header("Content-type: {$file_type}");
            $expires = 60*60*24*365;
            header("Last-Modified: " . gmdate("M d Y H:i:s", time()) . " GMT");
            header("Pragma: public");
            header("Cache-Control: public, maxage=".$expires);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
            imagejpeg($thumb, null, $quality);
            ob_flush();
            die();
    }
}

function cropResizeImage($file_type, $max_width, $max_height, $blob, $quality) {
            $crop_height=$max_height;
            $crop_width=$max_width;
            // get originalsize of image
            $im             = imagecreatefromstring($blob);
            $original_width     = imagesx($im);
            $original_height     = imagesy($im);
            $original_image_gd    = $im;

            $cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
            ImageFill($cropped_image_gd, 1, 1, ImageColorAllocate($cropped_image_gd, 255, 255, 255));

            $wm = $original_width /$crop_width;
            $hm = $original_height /$crop_height;
            $h_height = $crop_height/2;
            $w_height = $crop_width/2;

            if($original_width > $original_height ) {
                $adjusted_width =$original_width / $hm;
                $half_width = $adjusted_width / 2;
                $int_width = $half_width - $w_height;
                imagecopyresampled($cropped_image_gd ,$original_image_gd ,-$int_width,0,0,0, $adjusted_width, $crop_height, $original_width , $original_height );
            }
            elseif(($original_width < $original_height ) || ($original_width == $original_height )) {
                $adjusted_height = $original_height / $wm;
                $half_height = $adjusted_height / 2;
                $int_height = $half_height - $h_height;
                imagecopyresampled($cropped_image_gd , $original_image_gd ,0,-$int_height,0,0, $crop_width, $adjusted_height, $original_width , $original_height );
            }
            else {
                imagecopyresampled($cropped_image_gd , $original_image_gd ,0,0,0,0, $crop_width, $crop_height, $original_width , $original_height );
            }

            return $cropped_image_gd;
    }
	
	function months()
	{
		$months = array(
					1 => 'Jan',
					2 => 'Feb',
					3 => 'Mar',
					4 => 'Apr',
					5 => 'May',
					6 => 'Jun',
					7 => 'Jul',
					8 => 'Aug',
					9 => 'Sep',
					10 => 'Oct',
					11 => 'Nov',
					12 => 'Dec',
					);
		
		return $months;
	}
	
	function month($m)
	{
		$months = array(
					1 => 'Jan',
					2 => 'Feb',
					3 => 'Mar',
					4 => 'Apr',
					5 => 'May',
					6 => 'Jun',
					7 => 'Jul',
					8 => 'Aug',
					9 => 'Sep',
					10 => 'Oct',
					11 => 'Nov',
					12 => 'Dec',
					);
		
		$month = element($m,$months);
		
		return $month;
	}
	
	function religion($r)
	{
			$religion = array(
						1 => 'Christianity - Catholic',
						2 => 'Christianity - Others',
						3 => 'Islam',
						4 => 'Other',
						);
			
			$religion = element($r,$religion);
			
			return $religion;
		}
		
	function ago($timestamp)
	{
		date_default_timezone_set('Asia/Manila');
		
		$difference = time() - strtotime($timestamp);
		$periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		for($j = 0; $difference >= $lengths[$j]; $j++)
		$difference /= $lengths[$j];
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
		$text = "$difference $periods[$j] ago";
			
		return $text;//date('Y-m-d H:i:s',strtotime($timestamp));
	}
		
	function resizeimage($oldfile, $newfile, $max_w = 50, $max_h = 50, $crop = true) {
		// Get Image Info
		list($org_w, $org_h, $org_t) = getimagesize($oldfile);
		switch($org_t) {
			case IMAGETYPE_GIF:
				$image	= imagecreatefromgif($oldfile);
				break;
			case IMAGETYPE_JPEG:
				$image	= imagecreatefromjpeg($oldfile);
				break;
			case IMAGETYPE_PNG:
				$image	= imagecreatefrompng($oldfile);
				break;
			default:
				$image	= imagecreatefromjpeg($oldfile);
		}

		// Resize Image
		$oldw	= $org_w;
		$oldh	= $org_h;
		$neww	= $max_w;
		$newh	= $max_h;
		
		if ($oldw > $neww || $oldh > $newh) {
			$ratio = ($neww / $newh);

			if ($crop) {
				if ($oldw > ($oldh * $ratio)) {
					$curw	= $oldh * $ratio;
					$curh	= $oldh;
				} else {
					$curw	= $oldw;
					$curh	= $oldw / $ratio;
				}
		
				$curx	= ($oldw - $curw) / 2;
				$cury	= ($oldh - $curh) / 2;

				$resize	= imagecreatetruecolor($neww, $newh);
				imagecopyresampled($resize, $image, 0, 0, $curx, $cury, $neww, $newh, $curw, $curh);
			} else {
				if ($oldw > ($oldh * $ratio)) {
					$curw	= $neww;
					$curh	= $neww * $oldh / $oldw;
				} else {
					$curw	= $newh * $oldw / $oldh;
					$curh	= $newh;
				}

				$resize	= imagecreatetruecolor($curw, $curh);
				imagecopyresampled($resize, $image, 0, 0, 0, 0, $curw, $curh, $oldw, $oldh);
			}
		} else {
			$resize		= $image;
		}
		imagejpeg($resize, $newfile, 100);
	}
	
	
	function json_exit($json)
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
		header("Cache-Control: no-cache, must-revalidate" ); 
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if (isset($json)) echo json_encode($json);
		exit;		
	}
	
	function checkSession()
	{
		$CI =& get_instance();
		
		$CI->load->library('session');
		
		$user = $CI->session->userdata('user');
		
		if(!$user)
		{
			$data['session'] = "false";
			$json = $data;
			
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
			header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
			header("Cache-Control: no-cache, must-revalidate" ); 
			header("Pragma: no-cache" );
			header("Content-type: text/x-json");
			if (isset($json)) echo json_encode($json);
			exit;
		}
	}
	
	function getphoto($id,$size=50)
	{
		$CI 	=& get_instance();
		$CI->load->library('mongo_db');
		$CI->load->model('users_db');
		
		$photo 	= false;
		$url 	= base_url();
		$folder = 'resource_photo';
		
		$user = $CI->users_db->getUser(array('_id'=>$id));

		if(isset($user[0]['photo']))
		{
			$filename = $user[0]['photo']['file'];
			$location = "./photos/$filename/%d/";
			$newfilename = $user[0]['photo']['file'].'.'.$user[0]['photo']['ext'];

			if(file_exists(sprintf($location,$size).$newfilename))
			{
				$photo = $url.config_item($folder).$filename.'/'.$size.'/'.$newfilename.'?'.$user[0]['photo']['updated'];
			}
			

		}
		return $photo;
	}
	
	function getshare($dir,$filename)
	{
		$folder = 'resource_photo';
		$url = base_url();
		
		return $url.config_item($folder).$dir.'/share/'.$filename;
	}
	
	function checkUrl($url)
	{
		$handle = curl_init($url);
		curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($handle);
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		
		$response = true;
		
		if($httpCode == 0)
		{
			$response = false;
		}
		
		return $response;
	}
