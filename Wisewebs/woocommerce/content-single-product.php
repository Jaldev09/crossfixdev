<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */


// Prevent direct access to the file
if ( !defined( 'ABSPATH' ) )
	die;


// Import relevant namespaces
Use Wisewebs\Classes\Content;


/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="single-product-info clearfix">
		<div class="single-product-image-wrap">
			<div class="single-product-image">
				<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
				?>

			</div>
		</div>

		<div class="summary-product-wrap">
			<div class="summary-product entry-summary">
				<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked yolo_woocommerce_template_single_function - 35
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				// remove_action( 'woocommerce_single_product_summary','yolo_woocommerce_template_single_function', 35);
				// add_action( 'woocommerce_single_product_summary','yolo_woocommerce_template_single_function', 45);
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>
	</div>

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		do_action( 'woocommerce_after_single_product_summary' );
		// add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
<?php

do_action( 'woocommerce_after_single_product' );
