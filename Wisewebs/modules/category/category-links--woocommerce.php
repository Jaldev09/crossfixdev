<?php
/**
 * Template for WooCommerce product categories.
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

// Prep args to use for fetching categories
$args =
[
	'taxonomy' => 'product_cat'
];

// If it's a product category (i.e. not root page)
if ( is_product_category() )
{
	// Get only the categories in it
	$args[ 'parent' ] = get_queried_object()->term_id;
}
// If it's the root page
else
{
	// Get only top level categories
	$args[ 'parent' ] = 0;
}

// Get WooCommerce product categories WP_Term objects
$categories = get_terms( $args );

// If we found at least one category
if ( 0 < count( $categories ) )
{
	// Filter categories
	$categories = array_filter(
		$categories,
		function( $category )
		{
			// Filter out the "uncategorized" category
			if ( ! empty( $category->slug ) && 'okategoriserad' === $category->slug )
			{
				return false;
			}

			// Other scenarios are fine
			return true;
		}
	);
?>
	<div class="<?php $BEMHelper( '', [ 'woocommerce' => true, ] ); ?>">
<?php
		// Loop categories
		foreach ( $categories as $category )
		{
			// Make variables global
			global $link;
			global $title;
			global $fieldModifier;

			// Get permalink
			$link = get_term_link( $category->term_id );

			// Default to using category name as title
			$title = $category->name;

			// Set field modifier
			$fieldModifier = 'product_cat_' . $category->term_id;

			// Category link
			get_template_part( 'modules/category/category-link' );
		}
?>
	</div>
<?php
}