<?php $this->load->view('widget/logo_footer')?>

<div class="profileFooter">
	<a href="">
		<?php if(isset($user['photo'])){?>
			<?php if(file_exists('./upld/photo/'.$user['_id'].'/'.$user['photo'].'_32.jpg')){?>
				<img src="<?=resource_url('images/photo/'.$user['_id'].'/'.$user['photo'].'_32.jpg')?>" width="32" height="32"/>
			<? } else { ?>
				<span class="default32"></span>
			<? } ?>
		<? } else {?>
			<span class="default32"></span>
		<? } ?>
		
	</a>
	<span class="pnameFooter">
		<?=ucwords($user['name']['first'].' '.$user['name']['last'])?><br/>
		<a href="">View My Page</a> <span>|</span><a href="">Edit</a>
	</span>
	
</div>


