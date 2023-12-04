<?php
/**
 * Template for WooCommerce product link lists.
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
$moduleName = 'product-listing-links';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );
?>
<div class="<?php $BEMHelper(); ?>">
<?php
	// If we have any products to show
	if ( have_posts() )
	{
		/**
		 * woocommerce_before_shop_loop hook
		 *
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );

		// Run whatever Woo feels like
		woocommerce_product_loop_start();
?>
		<div class="<?php $BEMHelper( 'products-wrap' ); ?>">
<?php
			// Loop posts
			while ( have_posts() )
			{
				// Setup postdata
				the_post();

				// Get product link template
				get_template_part( 'modules/product/product-listing-link' );
			}
?>
		</div>
<?php
		woocommerce_product_loop_end();

		/**
		 * woocommerce_after_shop_loop hook
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	}
	else if
	(
		! woocommerce_product_subcategories(
			[
				'before' => woocommerce_product_loop_start( false ),
				'after' => woocommerce_product_loop_end( false )
			]
		)
	)
	{
		wc_get_template( 'loop/no-products-found.php' );
	}
?>
</div>
