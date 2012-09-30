/*
 * Timeline jQuery Plugin
 * Created by: Jinggo C. Villamor
 * jinggo.villamor@gmail.com 
 */
 
;(function( $ ){
	
	$.jvGetTimeline = function()
	{
		$.getJSON(root+'timeline/getAllTimeline',function(data){
			
			var db = data.db;
			var x = 1;
			var tbox = [];
			
			$.each(db,function(i,n){
				var tid = n._id.$id;

				if(i % 2 == 0)
				{
					tbox.push('<div class="wrap-timeline">');
				}
		
				
				tbox.push('<div class="timeline-box tAbsolute" id=\"t_box_'+n.tid.$id+'"\ ">');
	
				tbox.push('			<div class="timeline-outer"></div>');
				tbox.push('				<div class="timeline-inner">');					
				tbox.push('					<div class="t_content_outer">');
				tbox.push('						<div class="t_content gray '+n.type+'" data-tid="'+n.tid.$id+'">');
				tbox.push(								'<p>'+n.content+'</p>');
				tbox.push('						</div>');
				tbox.push('						<div class="t_title t_'+n.type+'">');
				tbox.push('							<span class="t_icon '+n.icon+'"></span>');
				tbox.push('							<span class="t_label">'+n.label+'</span>');
				tbox.push('							<span class="t_count">'+n.comments+' Comment</span>');
				tbox.push('						</div>');						
				tbox.push('						<div class="clear"></div>');
				tbox.push('						<div class="t_user_details">');
				
				if(n.photo != "")
					tbox.push('							<span class="t_photo"><img src="'+n.photo+'" /></span>');
				else
					tbox.push('							<span class="t_photo"></span>');
				
				tbox.push('							<span class="t_user_caption">');
				tbox.push('								<p>'+n.det_content+'</p>');
				tbox.push('							</span>');
				tbox.push('						</div>');								
				tbox.push('					</div>');				
				tbox.push('				</div>');
				tbox.push('			</div>');
				
				if(i % 2 == 1)
				{
					tbox.push('</div>');
				}

	
			})
			
			$('#timelineLoader').empty().prepend(tbox.join(""));
	
			
			$('.timeline-box').each(function(i){
				var ele = this;
			
				setTimeout(function(){
					$(ele).animate({
						top: 0
					},'slow',function(){
						$(ele).removeClass('tAbsolute');
					})
				},60*i)
				
			})
		})
	}
	
	$.jvTemplate = function(t)
	{
		return console.log('test');
	}
	
	$.fn.jvTimeline = function(t)
	{

		t = $.extend({
			 type : ''
			,tid  : ''
			,content: ''
			,icon : ''
			,label : ''
			,comment : ''
			,photo : ''
			,det_up : ''
			,det_down: ''
		},t);

		var tbox = [];
		var item = $('.wrap-timeline').first().children().length;

		if(item == 2 || item == 0)
		{
			tbox.push('<div class="wrap-timeline">');
		}
		
		tbox.push('<div class="timeline-box" style="display: none">');
		tbox.push('			<div class="t_preloader">');
		tbox.push('				<div class="inner_overlay"></div>');
		tbox.push('				<div class="t_animate"></div>');
		tbox.push('			</div>');
		tbox.push('			<div class="timeline-outer"></div>');
		tbox.push('				<div class="timeline-inner">');					
		tbox.push('					<div class="t_content_outer">');
		tbox.push('						<div class="t_content gray '+t.type+'" data-tid="'+t.tid+'">');
		tbox.push(								'<p>'+t.content+'</p>');
		tbox.push('						</div>');
		tbox.push('						<div class="t_title t_'+t.type+'">');
		tbox.push('							<span class="t_icon '+t.icon+'"></span>');
		tbox.push('							<span class="t_label">'+t.label+'</span>');
		tbox.push('							<span class="t_count">'+t.comment+' Comment</span>');
		tbox.push('						</div>');						
		tbox.push('						<div class="clear"></div>');
		tbox.push('						<div class="t_user_details">');
		
		if(t.photo != "")
			tbox.push('							<span class="t_photo"><img src="'+t.photo+'_32.jpg" /></span>');
		else
			tbox.push('							<span class="t_photo"></span>');
		
		tbox.push('							<span class="t_user_caption">');
		tbox.push('								<p>'+t.det_up+'</p>');
		tbox.push('								<p>'+t.det_down+'</p>');
		tbox.push('							</span>');
		tbox.push('						</div>');								
		tbox.push('					</div>');				
		tbox.push('				</div>');
		tbox.push('			</div>');
		
		if(item == 2 || item == 0)
		{
			tbox.push('</div>');	
			
			this.prepend(tbox.join(''));
		}
		else
		{
			$('.wrap-timeline').first().prepend(tbox.join(''));
		}

		$('.timeline-box').fadeIn('slow',function()
		{
			$('.t_preloader').fadeOut('slow');
		});
	}
	
	
})(jQuery); 

