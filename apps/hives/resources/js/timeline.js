/*
 * Timeline jQuery Plugin
 * Created by: Jinggo C. Villamor
 * jinggo.villamor@gmail.com 
 */
 
;(function( $ ){
	
	$.jvTemplate = function(t)
	{
		
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
	}
	
}

$(document).ready(function(){
	
	
	$('.timeline_edit').live('click',function(e){
		e.preventDefault();
		
		$('#timelinePost').modal({
			show: true,
			backdrop: true,
		});
		
		html.timelineform();
		html.tform('status');
		
	})
	
		
	$('.modal_timeline_body').on('click','.form_tab a',function(e){
		e.preventDefault();
		var idx = $(this).index();
		var type = $(this).data('ttype');
		
		console.log(type);
		
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		$('.tpane').siblings().removeClass('tactive');
		$('.tpane').eq(idx).addClass('tactive');
		
		html.tform(type);
	})
	
	
	$('form.timeline_frm').live('submit',function(e){
		e.preventDefault();
		
		var form 	= this;
		var dt 		= $(form).serializeArray();
		var action  = $(form).attr('action');
		var status = $('textarea[name=status]').val();

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
		
		$('#timelinePost').modal('hide'); 
		 
	})
	
	$('.t_content').live('click',function(){
		$('#timelineViewer').modal({
			show: true,
			backdrop: true,
		});
		
		var tid = $(this).data('tid');
		$('v_content').html('<div class="v_loader"></div>');
		
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
							$('.m_photo').html('').html('<img src="'+root+'resources/site/images/photo/'+db[0].userid+'/'+db[0].photo+'_50.jpg"/>');
							
							$('.psidebar .ico-type').removeClass('ico-status');
							$('.psidebar .ico-type').removeClass('ico-sharephoto');
							
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
	});
	
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


