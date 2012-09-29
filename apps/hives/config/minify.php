<?php defined('BASEPATH') OR exit('No direct script access allowed');  

$config['resource_folder'] = 'resources/hives/';

$config['expires'] = 60*60*24*14;
$config['html_expires'] = 0;

$config['css']['default'] = array(
     array('path'=>'css/','file'=>'lb.css')
    ,array('path'=>'css/','file'=>'bootstrap.css')
    ,array('path'=>'css/','file'=>'uploadifive.css')
    ,array('path'=>'css/','file'=>'style.css')
    ,array('path'=>'css/','file'=>'responsive.css')
    ,array('path'=>'css/','file'=>'crop.lib.css')
    );
    
$config['css']['main'] = array(
    array('path'=>'css/','file'=>'style.main.css'),
    );
    
$config['css']['demo'] = array(
    array('path'=>'css/','file'=>'demo.css'),
    );
    
$config['js']['default'] = array(
     array('path'=>'js/','file'=>'html.js')
    ,array('path'=>'js/','file'=>'bootstrap.min.js')
    ,array('path'=>'js/','file'=>'jquery.lionbars.0.3.js')
    ,array('path'=>'js/','file'=>'mousewheel.js')
    ,array('path'=>'js/','file'=>'timeline.js')
    ,array('path'=>'js/','file'=>'chat.js')  
    ,array('path'=>'js/','file'=>'account.js')  
    ,array('path'=>'js/','file'=>'script.js') 
    );
    
$config['js']['preferences'] = array(
     array('path'=>'js/uploader/','file'=>'uploadifive.js')
    ,array('path'=>'js/uploader/','file'=>'uploader.js')
    ,array('path'=>'js/crop/','file'=>'crop.lib.js')
    );

$config['js']['requirejs'] = array(
	array('path'=>'js/','file'=>'require-jquery.js')
);

    
$config['js']['main'] = array(
    array('path'=>'js/','file'=>'main.js')
    );
  
$config['css3_browsers'] = array(
    "Internet Explorer" => 7
    ,"Firefox" => 3.5
    ,"Opera" => 9
    ,"Safari" => 4
    ,"Chrome" => 4
);
