jQuery(document).ready(function($){
 
 
    var custom_uploader;
 
 
    $('.psq_uploader_button').click(function(e) {
        e.preventDefault();
 		
 		var button = $(this);
    	var id = button.attr('id').replace('_button', '');
        //If the uploader object has already been created, reopen the dialog
        //if (custom_uploader) {
        //    custom_uploader.open();
        //    return;
        //}
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Scegli l\'immagine che preferisci',
            button: {
                text: 'Scegli immagine'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#'+id).val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
	
	
 
});