	
	</div>

	

</div>
<div class="footer">
		
		<div class="spanner  <?=(isset($sbarToggle['width34']) ? $sbarToggle['width34'] : '')?>"></div>
		<div class="chatappend" id="chatappend_<?=$user['_id']?>">
			<?php $this->load->view('widget/chatbox')?>
		</div>
		<?php $this->load->view('widget/profilefooter')?>
		<?php $this->load->view('menu/footer')?>
	</div>
<div class="clear"></div>
</div>

<script src="<?=substr(site_url(),0,-1).':'.config_item('chat_port')?>/socket.io/socket.io.js"></script>

<script type="text/javascript">
	var root = '<?=base_url()?>';
	<?php if(isset($user)) {?>
		var socket_host 	= '<?=substr(site_url(),0,-1)?>';
		var chat_port 		=  <?=config_item('chat_port')?>; 
		var id 				= '<?=$user['_id']?>';
		var pname 			= '<?=ucwords($user['firstname'].' '.$user['lastname'])?>';

		<?php 
			$photo = "";
			if(isset($user['photo'])) 
			{
			
				if(isset($user['photo']))
				{
					if(file_exists('./upld/photo/'.$user['_id'].'/'.$user['photo'].'_32.jpg'))
					{
						$photo = resource_url('images/photo/'.$user['_id'].'/'.$user['photo']);
					}
				}
		
			} 
		?>
		
		var profilePhoto	= '<?=$photo?>';
		
		if(typeof io != "undefined")
		{
			var connection 		= socket_host+':'+chat_port;
			var socket 			=  io.connect(connection);
		}
		
		var chatBoxes		=  new Array();
		
		<?php if(isset($chatbox)) {?>
			chatBoxes = <?="['".implode("','",$chatboxids)."']"?>;
		<? } ?>
		
		
	<? } ?> 
</script> 
<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" data-main="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup))?>" src="<?=site_url("mini/js/requirejs/".mtime('js','requirejs').'.js')?>"></script>


</body>
</html>
