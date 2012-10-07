<?php $this->load->view('widget/profileheader')?>

<div class="timeline">

	<h1>Conversation</h1>
	
	<div class="pOuter">
		
		<div class="pLeft">
			<h3>Create New Message</h3>
			
			<div class="pBox">
				<h4 class="url selected">Inbox (129)</h4>
				<div class="sub_url">
					<a href="">9 New Messages</a>
					<a href="">129 Read Messages</a>
					<a href="">9 Friend Requests</a>
					
				</div>
				<h4 class="url">Draft (0)</h4>
				<h4 class="url">Sent Items (7)</h4>
				<h4 class="url">Trash (5)</h4>
			</div>
			
			<div class="pBox">
				
			</div>
		
			
		</div>
		<div class="pCenter">
			<div class="top_url">
				<span class="title">Inbox</span>
				
				<div class="nano nano_pcenter">
					<div class="content">
						<div class="tblLists">
						<?php for($x = 0; $x <= 20; $x++){?>
						<div class="list">
							<div class="listInner">
								<div class="lopt">
									<span class="type"></span>
									<input type="checkbox"/>
								</div>
								<div class="lphoto"></div>
								<div class="lcontent">
									<a href="">Chat with Jinggo Villamor</a>
									<span>January 9, 2012 9 am</span>
								</div>
							</div>
							<div class="laction">
								<a href="" class="garbage"></a>
							</div>
							<div class="clear"></div>
						</div>
						<? } ?>
					</div>
					</div>
				</div>
			
			</div>
		</div>
		<div class="pRight"></div>
		<div class="clear"></div>
		
	</div>

</div>
