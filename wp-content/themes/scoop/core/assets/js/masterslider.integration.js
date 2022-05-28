/* global PojoSliders */

var MasterSliderIntegration = ( function( $, window ) {
	var is_rtl = false,
		
		_pojo_slides = [],

		_init = function() {
			//var PojoSliders = PojoSliders || [];
			if ( 'undefined' !== typeof PojoSliders ) {
				$.each( PojoSliders, function( index, slider_options ) {
					_pojo_slides[ index ] = new MasterSlider();
					_pojo_slides[ index ].setup( slider_options.id, slider_options.params );
					
					if ( slider_options.arrows ) {
						_pojo_slides[ index ].control( 'arrows' );
					}
					
					if ( slider_options.thumblist ) {
						_pojo_slides[ index ].control( 'thumblist', slider_options.thumblist_params );
					}
					
					if ( slider_options.bullets ) {
						_pojo_slides[ index ].control( 'bullets', slider_options.bullets_params );
					}
					
					if ( slider_options.lightbox ) {
						_pojo_slides[ index ].control( 'lightbox' );
					}
				} );
			}
		};
	
	return {
		init: _init
	};
} ( jQuery, window ) );