<?php
/**
 * Template for WooCommerce product links.
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
$moduleName = 'product-listing-link';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );
?>
<div class="<?php $BEMHelper(); ?>">
	<a class="<?php $BEMHelper( 'thumbnail' ); ?> product-thumb" href="<?php the_permalink(); ?>">
<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 * @hooked yolo_woocomerce_template_loop_link - 20
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
?>
		<div class="<?php $BEMHelper( 'hover-sign' ); ?>">
			<hr>
			<hr>
		</div>
	</a>
	<a class="<?php $BEMHelper( 'information' ); ?> product-info" href="<?php the_permalink(); ?>">
<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 * @hooked woocommerce_template_loop_product_title - 15
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
?>
	</a>
	<div class="<?php $BEMHelper( 'actions' ); ?> product-actions">
<?php
		/**
		 * yolo_woocommerce_product_actions hook
		 *
		 * @hooked yolo_woocomerce_template_loop_compare - 5
		 * @hooked yolo_woocomerce_template_loop_wishlist - 10
		 * @hooked woocommerce_template_loop_add_to_cart - 20
		 * @hooked yolo_woocomerce_template_loop_quick_view - 25
		 */
		do_action( 'yolo_woocommerce_product_actions' );
?>
	</div>
</div>
