<a href="" class="head">9 Contacts Suggestions</a>
<a href="" class="head2"><span class="icon ico-family"></span> Family</a>
<a href="" class="head2"><span class="icon ico-family"></span> Friends</a>

<ul class="buzzingerContact">
	<?php foreach($buddys as $buddy){?>
	<?php if(isset($buddy['firstname'])){?>
	
	<?php 
		$photo = "";
		$photo2 = "nophoto";
		
		if(isset($user['photo']))
		{
			if(file_exists('./upld/photo/'.$buddy['_id'].'/'.$buddy['photo'].'_32.jpg'))
			{
				$photo = "<img src='".resource_url('images/photo/'.$buddy['_id'].'/'.$buddy['photo'].'_32.jpg')."'/>";
				$photo2 = resource_url('images/photo/'.$buddy['_id'].'/'.$buddy['photo'].'_32.jpg');
			}
		}
	?>
	
	<li class="buddy_<?=$buddy['_id']?>" data-id="<?=$buddy['_id']?>" data-photo="<?=$photo2?>" data-name="<?=ucfirst($buddy['firstname']).' '.ucfirst($buddy['lastname'])?>">
		<span class="contactphoto">
			<?=$photo?>
		</span>
		<span class="status">
			<?php if($buddy['online'] == 1){?>
			<span class="ico-<?=$buddy['online_status']?>"></span>
			<?php } else { ?>
			<span class="ico-offline"></span>
			<? } ?>
			
		</span>
		<span class="cname"><?=ucfirst($buddy['firstname']).' '.ucfirst($buddy['lastname'])?></span>
		
		<span class="stmessage custom_status_<?=$buddy['_id']?>">
			<?=$buddy['custom_status']?>
		</span>
		<div class="clear"></div>
	</li>
	<? } ?>
	<?}?>

</ul>
