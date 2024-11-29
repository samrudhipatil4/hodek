$( document ).ready(function(){

	//Main Left Sidebar Chat
	$('.button-collapse').sideNav({
	    menuWidth: 260,
	    edge: 'right',
	});	 
	
	$('.close-rightbar').click(function() {
	    $('.button-collapse').sideNav('hide');
	});
	
	$('.button-collapse').collapsible({
	    accordion: false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
	});

	//profile dropdown	
	var $nav = $('#right-nav li');
	$nav.hover(
		function() {
			$('ul', this).stop(true, true).slideDown(300);
		},
		function() {
			$('ul', this).slideUp(300);
		}
	);
	
	// scroll bar initialization	
	/*$('#ps-container ps-active-y').perfectScrollbar({
          wheelSpeed: 20,
          wheelPropagation: false
    });*/

	// Tooltip initaiiztion
	$('.tooltipped').tooltip({delay: 50});

	//select box
	
	$('select').not('.disabled').material_select();

});