<div class="tpane video">
	<form method="post" action="<?=site_url('timeline/post')?>" class="timeline_frm">
	<input type="hidden" name="type" value="status"/>
	<input type="hidden" name="id" value="<?=$user['_id']?>"/>
		<div class="text">
			<div class="share_gray_content">
				<h4 class="t_h4">Share Videos to your friends</h4>
				<button type="button" class="btnblue">Browser Photo</button>
				<span class="t_info">
					<p>Select video file on your computer.</p>
					<p>Refrain from sharing porn or offensive video.</p>
				</span>
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
		<button class="hbtn" type="submit">Share</button>
		</div>
	</form>
	
</div>
