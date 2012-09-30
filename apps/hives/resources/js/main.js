var jsonProc = 
{
	retry: function(data,form)
	{
		var err = data.error;
		
		$('input.textbox').removeClass('error');
		
		$.each(err,function(i,n){
			$('input[name='+i+']').focus();
			$('input[name='+i+']').removeClass('error');
			$('input[name='+i+']').addClass('error');
			
			$('select[name='+i+']')
							.focus('error')
							.removeClass('error')
							.addClass('error');
			
			$('input[name='+i+']').siblings().append("<i class=\"error_msg_"+i+"\">"+n+"</i>");
			$('select[name='+i+']').siblings().append("<i class=\"error_msg_"+i+"\">"+n+"</i>");
			
			$('.error_msg_'+i).animate({
				right: 0
			},'fast',function(){
				
				var er = this;
				
				setTimeout(function(){
					$(er).animate({
						right: '-200px'
					})
				},2000)
			})
			return false;
		})
	}
	,success: function(err,form)
	{
		
	}
	,reload: function(data,form)
	{
		location.href=data.url;
	}
}

$(document).ready(function(){
		
	$('.form').submit(function(e){
		e.preventDefault();
		
		var form = this;
		var dt = $(form).serializeArray();
		var action = $(form).attr('action');
		$('.response',form).html('Loading...');
		
		$.ajax({
			url: action,
			dataType: 'JSON',
			type: 'POST',
			data: dt,
			success: function(data)
			{
				try
				{
					if(data)
					{
						jsonProc[data.action](data,form);
					}
				}
				catch(e)
				{
					console.log(e);
				}
			}
		})
		
	})
		
})

