// is typing
(function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);	


/* CLIENT */




if(typeof io != "undefined")
{
var soundsOn = true;
var chat = io.connect(connection+'/chat');
var lb;

chat.on('connect',function(){
	
	chat.on('receive_'+id,
		function(data)
		{
			//console.log(data);
			
			var fromid = data.fromid;
			
			if($('#boxid_'+fromid).length == 0)
			{
				$('.buzzingerContact .buddy_'+fromid).trigger('click');
			}
			else
			{
				chatMessage(data);
			}
			
			var winstate = $('.minwindow'+fromid).data('winstate');
			
			if(winstate == "min")
			{
				$('.minwindow'+fromid).addClass('newMessage');
			}
			else
			{
				$('.minwindow'+fromid).removeClass('newMessage');	
			}
		}
	);
	
	chat.on('istyping_'+id,
		function(data)
		{
			var toid = data.toid;
			
			if(data.act == "start")
				$('.typing'+toid).show();
			else
				$('.typing'+toid).hide();
		}
	);
	
})

}

$(document).ready(function(){
	/*
	$('.chatboxWrapper').livequery(function(){

		lb = $('.chatContent',this).lionbars();	
		lb.scrollToBottom();	
	})
	*/
	$('.chatContent').scrollTop($('.chatContent').height() + 99999);

	var toid 			= $(this).data('toid');

	$('.chatMessage textarea').typing({
		start: function (event, $elem) {
			//$('.istyping').show();
			var toid 			= $($elem).data('toid');
			chat.emit('istyping',{toid:toid,act:'start',fromid:id});
		},
		stop: function (event, $elem) {
			var toid 			= $($elem).data('toid');
			chat.emit('istyping',{toid:toid,act:'stop',fromid:id});
		},
		delay: 500
	});

})

function chatMessage(data)
{
	var html;
	var fromid = data.fromid;
	var notify = $('input[name=notify]').attr('checked');
	var msgid;
	
	var messages = urlParser(data.msg)
	
	
	html  = '';
	html += '<span>';
	html += '	<span class="chat_photo">';
	
	if(data.pphoto != "") html +=		'<img src="'+data.pphoto+'_32.jpg" />';
	
	html += '	</span>';
	html += '	<span class="chat_details">';
	html += '		<a href="">'+data.pname+'</a>';
	html += '		<p class="chat-msg" data-msgid="'+fromid+'">';
	html += 		messages+'<br/>';
	html += '		</p>';
	html += '	</span>';
	html += '	<div class="clear"></div>';
	html += '</span>';
	
	last = $('#boxid_'+fromid+' .chatContent span:last-child');
	msgid = $('p',last).data('msgid')
	
	if(msgid == fromid)
		$('p',last).append(messages+'<br/>');
	else
		$('#boxid_'+fromid+' .chatContent').append(html);

	$('#boxid_'+fromid+' .chatContent').scrollTop($('#boxid_'+fromid+' .chatContent').height() + 99999);
	
	msgid = $('.chat-msg').data('msgid');

	
	if(notify == "checked")
	{
		if (window.webkitNotifications.checkPermission() == 0) {
			chat = createNotificationInstance({notificationType: 'simple', message: data.msg, title : pname});
			chat.show();
			//console.log(chat);
		} else {
			window.webkitNotifications.requestPermission();
		}
	}

	playSound();
}



function playSound()
{
	if(soundsOn)
	{
		$('embed').remove();
		$('body').append('<embed src="'+root+'resources/site/wav/im_sounds.swf'+'" autostart="true" hidden="true" loop="false">');
	}
}

function createChatBox(_toid,_senderid,_photo,_name,_source)
{
	var html = "";
	
	if(_source != "self")
	{
		_toid = _senderid;
	}

	html += '<div class="chatboxWrapper" id="boxid_'+_toid+'" data-btype="solo" data-boxid="'+_toid+'">'
	html += '		<div class="chatbox">';
	html += '			<div class="chatHeader">';
	html += '			<div class="cmenu">';
	html += '				<a href="#" class="openMenu"></a>';
	html += '			</div>';
	html += '			<div class="cphoto">';
	if(_photo != "nophoto")
	{
	html += '				<img src="'+_photo+'"/>';
	}
	html += '			</div>';
	html += '			<div class="cname">'+_name+'</div>';
	html += '			<div class="windowTool">';
	html += '				<a href="#" class="minimize" data-boxid="'+_toid+'"  data-senderid="'+_toid+'"></a>';
	html += '				<a href="#" class="close" data-boxid="'+_toid+'" data-senderid="'+_toid+'"></a>';
	html += '			</div>';
	html += '			</div>';
	html += '			<div class="chatContent">';
	html += '					<div class="istyping">Is typing...</div>'
	html += '					</div>';
	html += '					<div class="chatMessage">';
	html += '						<textarea data-toid="'+_toid+'" class="reset"></textarea>';
	html += '					</div>';

	html += '				</div>';
	html += '				<div class="minimizeWindow" data-boxid="'+_toid+'" data-senderid="'+_toid+'">';
	html += '					<div class="cphoto">';
	if(_photo != "nophoto")
	{
	html += '				<img src="'+_photo+'"/>';
	}
	html += '					</div>';
	html += '			<div class="cname">'+_name+'</div>';
	html += '					<div class="windowTool">';
	html += '						<a href="#" class="close" data-boxid="'+_toid+'" data-senderid="'+_toid+'"></a>';
	html += '					</div>';
	html += '				</div>';
	html += '			</div>';
	
	var addItem = true;

	for(y in chatBoxes)
	{
		if(chatBoxes[y] == _toid)
		{
			addItem = false;
		}
	}
	
	if(addItem)
	{
		chatBoxes.push(_toid);
	}

	for(x in chatBoxes)
	{
		if($('#boxid_'+chatBoxes[x]).length == 0)
		{
			$('.chatappend').prepend(html);
			$('#boxid_'+chatBoxes[x]+' textarea').focus();
		}
	}
	
}

