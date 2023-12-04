<?php
/**
 * WooCommerce related settings.
 */


// Set namespace
Namespace Wisewebs\Settings;



// Yoast adds descriptions to WooCommerce categories, but neglects to run them through the same filters as standard WP posts. We need shortcodes, so we'll have to manually register that filter.
add_filter(
	'term_description',
	'do_shortcode'
);
