
<div class="body">
	<div class="header">
		<div class="container clearfix">
			<div class="logo">
				<a href="<?=site_url()?>" class="home block"></a>
			</div>
			<div class="navOuter">
				<?php $this->load->view('menu/top')?>
				<?php $this->load->view('menu/main')?>
			</div>
		</div>
	</div>
		
	<div class="content bgBlack">
		<div class="container clearfix">
			
			<div class="colb index">
			
					<?php $this->load->view('widget/home')?>
			
			</div>
			
			<div class="cols">
				
				<?php $this->load->view('forms/h_login')?>
				
			</div>
			
		</div>
	</div>	

	<div class="footer">
		<div class="container"></div>
	</div>
</div>
	

