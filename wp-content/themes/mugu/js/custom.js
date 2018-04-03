
jQuery(document).ready(function($){

    $('html').click(function() {
		$('.form-holder').slideUp(); 
	});

	$('.search').click(function(event){
		event.stopPropagation();
	});

	$(".fa-search").click(function(){
		$(".form-holder").slideToggle();
			return false;
	});

	$('#responsive-menu-button').sidr({
    	name: 'sidr-main',
    	source: '#site-navigation',
    	side: 'right'
    });

    /* Equal Height */
     $('.post-section .post').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });

});




