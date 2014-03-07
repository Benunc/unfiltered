jQuery(function( $ ){

	$(".genesis-nav-menu").addClass("header-menu").before('<div id="header-menu-icon"></div>');

	$("#header-menu-icon").click(function(){
		$(".genesis-nav-menu").fadeToggle();
	});

});