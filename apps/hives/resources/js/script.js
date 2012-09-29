var windowFocus = true;
var newMessages = new Array();
var originalTitle;
var blinker;
var blinkChatWindow;
var doblinkTitle = true;


$(window).load(function(){

	//$('.searchContact').html($('body').width());
})

$(window).resize(function(){
	//$('.searchContact').html($('body').width());
	
})

$(document).keyup(function(e){
	if(e.which == 27)
	{
		$('.modal').modal('hide');
	}
})

$(document).ready(function(){
	originalTitle = document.title;
	
	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		clearInterval(blinker);
		document.title = originalTitle;
	});
	
	//$('.timeline-content').lionbars();
	
	
	
	$('.buzzingerContact').lionbars();
	
	var sbarStatus = true;
	
	$('.sidebarToggler a').live('click',function(e){
		
		if($(this).data('toggle') == "show")
		{
			$(this).data('toggle','hide');
			
			$('.sidebar').animate({left:-200},200,
				function()
				{
					$('.sidebar').addClass('left200');
					$('.content').addClass('content_expand');
					$('.contentInner').addClass('padding_zero');
					$('.spanner').addClass('width34');
				}
				
			);
			
			$.post(root+'utility/setSidebar',{toggle:1},function(){},'json');
			
		} else {
			$(this).data('toggle','show');
			$('.sidebar').animate({left:0},200,
				function()
				{
					$('.sidebar').removeClass('left200');
					$('.content').removeClass('content_expand');
					$('.contentInner').removeClass('padding_zero');
					$('.spanner').removeClass('width34');
				}
				
			);
			$.post(root+'utility/setSidebar',{toggle:0},function(){},'json');
		}
		
		return false;
	})
	
	$('#timeline').click(function(){
		$(this).mousedown(function (event) {
            $(this)
                .data('down', true)
                .data('x', event.clientX)
                .data('scrollLeft', this.scrollLeft);
                
            return false;
        }).mouseup(function (event) {

        }).mousemove(function (event) {
     
        }).mousewheel(function (event, delta) {
            this.scrollLeft -= (delta * 50);
           
        }).css({
            'overflow' : 'hidden',
            'cursor' : '-moz-grab'
        });
	})
	

	
	$('body').click(function(e){
		var target = $(e.target);
		
		$('.status_opt').hide();
		$('.toggle_status').removeClass('toggle_active');
		
		if(target.is('.status_opt') || target.is('.custom_status textarea'))
		{
			$('.status_opt').show();

			return false;
		}
	})
	

	if(typeof io != "undefined")
	{
		//$('body').live('click',function(){
		//	socket.emit('connect',{id:id,pname:pname});
		//})
	}
	
	
	$('.windowTool .minimize').live('click',function(e){
		e.preventDefault();
		var boxid = $(this).data('boxid');
		var senderid = $(this).data('senderid');
		
		$('#boxid_'+senderid+' .chatbox').fadeOut('fast',function(){
			$('#boxid_'+senderid+' .minimizeWindow').fadeIn('fast');
			$('#boxid_'+senderid+' .minimizeWindow').data('winstate','min');
			$('#boxid_'+senderid+' .chatbox').data('winstate','min');
		});	
			
		
		boxAction('min',boxid);

	})
	
	$('.windowTool .close').live('click',function(e){
		e.preventDefault();
		
		var boxid = $(this).data('boxid');
		var senderid = $(this).data('senderid');
		
		$('#boxid_'+senderid).fadeOut('fast',function(){
			$('#boxid_'+senderid).remove();
		})
		
		chatBoxes = $.grep(chatBoxes,function(v){
			return v != senderid;
		});
		
		boxAction('close',boxid);
		
	})
	
	$('.minimizeWindow').live('click',function(e){
		var parent = $(this).parent();
		var boxid = $(this).data('boxid');
		var senderid = $(this).data('senderid');
		
		$('#boxid_'+senderid+' .minimizeWindow').fadeOut('fast',function(){
			$('.chatbox',parent).fadeIn('fast',function(){
				$('#boxid_'+senderid+' textarea').focus();
				$('#boxid_'+senderid+' .chatbox').data('winstate','max');
				
				$('#boxid_'+senderid+' .chatContent').scrollTop($('#boxid_'+senderid+' .chatContent').height() + 999999);
			});
			
		});
		
		$('#boxid_'+senderid+' .minimizeWindow').data('winstate','max');

		$('.minwindow'+senderid).removeClass('newMessage');
		
		boxAction('max',boxid);
		
	})

	/*
	$('.footerNav a').live('click',function(e){
		e.preventDefault();
		var url 	= $(this).attr('href');
		var title 	= $(this).data('title');
		var curUrl 	= window.location.pathname;
		
		if(curUrl == url) return false;
		
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		window.history.pushState({page:url},url,url);
		document.title = title;
		
		$('*').addClass('wait');
		
		$('#pageContentLoader').load(url,function(){
			$('*').removeClass('wait');
		});

	})
	*/
	
	$('.buzzingerContact li').live('click',function(e){
		var _toid 	= $(this).data('id');
		var _photo 	= $(this).data('photo');
		var _name 	= $(this).data('name');
		var _sender = id;
		var boxexist = $('#boxid_'+_toid).length;
		var winstate;
		
		$('.chatboxWrapper').fadeIn('fast');
		
		if(boxexist)
		{
			winstate = $('#boxid_'+_toid+' .chatbox').data('winstate');
			
			if(winstate == "min")
			{
				$('.minwindow'+_toid).trigger('click');
			}		
		}
		else
		{
			createChatBox(_toid,_sender,_photo,_name,'self');
			chatHistory(_toid);
		}
		$('#boxid_'+_toid+' textarea').focus();	
	})
	
	
	
	var showcolor = true;

	$('.toggle_status').live('click',function(e){
		$('.status_opt').toggle();
		$(this).addClass('toggle_active');
	})
	
	$('#do_share_photo').live('click',function(e){
		$('.queue_share').css({'height':'47px','visibility':'visible'});
		$('.btnblue').hide();
		$('#share_photo').uploadifyUpload();
		
	})

})

//
//
 
/*
if (window.webkitNotifications) {
	function createNotificationInstance(options) {
	  if (options.notificationType == 'simple') {
		return window.webkitNotifications.createNotification(
			root + 'resources/live/images/favicon.ico', options.title, options.message);
	  } else if (options.notificationType == 'html') {
		return window.webkitNotifications.createHTMLNotification('http://www.google.com');
	  }
	}
	document.querySelector('#allow_notify').addEventListener('click', function() {
	if (window.webkitNotifications.checkPermission() != 0) {
		window.webkitNotifications.requestPermission();
	} 
	}, false);
	//console.info('Browser supported');
}
else {
  console.log("Notifications are not supported for this Browser/OS version yet.");
} 
*/


 
