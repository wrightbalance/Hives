<?php $this->load->view('widget/logo_footer')?>

<div class="profileFooter">
	<a href="">
			<?php if(getphoto($user['_id']) !== false){?>
			<img src="<?=getphoto($user['_id'],32)?>" alt=""/>
		<? } else {?>
			<div class="default50"></div>
		<? } ?>
		
	</a>
	<span class="pnameFooter">
		<?=ucwords($user['name']['first'].' '.$user['name']['last'])?><br/>
		<a href="">View My Page</a> <span>|</span><a href="">Edit</a>
	</span>
	
</div>


