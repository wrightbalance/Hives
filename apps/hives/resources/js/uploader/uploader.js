$(document).ready(function(e){
	$('#change_photo').uploadifive(
		{
			'uploadScript' 		: root+'uploader',
			'buttonClass'		: 'btn',
			'buttonText'		: 'Change Avatar',
			'queueID'			: 'profile_queue',
			'multi'				: false,
			'auto'				: true,
			'height'			: 19,
			'upload_limit'		: 1,
			'fileSizeLimit' 	: '20MB',
			'queueSizeLimit' 	: 1,
			'onSelect'			: function()
				{
					
				},
			'onUploadComplete' 	: function(file, data)
				{
					result = $.parseJSON(data);
					console.log(data);
				},
			'onDrop'       		: function(file, fileDropCount) 
				{
					
				},
			'onSelect'			: function(queue)
				{
	
				},
			'onFallback' : function()
				{
					
				}
		}
    );
	
	
})
