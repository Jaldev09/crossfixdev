<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
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


// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
	exit;


global $post, $product;

$product_new = get_post_meta(
	get_the_ID(),
	'yolo_product_new',
	true
);

$product_hot = get_post_meta(
	get_the_ID(),
	'yolo_product_hot',
	true
);

?>
<div class="product-flash-wrap"><?php

	if ( $product->is_on_sale() ) {

		echo apply_filters(
			'woocommerce_sale_flash',
			'<span class="on-sale product-flash">' . esc_html__( 'Sale', 'woocommerce' ) . '!</span>',
			$post,
			$product
		);
	}


	if ( $product_new == 'yes' ) {
?>
		<span class="on-new product-flash">Ny</span>
<?php
	}


	if ( $product_hot == 'yes' ) {
?>
    <span class="on-hot product-flash">Populär</span>
<?php
	}


	if ( !$product->is_in_stock() ) {
?>
    <span class="on-sold product-flash">Slutsåld</span>
<?php
	}

?></div>
