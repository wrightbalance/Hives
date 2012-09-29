<?php if(isset($chatbox)) {?>
<?php foreach($chatbox as $cbox){?> 

<?php 
	
	$showChatbox = "style='display: block'";
	$maximize	 = "style='display: none'";
	
	if($cbox['winstate'] == "min")
	{
		$showChatbox = "style='display: none'";
		$maximize	 = "style='display: block'";
	}
	
	$photo = "";
	
	if(isset($cbox['photo']))
	{
		if(file_exists('./upld/photo/'.$cbox['sender'].'/'.$cbox['photo'].'_32.jpg')){
			$photo = "<img src='".resource_url('images/photo/'.$cbox['sender'].'/'.$cbox['photo'].'_32.jpg')."'/>";
		}
	}
?>


<div class="chatboxWrapper" id="boxid_<?=$cbox['sender']?>"  data-btype="solo" data-boxid="<?=$cbox['sender']?>">
	<div class="chatbox" <?=$showChatbox?> data-winstate="<?=$cbox['winstate']?>">
		<div class="chatHeader">
		<div class="cmenu">
			<a href="#" class="openMenu"></a>
		</div>
		<div class="cphoto">
			<?=$photo?>
		</div>
		<div class="cname"><?=ucwords($cbox['chatboxname'])?></div>
		<div class="windowTool">
			<a href="#" class="minimize" data-senderid="<?=$cbox['sender']?>" data-boxid="<?=$cbox['boxid']?>"></a>
			<a href="#" class="close"  data-senderid="<?=$cbox['sender']?>" data-boxid="<?=$cbox['boxid']?>"></a>
		</div>
		</div>

		<div class="chatContent">
			<?php foreach($cbox['chat'] as $chat){?>
				<span>
					<span class="chat_photo">
						<?php if(isset($chat['photo'])){?>
							<?php if(file_exists('./upld/photo/'.$chat['sender_id'].'/'.$chat['photo'].'_32.jpg')){?>
								<img src="<?=resource_url('images/photo/'.$chat['sender_id'].'/'.$chat['photo'].'_32.jpg')?>" width="32" height="32"/>
							<? } else { ?>
								<!--HAS PHOTO BUT FILE DOESNT EXIST-->
							<? } ?>
						<? } else {?>
							<!--NO PHOTO-->
						<? } ?>
					</span>
					<a href=""><?=ucwords($chat['sender_name'])?></a>
					<p class="chat-msg" data-msgid="<?=$chat['sender_id']?>">
						<?=nl2br($chat['message'])?>
						<br/>
					</p>
					<div class="clear"></div>
				</span>
	
			<? } ?>
			
		</div>
		<div class="chatMessage">
			<div class="istyping typing<?=$cbox['id']?>"><?=$cbox['chatboxfname']?> is typing...</div>
			<textarea class="reset" data-toid="<?=$cbox['sender']?>" data-boxid="<?=$cbox['boxid']?>"></textarea>
		</div>

	</div>
	<div class="minimizeWindow minwindow<?=$cbox['sender']?>" data-winstate="<?=$cbox['winstate']?>" data-senderid="<?=$cbox['sender']?>" data-boxid="<?=$cbox['boxid']?>" <?=$maximize?>>
		<div class="cphoto">
			<?=$photo?>
		</div>
		<div class="cname"><?=$cbox['chatboxname']?></div>
		<div class="windowTool">
			<a href="#" class="close"  data-senderid="<?=$cbox['sender']?>" data-boxid="<?=$cbox['boxid']?>"></a>
		</div>
	</div>
</div>


<? } ?>
<? } ?>
