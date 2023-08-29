
(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	 $( window ).load(function() {
	    const fbTemplate = document.getElementById('build-wrap');
		
		var options = {
			disableFields: ['autocomplete','checkbox-group','date','file','number','radio-group','select','starRating'],
			fieldRemoveWarn: true,
		  };
        window.formBuilder = $(fbTemplate).formBuilder(options);
		// // const ul_id=document.getElementById('frmb-1692171216809-control-box');
		// // ul_id.style.maxWidth="50%";
		// var fbEditor = document.getElementById('build-wrap');
		// var formBuilder = $(fbEditor).formBuilder();
		// document.getElementById('getJSON').addEventListener('click', function() {
		// 	alert(formBuilder.actions.getData('json', true));
		// });
			
		  
	 });
	

})( jQuery );
