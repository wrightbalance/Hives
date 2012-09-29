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
			
			return false;
		})
		//$('.response',form).html(data.message);
		console.log(data.message);
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

