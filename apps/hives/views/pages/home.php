<?php $this->load->view('widget/profileheader')?>

<div class="timeline">

	<h1>See what's happening to your Hives and Friends</h1>

	<a href="#" class="timeline_edit"></a>
	<div class="timeline-content" id="timeline">

		<div class="timeline-holder" id="timelineLoader">
		
		</div>
	</div>
	<?php $this->load->view('menu/timeline')?>
</div>


<?php $this->load->view('modal/timeline')?>
<?php $this->load->view('modal/viewer')?>
