<?php

// Set the namespace
Namespace Wisewebs;



/*=============================================
=            Runtime configuration            =
=============================================*/

	// Buffer all output
	ob_start();

	// Show all errors
	error_reporting( E_ALL );

	// Increase max execution time as we apparently actually need this
	ini_set( 'max_execution_time', 120 );

	// Core constants
	require_once 'inc/core.constants.php';

/*=====  End of Runtime configuration  ======*/





/*==========================================
=            Set up autoloading            =
==========================================*/

	// Get the autoloader
	require_once Settings\THEME_DIR . "/classes/autoloader/autoloader.php";

	// Register it for use
	Classes\Autoloader\Autoloader::register();

/*=====  End of Set up autoloading  ======*/





/*==========================================
=            Wordpress settings            =
==========================================*/

	/*----------  CSS & JS  ----------*/
	require_once Settings\THEME_DIR . '/inc/assets.stylesheets.php';
	require_once Settings\THEME_DIR . '/inc/assets.javascript.php';
	Classes\REST\REST::injectJSVariables();


	/*----------  Image sizes  ----------*/
	require_once Settings\THEME_DIR . '/inc/settings.image-sizes.php';


	/*----------  Roles  ----------*/
	require_once Settings\THEME_DIR . '/inc/settings.roles.php';


	/*----------  Menus  ----------*/
	require_once Settings\THEME_DIR . '/inc/settings.menus.php';


	/*----------  Shortcodes  ----------*/
	Classes\PartStream\PartStream::registerShortcodes();


	/*----------  REST API  ----------*/
	Classes\PartStream\PartStreamProduct::registerRESTRoutes();
	Classes\HusqvarnaXepc\HusqvarnaXepc::registerRestRoutes();
	Classes\Mail\OptionsPage::registerRESTRoutes();


	/*----------  Filters  ----------*/
	Classes\WooCommerce\WooCommerce::addFilters();
	Classes\WooCommerce\Orders::addFilters();
	Classes\PartStream\PartStreamProduct::addFilters();
	Classes\HusqvarnaXepc\HusqvarnaXepc::addFilters();


	/*----------  Options pages  ----------*/
	Classes\Mail\OptionsPage::registerOptionsPage();


	/*----------  Email  ----------*/
	Classes\Mail\Mail::configureSMTP();


	/*----------  Roles  ----------*/

	Classes\WordPress\Roles::registerUserRole( 'campaign_admin', 'Kampanjadmin' );
	Classes\WordPress\Roles::registerUserRole( 'webmaster', 'Webmaster' );


/*=====  End of Wordpress settings  ======*/





/*=======================================
=            Plugin settings            =
=======================================*/

	/*----------  ACF - Advanced Custom Fields  ----------*/
	require_once Settings\THEME_DIR . '/inc/settings.advanced-custom-fields.php';

	/*----------  WooCommerce  ----------*/
	require_once Settings\THEME_DIR . '/inc/settings.woocommerce.php';

	/*----------  Yoast SEO  ----------*/
	require_once Settings\THEME_DIR . '/inc/settings.yoast-seo.php';

/*=====  End of Plugin settings  ======*/
