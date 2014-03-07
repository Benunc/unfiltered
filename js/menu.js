jQuery(function( $ ){

	$(".genesis-nav-menu").addClass("responsive-menu").before('<div id="responsive-menu-icon"></div>');

	$("#responsive-menu-icon").click(function(){
		$(".genesis-nav-menu").fadeToggle();
	});

});