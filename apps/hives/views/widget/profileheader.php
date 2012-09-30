
<div class="profileName">
	<div class="photo50">
		<?php if(isset($user['photo'])){?>
			<?php if(file_exists('./upld/photo/'.$user['_id'].'/'.$user['photo'].'_50.jpg')){?>
				<img src="<?=resource_url('images/photo/'.$user['_id'].'/'.$user['photo'].'_50.jpg')?>" width="50" height="50"/>
			<? } else { ?>
				<div class="default50"></div>
			<? } ?>
		<? } else {?>
			<div class="default50"></div>
		<? } ?>
	</div>
	<div class="pname">
		<span class="name"><?=ucwords($user['name']['first'].' '.$user['name']['last'])?></span>
		<?php if(isset($user['position'])){?><? } ?>
		<span class="position">
				<?php if(isset($user['position'])){?>
					<?=$user['position']?>
				<? } ?>
		</span>
		<div class="currentStatus">
			<div class="statusBg"></div>
			<span class="icon ico-<?=$user['online_status']?> ico-status"></span>
			<?php if(empty($user['custom_status'])) { ?> 
			<span class="statusTxt"><?=ucwords($user['online_status'])?></span>
			<? } else { ?> 
			<span class="statusTxt"><?=$user['custom_status']?></span>
			<? } ?>
			<span class="icon ico-arrow-right-white ico-move-right pointer toggle_status"></span>
			<div class="status_opt">
				<ul>
					<li><span class="st-icon st-online"></span><a href="#" data-status="online">Online</a></li>
					<li><span class="st-icon st-busy"></span><a href="#" data-status="busy">Busy</a></li>
					<li><span class="st-icon st-away"></span><a href="#" data-status="away">Away</a></li>
					<li><span class="st-icon st-invisible"></span><a href="#" data-status="invisible">Invisible</a></li>
				</ul>
				<span class="custom_status">
					<label>Custom status</label>
					<textarea name="custom_status"><?=$user['custom_status']?></textarea>
				</span>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="pline"></div>
</div>
