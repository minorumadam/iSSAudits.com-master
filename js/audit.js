
function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
	}

function isImage(filename) {
	var ext = getExtension(filename);
	switch (ext.toLowerCase()) {
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		return true;
	}
	return false;
}


	
function ajaxCall(){
		$.ajax({
		   type:'post',
		   data: $('#question').serialize()
		});
	}


$('input').change(function(){
	if($(this).hasClass('photoupload')){
			if(!isImage($(this).val())){
				alert('Invalid photo');
				return false;
				}
			$(this).parent().parent().find('.photobutton').html('Uploading...');
			var $this = $(this);
			$('#question').ajaxForm({
						success:function(data){
								$this.parent().parent().find('.photobutton').html('Uploaded');
								location.reload();
							}
				}).submit();
		 
		}else{
			ajaxCall();
		}
});

$('textarea').blur(function() {
	  if($.trim($(this).val()).length){
			ajaxCall(); 
	  } 
	});
