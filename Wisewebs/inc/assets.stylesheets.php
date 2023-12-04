<?php

// Set the namespace
Namespace Wisewebs\Stylesheets;


// Import relevant namespaces
Use Wisewebs\Classes\Utility;



/**
 * Queue up the stylesheets for the frontend.
 */
function frontendStyle() {

	wp_enqueue_style(
		'main-css',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		Utility\Cache::cacheBustResource(
			get_stylesheet_directory() . '/assets/css/main.css',
			false
		)
	);
}

add_action(
	'wp_enqueue_scripts',
	'Wisewebs\\Stylesheets\\frontendStyle'
);





/**
 * Queue up the stylesheets for the backend/admin area.
 */
function adminStyle() {

	wp_enqueue_style(
		'admin-css',
		get_template_directory_uri() . '/assets/css/admin/admin.css',
		array(),
		Utility\Cache::cacheBustResource(
			get_template_directory() . '/assets/css/admin/admin.css',
			false
		)
	);
}

add_action(
	'admin_enqueue_scripts',
	'Wisewebs\\Stylesheets\\adminStyle'
);





// Set the stylesheet to use for TinyMCE editors
add_editor_style(
	get_template_directory_uri() . '/assets/css/admin/tinymce.css'
);





// Dequeue stylesheets we've included in main.css
function dequeueStyle() {

	wp_dequeue_style(    'contact-form-7' );
	wp_deregister_style( 'contact-form-7' );


	wp_dequeue_style(    'yolo-megamenu-animate' );
	wp_deregister_style( 'yolo-megamenu-animate' );


	wp_dequeue_style(    'font-awesome' );
	wp_deregister_style( 'font-awesome' );

	wp_dequeue_style(    'font-awesome-animation' );
	wp_deregister_style( 'font-awesome-animation' );


	wp_dequeue_style(    'pe-icon-7-stroke' );
	wp_deregister_style( 'pe-icon-7-stroke' );


	wp_dequeue_style(    'owl-carousel' );
	wp_deregister_style( 'owl-carousel' );

	wp_dequeue_style(    'owl-carousel-theme' );
	wp_deregister_style( 'owl-carousel-theme' );

	wp_dequeue_style(    'owl-carousel-transitions' );
	wp_deregister_style( 'owl-carousel-transitions' );

	wp_dequeue_style(    'prettyPhoto' );
	wp_deregister_style( 'prettyPhoto' );

	wp_dequeue_style(    'peffect-scrollbar' );
	wp_deregister_style( 'peffect-scrollbar' );

	wp_dequeue_style(    'scrollbar' );
	wp_deregister_style( 'scrollbar' );

	wp_dequeue_style(    'jplayer-css' );
	wp_deregister_style( 'jplayer-css' );

	wp_dequeue_style(    'yolo-framework-style' );
	wp_deregister_style( 'yolo-framework-style' );

	wp_dequeue_style(    'yolo-framework-vc-customize-css' );
	wp_deregister_style( 'yolo-framework-vc-customize-css' );
}

add_action( 'wp_print_styles', 'Wisewebs\\Stylesheets\\dequeueStyle' );
