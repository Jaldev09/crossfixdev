<?php



/**
 * Namespace and imports.
 */
namespace Wisewebs\Javascript;
use Wisewebs\Classes\Content;
use Wisewebs\Classes\HusqvarnaXepc;
use Wisewebs\Classes\REST;
use Wisewebs\Classes\Utility;
use Wisewebs\Settings;



/**
 * Queue up the JavaScript files for the frontend.
 */
function frontend() {

	$mainJsDeps = Array(
		'jquery',
	);


	// Only load Google map on the Google map page
	if ( is_page_template( 'page_google-map.php' ) ) {

		// Load the Google maps API
		wp_enqueue_script(
			'google-maps-api',
			'https://maps.googleapis.com/maps/api/js?key=' . Content\GoogleMap::SETTING__API_KEY . '&language=' . Content\GoogleMap::SETTING__LANGUAGE . '&region=' . Content\GoogleMap::SETTING__REGION,
			array(),
			'3.0.0',
			true
		);

		// Add this to main.js' dependencies
		$mainJsDeps[] = 'google-maps-api';
	}

	// Our main JS file
	wp_enqueue_script(
		'main-js',
		get_template_directory_uri() . '/assets/js/main.js',
		$mainJsDeps,
		filemtime(
			get_template_directory() . '/assets/js/main.js'
		),
		true
	);

	// Run localize script to push the WP AJAX URL to our script
	wp_localize_script(
		'main-js',
		'wpGlobals',
		array(
			'ajaxUrl'                           => admin_url( 'admin-ajax.php' ),
			'husqvarnaXepcParentProductId'      => HusqvarnaXepc\HusqvarnaXepc::PRODUCT__PARENT_ID,
			'husqvarnaXepcParentProductSku'     => HusqvarnaXepc\HusqvarnaXepc::PRODUCT__PARENT_SKU,
			'husqvarnaXepcUrlGetProductInfoUrl' => '/wp-json/' . REST\REST::ROUTE__BASE . '/' . REST\REST::ROUTE__CURRENT_VERSION . '/' . HusqvarnaXepc\HusqvarnaXepc::REST_ROUTE__GET_PRODUCT_INFO,
		)
	);

	/* Localize the script with new data */
	$translation_array = array(
		'product_compare'        => esc_html__( 'Compare', 'wisewebs' ),
		'product_wishList'       => esc_html__( 'WishList', 'wisewebs' ),
		'product_wishList_added' => esc_html__( 'Browse WishList', 'wisewebs' ),
		'product_quickview'      => esc_html__( 'Quick View', 'wisewebs' ),
		'product_addtocart'      => esc_html__( 'Add To Cart', 'wisewebs' )
	);

	wp_localize_script( 'main-js', 'yolo_framework_constant', $translation_array );


	wp_localize_script( 'main-js', 'yolo_framework_ajax_url', get_site_url() . '/wp-admin/admin-ajax.php?activate-multi=true' );
	wp_localize_script( 'main-js', 'yolo_framework_theme_url', get_template_directory_uri() );
	wp_localize_script( 'main-js', 'yolo_framework_site_url', site_url() );
}

add_action(
	'wp_enqueue_scripts',
	__NAMESPACE__ . '\\frontend'
);





/**
 * Queue up the JavaScript files for the backend/admin area.
 */
function backend() {

	// Our main JS file
	wp_enqueue_script(
		'ww-admin-js',
		get_template_directory_uri() . '/assets/js/admin.js',
		Array(
			'jquery',
		),
		filemtime( get_template_directory() . '/assets/js/admin.js' ),
		true
	);
}

add_action(
	'admin_enqueue_scripts',
	__NAMESPACE__ . '\\backend'
);




// Dequeue script files we've included in main.js
function dequeueScripts() {

	wp_dequeue_script(    'yolo-megamenu-js' );
	wp_deregister_script( 'yolo-megamenu-js' );

	wp_dequeue_script(    'magnificPopup' );
	wp_deregister_script( 'magnificPopup' );

	wp_dequeue_script(    'yolo_add_to_cart_variation' );
	wp_deregister_script( 'yolo_add_to_cart_variation' );

	wp_dequeue_script(    'yolo-framework-app' );
	wp_deregister_script( 'yolo-framework-app' );

	wp_dequeue_script(    'jplayer-js' );
	wp_deregister_script( 'jplayer-js' );
}

add_action( 'wp_print_scripts', __NAMESPACE__ . "\\dequeueScripts" );

