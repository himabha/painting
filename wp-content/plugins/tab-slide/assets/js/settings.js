/*
 * Settings page front end
 */
jQuery(document).ready(function() {
	var myOptions, val, oldSelection, i;
	opt = j_options; 

	if ( opt.show_on_load == 1 ) {
		jQuery('#autoopen_timer').addClass('hidden');
		jQuery('#autohide_timer').addClass('shown');
	} else {
		jQuery('#autoopen_timer').addClass('shown');
		jQuery('#autohide_timer').addClass('hidden');
	}
	jQuery("input:checkbox[class*=show_on_load]").click(function () {
		jQuery('#autoopen_timer').toggleClass('hidden shown');
		jQuery('#autohide_timer').toggleClass('hidden shown');
		return;
	});
	function testValue(newOption) {
		for (i = 0; i < myOptions.length; i = i + 1) {
			if (newOption === myOptions[i]) {
				jQuery("#" + newOption).show();
				if (newOption !== "Custom") {
					//set the new template window url
					jQuery("#window_url").val("/templates/" + newOption + ".php");
					if (newOption !== "Widget" || newOption !== "iFrame" || newOption !== "Video" || newOption !== "Picture") {
					}
				}
			} else {
				jQuery("#" + myOptions[i]).hide();
			}
		}
	}
	oldSelection = opt.template_pick;
	jQuery("#template_select").bind(jQuery.browser.msie ? 'propertychange' : 'change', function (e) {
		e.preventDefault(); // Your code here 
		var selectValue, selectOption;
		//selectValue = jQuery('#template_select').val();
		selectValue = document.getElementById('template_select').value;
		selectOption = jQuery("#template_select option[value=" + selectValue + "]").text();
		jQuery("#template_pick").val(selectOption);
		jQuery("#template_select").click(testValue(selectOption));
	});
	jQuery("#template_select").change(function () {
		var selectValue, selectOption;
		selectValue = jQuery('#template_select').val();
		//selectValue = document.getElementById('template_select').value;
		selectOption = jQuery("#template_select option[value=" + selectValue + "]").text();
		jQuery("#template_pick").val(selectOption);
		jQuery("#template_select").change(testValue(selectOption));
	});
	myOptions = [];
	jQuery("#template_select").find('option').each(function () {
		val = jQuery(this).text();
		myOptions.push(val);
	});
	testValue(oldSelection);
	jQuery("select[name=template_select] option[value=" + oldSelection + "]").attr("selected", true);
	 
	if( jQuery(".no_borders").attr('checked')){
			jQuery('.border_size').hide();
	} else {
			jQuery('.border_size').show();
	}
	jQuery(".yes_borders").click(function(){
		jQuery('.border_size').show();
	});
	jQuery(".no_borders").click(function(){
		jQuery('.border_size').val("0");
		jQuery('.border_size').hide();
	});
	jQuery(".tab_title").click(function(){
		if( !jQuery(".cssonly").attr('checked')){
			jQuery('.tab_title_settings').show();
			jQuery('.tab_image_settings').hide();
		} else {
			jQuery('#tab_title_open').parent().show();
		}
	});
	jQuery(".tab_image").click(function(){
		if( !jQuery(".cssonly").attr('checked')){
			jQuery('.tab_title_settings').hide();
			jQuery('.tab_image_settings').show();
		} else {
			jQuery('#tab_title_open').parent().hide();
		}
	});
	jQuery('#bgcolorpicker').hide();
	jQuery("#background").click(function(){jQuery('#bgcolorpicker').slideToggle()});
	jQuery('#tabcolorpicker').hide();
	jQuery("#tab_color").click(function(){jQuery('#tabcolorpicker').slideToggle()});
	jQuery('#fontcolorpicker').hide();
	jQuery("#font_color").click(function(){jQuery('#fontcolorpicker').slideToggle()});
	if( jQuery(".cssonly").attr('checked')){
		jQuery('.peripheral').hide();
		jQuery('.css_only').show();
	} else {
		jQuery('.peripheral').show();
		jQuery('.css_only').hide();
	}
	jQuery('.tab-type-options').hide();
	if( jQuery(".cssonly").attr('checked') !=='checked'){
		jQuery('.tab_' + jQuery('#tab-type').val() + '_settings').show();
	} else {
		if(jQuery('#tab-type').val() === 'text') {
			jQuery('.tab-type-options').hide();
			jQuery('#tab-text-inputs').show();
		} else {
			jQuery('.tab-type-options').hide();
			jQuery('#tab-text-inputs').hide();
			if (jQuery('#tab-type').val() === 'scroll') {
				jQuery('.tab_scroll_settings').show();
			} else if (jQuery('#tab-type').val() === 'custom') {
				jQuery('.tab_custom_settings').show();
			}
		}
	}
	jQuery('#tab-type').on('change', function() {
		if( jQuery(".cssonly").attr('checked') !=='checked'){
			jQuery('.tab-type-options').hide();
			jQuery('.tab_' + this.value + '_settings').show();
			if(this.value === 'text') {
				jQuery('#tab-text-inputs').show();
			}
		} else {
			if(this.value === 'text') {
				jQuery('.tab-type-options').hide();
				jQuery('#tab-text-inputs').show();
			} else {
				jQuery('.tab-type-options').hide();
				jQuery('#tab-text-inputs').hide();
				if (this.value === 'custom') {
					jQuery('.tab_custom_settings').show();
				}
			}
		}
	});

	if( jQuery('#hook').val() === 'custom_filter' ){
		jQuery('.hook_custom').show();
	} else {
		jQuery('.hook_custom').hide();
	}	
	jQuery('#hook').on('change', function() {
		if( jQuery(this).val() ==='custom_filter'){
			jQuery('.hook_custom').show();
		} else {
			jQuery('.hook_custom').hide();
		}
	});

	jQuery(".cssonly").click(function(){
		jQuery('.peripheral').hide()
		jQuery('.css_only').show();
	});
	jQuery(".integratedcss").click(function(){
		jQuery('.peripheral').show()
		jQuery('.css_only').hide();
	});
	jQuery(".general").click(function(){
		jQuery('#advanced').hide()
		jQuery('#general').show();
		jQuery(".current").toggleClass('current');
		jQuery(".general").toggleClass('current');
	});
	jQuery(".advanced").click(function(){
		jQuery('#advanced').show()
		jQuery('#general').hide();
		jQuery(".current").toggleClass('current');
		jQuery(".advanced").toggleClass('current');
	});
	jQuery('#help').click(function(){
		jQuery('.description').toggleClass('hidden shown');//.css('display', 'block');
	});
	jQuery('#close-rate').click(function(){
    jQuery('#rate').animate({"right":"-200px"}, "slow");
  });
	jQuery('#overlay').click(function(){
		jQuery('#overlay').toggleClass('hidden shown');
		jQuery('#about').toggleClass('hidden shown');
	});
	jQuery('#close_about').click(function(){
		jQuery('#overlay').toggleClass('hidden shown');
		jQuery('#about').toggleClass('hidden shown');
	});
	jQuery('.about').click(function(){
			jQuery('#overlay').toggleClass('hidden shown');
			jQuery('#about').toggleClass('hidden shown');
	});
	jQuery('#bgcolorpicker').farbtastic(function(color){
		jQuery('#background').val(color);
		jQuery('#background').css('background', color);
	});
	
	jQuery('#tabcolorpicker').farbtastic(function(color){
		jQuery('#tab_color').val(color);
		jQuery('#tab_color').css('background', color);
	});
	jQuery('#fontcolorpicker').farbtastic(function(color){
		jQuery('#font_color').val(color);
		jQuery('#font_color').css('background', color);
	});
	jQuery('#opacity').on('change', function() {
		jQuery("#range").html(jQuery('#opacity').val());
	});
	if( jQuery('#list_pick').val() !== 'all' ) {
		jQuery('#list-pick-' + this.value).show();
	}
	jQuery('#list_pick').on('change', function() {		
		jQuery('.list-pick-sub').hide();
		if( this.value !== 'all' || this.value !== 'disabled' ) {
			jQuery('#list-pick-' + this.value).show();
		}
	});
	jQuery('#pro_api_key').on('click', function() {
		jQuery("#api_key_input").slideDown();
	});
	jQuery('#save_api_key').on('click', function() {
		jQuery("#api_key").val(jQuery("#api_key_input>input").val());
		jQuery('input[type="submit"]').click();
	});
	jQuery(window).scroll(function() {
    var wintop = jQuery(window).scrollTop(), docheight = jQuery(document).height(), winheight = jQuery(window).height();
    var  scrollTriggerStart = parseInt(1, 10)/100;
    var  scrollTriggerEnd = parseInt(100, 10)/100;
    jQuery('.tabslide-icon').removeClass('rotate');
    if ((wintop/(docheight-winheight)) >= scrollTriggerStart && scrollTriggerEnd >= (wintop/(docheight-winheight))) {
      jQuery('#header-wrapper').css({'background-color': '#FFFFFF', 'box-shadow': '0 0 1px #000000'});
      jQuery('.tabslide-icon').addClass('rotate');
    } else {
      jQuery('#header-wrapper').css({'background-color': 'none', 'box-shadow': 'none'}); 
    }   
  });
});
