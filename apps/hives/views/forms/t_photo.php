<div class="tpane photo">
	<form method="post" action="<?=site_url('timeline/post')?>" class="timeline_frm">
	<input type="hidden" name="type" value="share_photo"/>
	<input type="text" style="display: none" name="id" value="<?=$user['_id']?>"/>
	<input type="text" style="display: none" name="photo_filename"/>
		<div class="text">
			<div class="share_gray_content">
				<div class="uploaderAction">
					<h4 class="t_h4">Share Photos to your friends</h4>
					<input type="file" id="share_photo"/>
					<button type="button" class="btnblue">Browse Photo</button>
					<span class="t_info s_info">
						<p>Select an image file on your computer.</p>
						<p>Refrain from sharing porn or offensive photos.</p>
					</span>
					<span class="t_info s_queue" style="display: none">
						<p>One photo selected</p>
					</span>
				</div>
				
				<div class="queue_share" id="share_queue"></div>
			</div>
		</div>
		<div class="spacer5"></div>
		<div class="text text2">
			<textarea class="reset" name="status" placeholder="Got something to say?"></textarea>
		</div>
		<div class="spacer5"></div>
		<div class="tp_label"><span class="t_icon ico-add"></span>Share this post to</div>
		<input type="text" class="t_input reset" placeholder="Type of your friends name or Hives here..."/>
		
		<div class="tp_label"><span class="t_icon ico-email"></span>Share this post to</div>
		<input type="text" class="t_input reset" name="f_email" placeholder="Enter your friend's email address"/>
		
		<div class="btn_action_right">
		<button class="hbtn" type="button" onclick="$('#timelinePost').modal('hide');">Discard</button>
		<button class="hbtn" type="button">Save Draft</button>
		<button class="hbtn" type="button" id="do_share_photo">Share</button>
		</div>
	</form>
	
</div>
