<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;


// Import relevant namespaces
Use Wisewebs\Classes\WooCommerce;



wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<div class="cart-form">
<form action="<?php echo wc_get_cart_url(); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-name">
                        <?php
                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                        if ( ! $_product->is_visible() )
                            echo wp_kses_post($thumbnail);
                        else
                            printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
                        ?>

                        <div class="product-name-wrap">
                            <div class="product-name-inner">

						<?php
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

							// Meta data
							echo wc_get_formatted_cart_item_data( $cart_item );

               				// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'yolo-motor' ) . '</p>';
						?>
                            </div>
                        </div>
					</td>

					<td class="product-price">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<td class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-remove">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="cart-remove" title="%s"><i class="pe-7s-close"></i></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr__( 'Remove this item', 'yolo-motor' ) ), $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}
		do_action( 'woocommerce_cart_contents' );
?>
		<tr>
			<td colspan="5" class="actions top">
<?php
				if ( WC()->cart->coupons_enabled() )
				{
?>
					<div class="coupon">
						<label for="coupon_code">Rabattkod:</label> <input type="text" name="coupon_code" class="input-text coupon-input-field" id="coupon_code" value="" placeholder="Rabattkod" /> <input type="submit" class="button apply-coupon" name="apply_coupon" value="Applicera rabattkod" />
<?php
						do_action( 'woocommerce_cart_coupon' );
?>
					</div>
<?php
				}
?>
			</td>
		</tr>
		<tr>
			<td colspan="5" class="cart-collaterals-td">
				<div class="cart-collaterals">
<?php
					do_action( 'woocommerce_cart_collaterals' );
?>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="5" class="actions bottom">
				<div class="button-wrap">

					<button type="button" class="button update-cart">
						Uppdatera varukorg
					</button>

					<input type="submit" id="original-update-cart" class="button hide" name="update_cart" value="<?php esc_html_e( 'Update Cart', 'woocommerce' ); ?>" />
<?php
					WooCommerce\LastVisitedShopPage::backToLastPageButton();

					do_action( 'woocommerce_proceed_to_checkout' );
?>
				</div>
<?php

				do_action( 'woocommerce_cart_actions' );

				wp_nonce_field( 'woocommerce-cart' );
?>
			</td>
		</tr>
<?php
		do_action( 'woocommerce_after_cart_contents' );
?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
