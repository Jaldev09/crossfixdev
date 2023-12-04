<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

// Prevent direct access to the file
if ( !defined( 'ABSPATH' ) )
	die;


// Import relevant namespaces
Use Wisewebs\Classes\Content;





global $yolo_woocommerce_loop;
$yolo_options = yolo_get_options();
$prefix = 'yolo_';

$layout_style = isset($_GET['layout']) ? $_GET['layout'] : '';
if (!in_array($layout_style, array('full','container','container-fluid'))) {
	$layout_style = get_post_meta(get_the_ID(),$prefix.'page_layout',true);
	if (($layout_style === '') || ($layout_style == '-1')) {
		$layout_style = $yolo_options['single_product_layout'] ? $yolo_options['single_product_layout'] : 'container';
	}
}

$sidebar = isset($_GET['sidebar']) ? $_GET['sidebar'] : '';
if (!in_array($sidebar, array('none','left','right','both'))) {
	$sidebar = get_post_meta(get_the_ID(),$prefix.'page_sidebar',true);
	if (($sidebar === '') || ($sidebar == '-1')) {
		$sidebar = $yolo_options['single_product_sidebar'];
	}
}

$left_sidebar = get_post_meta(get_the_ID(),$prefix.'page_left_sidebar',true);
if (($left_sidebar === '') || ($left_sidebar == '-1')) {
	$left_sidebar = $yolo_options['single_product_left_sidebar'];
}

$right_sidebar = get_post_meta(get_the_ID(),$prefix.'page_right_sidebar',true);
if (($right_sidebar === '') || ($right_sidebar == '-1')) {
	$right_sidebar = $yolo_options['single_product_right_sidebar'];
}

$sidebar_width = isset($_GET['sidebar_width']) ? $_GET['sidebar_width'] : '';
if (!in_array($sidebar_width, array('small','large'))) {
	$sidebar_width = get_post_meta(get_the_ID(),$prefix.'sidebar_width',true);
	if (($sidebar_width === '') || ($sidebar_width == '-1')) {
		$sidebar_width = $yolo_options['single_product_sidebar_width'];
	}
}


// Calculate sidebar column & content column
$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
	$sidebar_col = 'col-md-4';
}

$content_col_number = 12;
if (is_active_sidebar($left_sidebar) && (($sidebar == 'both') || ($sidebar == 'left'))) {
	if ($sidebar_width == 'large') {
		$content_col_number -= 4;
	} else {
		$content_col_number -= 3;
	}
}
if (is_active_sidebar($right_sidebar) && (($sidebar == 'both') || ($sidebar == 'right'))) {
	if ($sidebar_width == 'large') {
		$content_col_number -= 4;
	} else {
		$content_col_number -= 3;
	}
}

$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
	$content_col = '';
}
$main_class = array('single-product-wrap');
if ($content_col_number < 12) {
	$main_class[] = 'has-sidebar';
}
get_header( 'shop' ); ?>

<?php
/**
 * @hooked - yolo_page_heading - 5
 **/
// do_action('yolo_before_page');
?>
<main class="<?php echo join(' ',$main_class) ?>">
<?php
	get_template_part( 'modules/breadcrumbs/breadcrumbs--woocommerce' );
?>
	<div class="<?php echo esc_attr($layout_style) ?> clearfix">

		<?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
		<div class="row clearfix">
		<?php endif;?>

			<?php if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'left') || ($sidebar == 'both'))) : ?>
				<div class="sidebar woocommerce-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs">
					<?php dynamic_sidebar( $left_sidebar ); ?>
				</div>
			<?php endif; ?>

			<div class="site-content-single-product <?php echo esc_attr($content_col) ?>">
				<div class="single-product-inner">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php endwhile; // end of the loop. ?>
				</div>
			</div>


			<?php if ( is_active_sidebar( $right_sidebar ) && (($sidebar == 'right') || ($sidebar == 'both')) ) : ?>
				<div class="sidebar woocommerce-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs">
					<?php dynamic_sidebar( $right_sidebar );?>
				</div>
			<?php endif; ?>

		<?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
		</div>
		<?php endif;?>

	</div>
<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

		do_action( 'woocommerce_after_single_product_summary' );

		// add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
?>
<?php 
global $product;
echo '<div class="container product-description"><h2>Productbeskrivning</h2>' . wpautop(wptexturize($product->get_description())) . '</div>';
?>
</main>
<div class="s-product-recommendations">
<?php
	woocommerce_upsell_display();
	woocommerce_output_related_products();
?>
</div>
<div class="container related-products ">
	
<?php
$related_products = wc_get_related_products(get_the_ID(), 5); // Adjust the number as needed

if (count($related_products) > 0) {
	
	echo '<h2>Likande produkter</h2>';
	echo '<ul class="rel-products-slider owl-carousel owl-theme">';
	
	foreach ($related_products as $related_product_id) {
		$related_product = wc_get_product($related_product_id);
		echo '<li class="product item">';
		echo '<a href="' . esc_url(get_permalink($related_product_id)) . '">';
		echo $related_product->get_image();
		echo '<span class="price">' . $related_product->get_price_html() . '</span>'; // Add product price
		echo '<h3>' . esc_html($related_product->get_title()) . '</h3>';
		echo '</a>';
		echo '</li>';
	}
	
	echo '</ul>';
	
}
?>
</div>
<?php

// Print the cards as they appear on the frontpage
Content\Cards::output(
	get_field(
		Content\Cards::FIELD_NAME,
		'option'
	)
);


// Print the logotype list as it appears on the frontpage
Content\LogotypeList::output(
	get_field(
		Content\LogotypeList::FIELD_NAME,
		'option'
	)
);


get_footer( 'shop' );
