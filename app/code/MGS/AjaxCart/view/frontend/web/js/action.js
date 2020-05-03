define([
    'jquery',
    'MGS_AjaxCart/js/config',
    'magnificPopup'
], function($, mgsConfig) {
    "use strict";

    jQuery.widget('mgs.action', {
        options: {
            requestParamName: mgsConfig.requestParamName
        },
        fire: function(tag, actionId, url, formData, redirectToCatalog) {
            this._fire(tag, actionId, url, formData);
        },
        _fire: function(tag, actionId, url, formData) {
            if(tag.find('.tocart').length){
                tag.find('.tocart').addClass('tocart-loading');
            }else{
                tag.addClass('tocart-loading');
            }           
            var self = this;
            formData.append(this.options.requestParamName, 1);
            
            jQuery.ajax({
                url: url,
                data: formData,
                type: 'post',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false, 
                beforeSend: function(xhr, options) {
					if(tag.find('.tocart').length){
						tag.find('.tocart').addClass('disabled');
					}else{
						tag.addClass('disabled');
					} 
                },
                success: function(response, status) {
					if(tag.find('.tocart').length){
						tag.find('.tocart').removeClass('tocart-loading');
					}else{
						tag.removeClass('tocart-loading');
					}
                    if (status == 'success') {
                        if(response.backUrl){
                            data.push({
                                name: 'action_url',
                                value: response.backUrl
                            });
                            self._fire(tag, actionId, response.backUrl, data);
                        }else{
                            if (response.ui) {
                                if(response.productView){
									jQuery.magnificPopup.open({
										items: {
											src: response.ui,
											type: 'iframe'
										},
										mainClass: 'form-ajax--popup',
										closeOnBgClick: false,
										preloader: true,
										tLoading: '',
										callbacks: {
											open: function() {
												jQuery('.mfp-preloader').css('display', 'block');
											},
											beforeClose: function() {
												var url_cart_update = mgsConfig.updateCartUrl;
												jQuery('[data-block="minicart"]').trigger('contentLoading');
												jQuery.ajax({
													url: url_cart_update,
													method: "POST"
												});
											},
											close: function() {
												jQuery('.mfp-preloader').css('display', 'none');
											},
											afterClose: function() {
												if(!response.animationType) {
													if(!parent.jQuery.magnificPopup.instance.isOpen) {
														if(jQuery('html').hasClass('add-item-success')){
															var $source = '';
															if(tag.find('.tocart').length){
																if(tag.closest('.product-item-info').length){
																	$source = tag.closest('.product-item-info');
																	var width = $source.outerWidth();
																	var height = $source.outerHeight();
																}else{
																	$source = tag.find('.tocart');
																	var width = 300;
																	var height = 300;
																}
																
															}else{
																var width = $source.outerWidth();
																var height = $source.outerHeight();
															}
															
															var $animatedObject = jQuery('<div class="flycart-animated-add" style="position: absolute;z-index: 99999;">'+response.image+'</div>');
															
															var left = $source.offset().left;
															var top = $source.offset().top;
															
															$animatedObject.css({top: top-1, left: left-1});
															jQuery('html').append($animatedObject);
															
															jQuery('#footer-cart-trigger').addClass('active');
															jQuery('#footer-mini-cart').slideDown(300);
															
															var gotoX = jQuery("#fixed-cart-footer").offset().left + 20;
															var gotoY = jQuery("#fixed-cart-footer").offset().top;                                          
															$animatedObject.animate({
																opacity: 0.6,
																left: gotoX,
																top: gotoY
															}, 2000,
															function () {
																$animatedObject.fadeOut('fast', function () {
																	$animatedObject.remove();
																	jQuery('html').removeClass('add-item-success');
																});
															});
														}
													} else {
														var $content = '<div></div><div class="popup__main popup--result">'+response.ui + response.related + '</div>';
														parent.jQuery.magnificPopup.instance.items[0] = {src: $content, type: 'inline'};
														parent.jQuery.magnificPopup.instance.mainClass = 'success-ajax--popup';
														parent.jQuery.magnificPopup.instance.updateItemHTML();
														parent.truncateOptions();
														parent.replaceStrings();
													}
												}
											}
										}
									});
                                }else{
                                    var $content = '<div class="popup__main popup--result">'+response.ui + response.related + '</div>';
                                    if(response.animationType) {
                                        if(parent.jQuery.magnificPopup.instance.isOpen){
                                            parent.jQuery.magnificPopup.instance.items[0] = {src: $content, type: 'inline'};
                                            parent.jQuery.magnificPopup.instance.mainClass = 'success-ajax--popup';
                                            parent.jQuery.magnificPopup.instance.updateItemHTML();
                                            parent.truncateOptions();
                                            parent.replaceStrings();
                                        }else {
                                            jQuery.magnificPopup.open({
                                                mainClass: 'success-ajax--popup',
                                                items: {
                                                    src: $content,
                                                    type: 'inline'
                                                },
                                                callbacks: {
                                                    beforeClose: function() {
                                                        var url_cart_update = mgsConfig.updateCartUrl;
                                                        jQuery('[data-block="minicart"]').trigger('contentLoading');
                                                        jQuery.ajax({
                                                            url: url_cart_update,
                                                            method: "POST"
                                                        });
                                                    }  
                                                }
                                            });
                                        }
                                    }else{
										if(!parent.jQuery.magnificPopup.instance.isOpen) {
                                            /* Fly Cart Type */  
                                            var $source = '';
                                            if(tag.find('.tocart').length){
                                                if(tag.closest('.product-item-info').length){
                                                    $source = tag.closest('.product-item-info');
                                                    var width = $source.outerWidth();
                                                    var height = $source.outerHeight();
                                                }else{
                                                    $source = tag.find('.tocart');
                                                    var width = 300;
                                                    var height = 300;
                                                }
                                                
                                            }else{
                                                tag.removeClass('disabled');
                                                tag.find('.icon').removeClass('fa-spin');
                                                tag.find('.text').text(textCart);
                                                tag.find('.icon').removeClass('pe-7s-config');
                                                tag.find('.icon').addClass('pe-7s-shopbag');
                                                $source = tag.closest('.product-item-info');
                                                var width = $source.outerWidth();
                                                var height = $source.outerHeight();
                                            }
                                            
                                            var $animatedObject = jQuery('<div class="flycart-animated-add" style="position: absolute;z-index: 99999;">'+response.image+'</div>');
                                            var left = $source.offset().left;
                                            var top = $source.offset().top;
                                            
                                            $animatedObject.css({top: top-1, left: left-1});
                                            jQuery('html').append($animatedObject);
                                            
                                            var gotoX = jQuery("#fixed-cart-footer").offset().left + 20;
                                            var gotoY = jQuery("#fixed-cart-footer").offset().top;      
                                            
                                            jQuery('#footer-cart-trigger').addClass('active');
                                            jQuery('#footer-mini-cart').slideDown(300);
                                            
                                            $animatedObject.animate({
                                                opacity: 0.6,
                                                left: gotoX,
                                                top: gotoY
                                            }, 2000,
                                            function () {
												$animatedObject.fadeOut('fast', function () {
													$animatedObject.remove();
												});
                                            });
                                        }else {
											parent.jQuery.magnificPopup.close();
											
											var $animatedObject = parent.jQuery('<div class="flycart-animated-add" style="position: fixed;z-index: 99999; bottom: 50%; left: 50%;">'+response.image+'</div>');
                                            
                                            parent.jQuery('html').append($animatedObject);
                                            
                                            var gotoX = parent.jQuery("#fixed-cart-footer").offset().left + 20;
                                            var gotoY = parent.jQuery("#fixed-cart-footer").offset().top;      
                                            
                                            parent.jQuery('#footer-cart-trigger').addClass('active');
                                            parent.jQuery('#footer-mini-cart').slideDown(300);
                                            
											
                                            $animatedObject.animate({
                                                opacity: 0.6,
                                                left: 20,
                                                bottom: 0
                                            }, 2000,
                                            function () {
												$animatedObject.fadeOut('fast', function () {
													$animatedObject.remove();
												});
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                error: function() {
                    window.location.href = mgsConfig.redirectCartUrl;
                }
            });
        }
    });

    return jQuery.mgs.action;
});