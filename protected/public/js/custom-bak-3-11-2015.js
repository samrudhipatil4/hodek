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
	
	$('.multiselect-box .selected-label').click( function( event){
		event.stopPropagation();
		$(this).next().slideToggle(300);	

		if ($(this).find('i').hasClass('fa-chevron-down')){
	       $(this).find('i').removeClass('fa-chevron-down').addClass('fa-times');
		}
	    else{
	       $(this).find('i').removeClass('fa-times').addClass('fa-chevron-down');
	    }	    

	});

	
	/*	
	$('.browser-default').on('focus', function() {
    	//$(this).find('option').css({'color':'#000'});
    	$(this).css({'opacity':'1', 'outline':'0'});
    	$(this).parent().find('label').addClass('active');    	
	});
	*/


	// Tooltip initialization
	$('.tooltipped').tooltip({delay: 50});

	//select box	
	$('select').not('.disabled').material_select();

	//Materialize.toast(message, displayLength, className, completeCallback);
  	//Materialize.toast('I am a toast!', 4000) 


});