<?php 
	$this->output->set_header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
	$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	$this->output->set_header('Pragma: no-cache');
	$this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>

<?php if(!isset($title)) $title = config_item('site_title')?>
<?php if(!isset($description)) $description = "";?>
<?php if(!isset($keyword)) $keyword = "";?>
<?php if(!isset($author)) $author = "";?>

<!DOCTYPE html>
        <head>
        <meta charset="utf-8">
        
        <title><?=$title?></title>  
		
        <meta name="description" content="<?=$description?>">
        <meta name="keywords" content="<?=$keyword?>">
        <meta name="author" content="<?=$author?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="/favicon.png" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        
        <?php
            if(!isset($cssgroup)) $cssgroup = "default";
            
            $links = array(
                'href'=>site_url("mini/css/{$cssgroup}/".mtime('css',$cssgroup)).".css",
                'rel'=>'stylesheet',
            );
            echo link_tag($links);
        ?>
  
    </head>
