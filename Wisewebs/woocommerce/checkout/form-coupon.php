<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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
if ( !defined( 'ABSPATH' ) )
	exit;


if ( !WC()->cart->coupons_enabled() )
	return;


$info_message =
	apply_filters(
		'woocommerce_checkout_coupon_message',
		esc_html__(
			'Have a coupon?',
			'woocommerce'
		) .
		' <a href="#" class="showcoupon">' .
			esc_html__(
				'Click here to enter your code',
				'woocommerce'
			) .
		'</a>'
	);
?>
<div class="woocommerce-checkout-info">
	<?php echo wp_kses_post( $info_message ); ?>
</div>

<form class="checkout_coupon" method="post" style="display:none">

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="Rabattkod" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<input type="submit" class="button apply-coupon" name="apply_coupon" value="Applicera rabattkod" />
	</p>

	<div class="clear"></div>
</form>
