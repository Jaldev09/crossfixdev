<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = wc_get_related_products(
	$product->get_id(),
	$posts_per_page
);

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->get_id() )
) );

$products = new WP_Query( $args );

global $yolo_woocommerce_loop;
$yolo_options = yolo_get_options();
$related_product_display_columns = isset($_GET['columns']) ? $_GET['columns'] : '';
if (!in_array($related_product_display_columns, array('3','4','5','6'))) {
	$related_product_display_columns = $yolo_options['related_product_display_columns'] ? $yolo_options['related_product_display_columns'] : '4';
}

$yolo_woocommerce_loop['rating'] = 0;
$yolo_woocommerce_loop['columns'] = $related_product_display_columns;
$yolo_woocommerce_loop['layout'] = 'slider';



// We want to be able to select which products are shown here, so let's deactivate this block entirely for now.
if ( false && $products->have_posts() ) : ?>

	<div class="related products">
		<div class="container">
			<h4 class="widget-title"><span><?php esc_html_e( 'Related Products', 'yolo-motor' ); ?></span></h4>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

	                <?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>

	</div>

<?php endif;

wp_reset_postdata();
