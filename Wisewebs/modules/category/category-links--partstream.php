<?php
/**
 * Template for Partstream categories.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;



/**
 * Runtime.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'category-links';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

$subPages = query_posts(
	[
		'post_type'   => 'page',
		'post_parent' =>  get_the_ID(),
	]
);

// Sort array manually as WP's `'orderby' => 'menu_order',` apparently removes anything with order `0`
usort(
	$subPages,
	function( $a, $b )
	{
		return $a->menu_order <=> $b->menu_order;
	}
);

// If we found at least one child page
if ( 0 < count( $subPages ) )
{
?>
	<div class="<?php $BEMHelper( '', [ 'partstream' => true, ] ); ?>">
<?php
		// Loop child pages
		foreach ( $subPages as $subPage )
		{
			// Setup postdata for the post
			setup_postdata( $subPage );

			// Make variables global
			global $link;
			global $title;
			global $fieldModifier;

			// Get permalink
			$link = get_permalink( $subPage );

			// Default to using child page name as title
			$title = get_the_title( $subPage );

			// Set field modifier
			$fieldModifier = ( int ) $subPage->ID;

			// Category link
			get_template_part( 'modules/category/category-link' );
		}

		// Restore postdata
		wp_reset_postdata();
?>
	</div>
<?php
}
