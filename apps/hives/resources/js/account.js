/* CLIENT */

if(typeof io != "undefined")
{

var ostatus = io.connect(connection+'/ostatus');

ostatus.on('connect',function(){
	
	ostatus.on('user connected',function(data){
		
		//console.log('Connected ',data);
		setUserStatus(data,'online');
		
	})
	
	ostatus.on('user disconnected',function(data){
		//console.log('User disconnected ',data);
		setUserStatus(data,'offline');
	});
	
	ostatus.on('change status',function(data){
		//console.log(data);
		setUserStatus(data,data.status)
	})
	
})


ostatus.emit('user connecting',{id:id});

}

function setUserStatus(data,status)
{
	$('.buddy_'+data.id+' span.status span').attr('class','ico-'+status);
	
	if(status != "invisible")
		$('.custom_status_'+data.id).html(data.custom);
	else
		$('.custom_status_'+data.id).html('');
	
}




$(document).ready(function(){
	
	$('.status_opt a').live('click',function(e){
		e.preventDefault();
		//console.log('test');
		var status = $(this).data('status');
		var text = $(this).text();
		var custom_status = $('textarea[name=custom_status]').val();
		
		$('.status_opt a').each(function(){
			var this_status = $(this).data('status');
			$('.ico-status').removeClass('ico-'+this_status);
		})
		
		if(custom_status != "")
			text = custom_status;
		
		$('.statusTxt').text(text);
		
		$('.ico-status').addClass('ico-'+status);
		
		if(typeof ostatus != "undefined")
			ostatus.emit('new status',{id:id,status:status,custom:custom_status});
		
		$.ajax({
			url: root + 'users/setStatus',
			data: {status:status,custom_status:custom_status},
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
					}
				}
				catch(e)
				{
					
				}
			}
		})
		
	})
	
})