var jsonTimeline = {
	
	success: function(data,form)
	{
		var db = data.db;

		$('#timelineLoader').jvTimeline({
			 type : db.type
			,tid  : db.tid
			,content: db.content
			,icon : db.icon
			,label : db.label
			,comment : db.comment
			,photo : db.photo
			,det_up : db.det_up
			,det_down: db.det_down
		})
		
		$(form).trigger('reset');
		$('#timelinePost').modal('hide'); 
	}
}

var afterUpload = false;

$(document).ready(function(){
	
	$.jvGetTimeline();
	
	$('.timeline_edit').live('click',function(e){
		e.preventDefault();
		
		$('#timelinePost').modal({
			show: true,
			backdrop: true,
		});
		
		html.timelineform();
		html.tform('status');
		
	})
	
	$('.modal_timeline_body').delegate('.t_comment_area','keydown',function(e){
		if(e.which == 13)
		{
			e.preventDefault();
			var comment = $(this).val();
			
			$(this).val('');
			
			var tbox = [];
			
			tbox.push("	<div class=\"v_comment_post\">");
			tbox.push("		<span><img src='"+profilePhoto+"' width=\"32\" height=\"32\"/></span>");
			tbox.push("		<span><a href=''>"+pname+"</a><p>"+comment+"</p></span>");
			tbox.push("		<div class=\"clear\"></div>");
			tbox.push("	</div>");
			
			$('.load_comment').prepend(tbox.join(""));
			$(".nano").nanoScroller({ scroll: 'bottom' });

		}
		
		
	})
	
		
	$('.modal_timeline_body').on('click','.form_tab a',function(e){
		e.preventDefault();
		var idx = $(this).index();
		var type = $(this).data('ttype');

		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		$('.tpane').siblings().removeClass('tactive');
		$('.tpane').eq(idx).addClass('tactive');
		
		html.tform(type);

		if(type == "photo")
		{	
			$('#share_photo').uploadifive(
			{
				'uploadScript' 		: root+'timeline/upload_share_photo',
				'buttonClass'		: 'btnblue',
				'buttonText'		: 'Browse Photos',
				'queueID'			: 'share_queue',
				'multi'				: false,
				'auto'				: false,
				'height'			: 19,
				'upload_limit'		: 1,
				'fileSizeLimit' 	: '20MB',
				'queueSizeLimit' 	: 1,
				'onUploadComplete' 	: function(file, data)
					{
						result = $.parseJSON(data);
						
						console.log(result);
						
						$('input[name=filename]').val(result.filename);
						
						var form = $('form.timeline_frm');
						var dt 		= $(form).serializeArray();
						var action  = $(form).attr('action');
		
						$.ajax({
							url: action,
							data: dt,
							dataType: 'json',
							type: 'post',
							success: function(data)
							{
								try
								{
									if(data)
									{

										jsonTimeline[data.action](data,form);
									}
								}
								catch(e)
								{
									console.log(e);
								}
							}
						})
						
					}
			});
		}
		
	})
	
	$('.modal_timeline_body').delegate('form.timeline_frm','submit',function(e){
		e.preventDefault();
		var form 	= this;
		var dt 		= $(form).serializeArray();
		var action  = $(form).attr('action');
		var status = $('textarea[name=status]').val();
		var ttype = $('.form_tab a.active').data('ttype');

		if(ttype == "photo")
		{
			$('#share_photo').uploadifive('upload');
			return false;
		}
		
		if($.trim(status) === "") return false;
		
		$.ajax({
			url: action,
			data: dt,
			dataType: 'json',
			type: 'post',
			success: function(data)
			{
				try
				{
					if(data)
					{
						if(typeof data.session != "undefined")
						{
							alert('Session expired');
							location.reload();
						}
						
						jsonTimeline[data.action](data,form);
					}
				}
				catch(e)
				{
					console.log(e);
				}
			}
		})
		
		
		
	})

	$('.timeline-content').delegate('.t_content','click',function(){
		$('#timelineViewer').modal({
			show: true,
			backdrop: 'static',
		});
		
		$('.modal_timeline_body').empty();
		
		var tid = $(this).data('tid');
		$('v_content').html('<div class="v_loader"></div>');
		html.timelineviewer();
		
		$.ajax
		(
			{
				url: root + 'timeline/getDetails',
				data: {tid:tid},
				dataType: 'json',
				type: 'post',
				success: function(data)
				{
					try
					{
						if(data)
						{
							var db = data.db;
							var type = db[0].type;
							
							$('.posted_by').html(db[0].posted_by);
							
							$('.t_caption').html('');
							$('.v_content').removeClass('v_status');
							$('.description').html('');
							
							if(db[0].photo != "")
							$('.m_photo').html('').html('<img src="'+db[0].photo+'"/>');
							
							$('.psidebar .ico-type').removeClass('ico-status');
							$('.psidebar .ico-type').removeClass('ico-sharephoto');
							$('.t_comment_area').attr('data-tid',db[0].tid.$id);
							
							switch(type)
							{
								case 'status':
									$('.v_content').addClass('v_status');
									$('.v_content').html('').html(db[0].fullcontent);
									$('.psidebar .ico-type').addClass('ico-status');
								
									break;
								case 'share_photo':
									$('.psidebar .ico-type').addClass('ico-sharephoto');
									$('.v_content').html('').html("<img class='shared_photo' style='display: none' src='"+db[0].share_photo+"' width='600' height='480'/>");
									$('.t_caption').html('').html(db[0].caption);
									$('.description').html('').html('<p>'+db[0].description+'</p>');
									break;
								
							}
							
							
							$('.v_content img').load
							(
								function ()
								{
								$(this).hide().css('visibility','visible').fadeIn();
								}
							);
							
							//console.log(db);
							
						}
					}
					catch(e)
					{}
				}
			}
		)
		
	})
	

	
	var timelineLeft = $('#timeline').scrollLeft();

	$('.slidebytime a').live('click',function(e){
		e.preventDefault();
		
		var time = $(this).data('time');
		
		if(time > 0)
		{
			timelineLeft = timelineLeft + 300;
		}
		else
		{
			timelineLeft = 0;
		}
		
		$('#timeline').animate({scrollLeft:timelineLeft},800);
	})
		
})

$('img.share_photo').load
(
	function ()
	{
		//console.log('test');
		$('img.share_photo').css('visibility','visible').fadeIn();
	}
);

if(typeof io != "undefined")
{

	var timeline = io.connect(connection+'/timeline');

	timeline.on('connect',function(){
			
		timeline.on('receive',function(data){
			//console.log(data);
			template(data,'timelineLoader');
		})	
			
	})

}