function urlParser(text) {
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    return text.replace(exp,"<a href='$1'>$1</a>"); 
}

function restructureBox()
{
	var width = 250;
	var boxLength = 0;
	
	
	for(x in chatBoxes)
	{
		chatBox = chatBoxes[x];
		winstate = $('#boxid_'+chatBox+' .chatbox').data('winstate');
		
		if(winstate == "min")
			width = 170;

			
		if(boxLength == 0)
		{
			$('#boxid_'+chatBox).css({right:10});
		}
		else
		{
			margin = (boxLength * width) + 7;
			$('#boxid_'+chatBox).css({right:margin});
			//console.log(margin);
		}
		
		
		boxLength ++;
		
	}
	

}

function boxAction(action,boxid)
{
	var dt = {action:action,boxid:boxid};
	
	$.ajax({
		url: root + 'chat/boxAction',
		dataType: 'json',
		type: 'post',
		data: dt,
		success: function(data)
		{
			try
			{
				//console.log(data);
			}
			catch(e)
			{
				
			}
		}
	})
}

function chatHistory(_toid)
{
	var boxexist = $('#boxid_'+_toid).length;
	var done = false;
	
	if(boxexist)
	{
		$.ajax({
			url: root + 'chat/checkchatexist',
			dataType: 'json',
			type: 'post',
			data: {from:_toid},
			success: function(data)
			{
				try
				{
					if(data)
					{
						var db = data.chatboxes;
						
						if(db.length)
						{
							var chat = db[0].chat;
							var html = "";
							
							$.each(chat,function(i,n){
								
								html += '<span>';
								html += '	<span class="chat_photo">';
								html += n.photo2;
								html += '	</span>';
								html += '	<span class="chat_details">';
								html += '		<a href="">'+n.sender_name+'</a>';
								html += '		<p>';
								html += 		n.message;
								html += '		</p>';
								html += '	</span>';
								html += '	<div class="clear"></div>';
								html += '</span>';
								
								//console.log(n);
							})
							
							$('#boxid_'+_toid+' .chatContent').append(html);
							$('#boxid_'+_toid+' .chatContent').scrollTop($('#boxid_'+_toid+' .chatContent').height() + 99999);
							
							
						}
					}
				}
				catch(e)
				{
					console.log(e);
				}
			},
			complete: function(xhr,txtstatus)
			{
				
			}
		})

	}		
}

$('.chatMessage textarea').live('keypress',function(e){

	
	//chat.emit('istyping',{fromid:toid});
	
	if(e.which == 13)
	{
		
		e.preventDefault();
		var toid 			= $(this).data('toid');
		var txt 			= $(this).val();
		
		var dt 				= {toid:toid,fromid:id,msg:txt,pname:pname,pphoto:profilePhoto};
		var msgid;
		
		if(txt == "") return false;
		
		$(this).val('');
		
		var html = "";
		
		html += '<span>';
		html += '	<span class="chat_photo">';
		
		if(profilePhoto != "") html +=		'<img src="'+profilePhoto+'_32.jpg" />';
		
		var messages = urlParser(txt)
		
		html += '	</span>';
		html += '	<span class="chat_details">';
		html += '		<a href="">'+pname+'</a>';
		html += '		<p class="chat-msg" data-msgid="'+id+'">';
		html += 		messages+'<br/>';
		html += '		</p>';
		html += '	</span>';
		html += '	<div class="clear"></div>';
		html += '</span>';
		
		if(typeof chat != "undefined") chat.emit('send',dt);

		last = $('#boxid_'+toid+' .chatContent span:last-child');
		msgid = $('p',last).data('msgid')
		
		if(msgid == id)
			$('p',last).append(txt+'<br/>');
		else
			$('#boxid_'+toid+' .chatContent').append(html);
		
		$('#boxid_'+toid+' .chatContent').scrollTop($('#boxid_'+toid+' .chatContent-content').height()+99999);
		
		

		//lb.Update();
		//lb.scrollToBottom();
		
		//$('#boxid_'+toid+' .lb-content .lb-content').scrollTop();
		
		$.post(root+'chat/save_chat',{sender:id,id:toid,msg:txt},function(data){
			//console.log(data);
			if(typeof data.session != "undefined")
			{
				alert('Session expired');
				location.reload();
			}
		},'json');
		
	}
})


$(window).resize(function(){
	//console.log($('body').width());
})
