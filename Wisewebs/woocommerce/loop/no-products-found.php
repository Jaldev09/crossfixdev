<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */


if ( is_search() ) {
?>
<p class="woocommerce-no-products">
	Vi hittade inga produkter som matchade.<br>
	<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">Klicka här för att se alla produkter</a>
</p>
<?php
}
