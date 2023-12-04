<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$yolo_options = yolo_get_options();
$both_button = '';
if (isset($yolo_options['header_shopping_cart_button'])
	&& ($yolo_options['header_shopping_cart_button']['view-cart'] == '1')
	&& ($yolo_options['header_shopping_cart_button']['checkout'] == '1')) {
	$both_button = 'both-buttons';
}

if (!isset($args) || !isset($args['list_class'])) {
	$args['list_class'] = '';
}
$cart_list_sub_class = array();
$cart_list_sub_class[] = 'cart_list_wrapper';
if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
	$cart_list_sub_class[] = 'has-cart';
}

?>
<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<div class="widget_shopping_cart_icon">
	<svg
		class="basket-icon"
		height="60.000000pt"
		preserveAspectRatio="xMidYMid meet"
		version="1.0"
		viewBox="0 0 48.000000 60.000000"
		width="48.000000pt"
		xmlns="http://www.w3.org/2000/svg"
	>
		<g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)"
		fill="#000000" stroke="none">
			<path d="M238 590 c-13 -1 -35 -7 -50 -16 -15 -8 -35 -28 -43 -44 -8 -16 -15 -36 -15 -45 0 -11 -10 -15 -40 -15 -37 0 -40 -2 -49 -37 -6 -21 -11 -59 -11 -84 0 -25 -5 -93 -11 -151 -9 -92 -8 -111 5 -137 9 -17 25 -35 35 -41 11 -6 89 -10 181 -10 92 0 170 4 181 10 10 6 26 24 35 41 13 26 14 45 5 137 -6 58 -11 126 -11 151 0 25 -5 63 -11 84 -9 35 -12 37 -49 37 -30 0 -40 4 -40 15 0 9 -7 29 -15 45 -9 16 -29 36 -45 45 -16 8 -39 15 -52 15z m2 -40 c15 0 37 -8 48 -17 12 -10 22 -27 24 -38 3 -18 -3 -20 -72 -20 -69 0 -75 2 -72 20 2 11 12 28 24 38 11 9 33 17 48 17z m-139 -110 c23 0 28 -5 31 -27 2 -14 9 -28 16 -31 8 -2 12 7 12 27 l0 31 80 0 80 0 0 -31 c0 -20 4 -29 13 -27 6 3 13 17 15 31 3 22 8 27 31 27 27 0 28 -2 35 -67 3 -38 9 -120 12 -184 7 -114 7 -116 -17 -132 -19 -14 -50 -17 -169 -17 -119 0 -150 3 -169 17 -24 16 -24 18 -17 132 3 64 9 146 12 184 7 65 8 67 35 67z"/>
		</g>
	</svg>

	<span class="total"><?php echo sizeof( WC()->cart->get_cart()); ?></span>
</div>
<div class="sub-total-text"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
<div class="<?php yolo_the_attr_value($cart_list_sub_class) ?>">
	<ul class="cart_list product_list_widget scrollbar-inner <?php echo esc_attr($args['list_class']); ?>">
		<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

					?>
					<li>
						<div class="cart-left">
							<?php if ( ! $_product->is_visible() ) { ?>
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
							<?php } else { ?>
								<a href="<?php echo get_permalink( $product_id ); ?>">
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
								</a>
							<?php } ?>
						</div>
						<div class="cart-right">
							<?php if ( ! $_product->is_visible() ) { ?>
								<?php echo $product_name; ?>
							<?php } else { ?>
								<a href="<?php echo get_permalink( $product_id ); ?>">
									<?php echo $product_name; ?>
								</a>
							<?php } ?>
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>

							<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="mini-cart-remove" title="%s"><i class="pe-7s-close"></i></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr__( 'Remove this item', 'woocommerce' ) ), $cart_item_key );?>
						</div>
					</li>
				<?php
				}
			}
			?>

		<?php else : ?>
			<li class="empty">
				<h4><?php esc_html_e( 'Varukorgen är tom', 'woocommerce' ); ?></h4>
				<p><?php esc_html_e( 'Du har inte lagt några varor i varukorgen ännu', 'woocommerce' ); ?></p>
			</li>
		<?php endif; ?>

	</ul><!-- end product list -->

	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
		<div class="cart-total">
			<p class="total"><strong><?php esc_html_e( 'Total', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<p class="buttons <?php echo esc_attr($both_button) ?>">
				<?php if (isset($yolo_options['header_shopping_cart_button']) && ($yolo_options['header_shopping_cart_button']['view-cart'] == '1')):?>
					<a href="<?php echo wc_get_cart_url(); ?>" class="button wc-forward">Visa varukorg</a>
				<?php endif; ?>
				<?php if (isset($yolo_options['header_shopping_cart_button']) && ($yolo_options['header_shopping_cart_button']['checkout'] == '1')):?>
					<a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>