<?php $this->load->view('layout/head_default') ?>
<body>

<div class="body">
	<input type="hidden" name="userid" value="<?=$user['_id']?>"/>
	
	<?php echo $sidebar?>
	
	<div class="content <?=(isset($sbarToggle['content_expand']) ? $sbarToggle['content_expand'] : '')?>">

		<?php $this->load->view('widget/topbar')?>
		<div class="contentInner <?=(isset($sbarToggle['padding_zero']) ? $sbarToggle['padding_zero'] : '')?>" id="pageContentLoader">
			
	
	

		
