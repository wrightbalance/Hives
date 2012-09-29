<div class="sidebar buzzinger <?=(isset($sbarToggle['left200']) ? $sbarToggle['left200'] : '')?>">
	<div class="sidebarToggler">
		<a href="#" data-toggle="<?=(isset($sbarToggle['left200']) ? 'hide' : 'show')?>">
			<span class="icon icon-arrow-right toggle-sidebar"></span>
		</a>
	</div>
	
	<div class="sbarWrapper">
	
	<?php $this->load->view('widget/searchcontact')?>
	<?php $this->load->view('widget/multichat')?>
	<?php $this->load->view('widget/contacts')?>
	
	</div>
	
	<div class="clear"></div>

</div>
