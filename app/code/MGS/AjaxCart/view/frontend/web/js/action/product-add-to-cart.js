require([
    'jquery',
    'magnificPopup',
], function($) {
    jQuery('#product-addtocart-button').click(function(){
        var form = jQuery('#product_addtocart_form');
        var isValid = form.valid();
        if(isValid){
            jQuery(this).addClass('disabled tocart-loading');
            var data = form.serializeArray();
			var formData = new FormData();
            for(var i = 0; i < data.length; i++){
                formData.append(data[i].name, data[i].value);
            }
            var files = $('input[type="file"]');
            files.each(function(index){
                formData.append(files[index].name, files[index].files[0]);
            });
            formData.append('ajax', 1);
            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: 'post',
                dataType: 'json',
                contentType: false,       
                cache: false,             
                processData:false,
                success: function(response, status) {
					jQuery(this).removeClass('disabled tocart-loading');
                    if (status == 'success') {
                        if (response.ui) {
                            if(response.animationType){
                                var $content = '<div class="popup__main popup--result">'+response.ui + response.related + '</div>';                             
                                parent.jQuery.magnificPopup.open({
									mainClass: 'success-ajax--popup',
                                    items: {
                                        src: $content,
                                        type: 'inline'
                                    },
                                    closeOnBgClick: false,
                                    preloader: true,
                                    tLoading: ''
                                });
                            }else{
								parent.jQuery('html').addClass('add-item-success');
								
                                parent.jQuery.magnificPopup.close();
                            }                       
                        }
                    }
                }
            });
            return false;
        }else {
			jQuery('#product-addtocart-button').removeClass('disabled tocart-loading');
		}
    });
});