<?php
/*
 * The main site footer.
 */



// Import relevant namespaces
use Wisewebs\Classes\Content;

// Finish up some missing HTML-tags that are misplacing the admin bar
?>
		</div>
<?php
		// Get the relevant template
		get_template_part( 'modules/footer/footer' );
?>
	</div>
	<!-- END: Yolo content wrapper -->
<!-- </div> -->
<!-- END: Perspective-wrapper -->
<?php
if ( empty( $GLOBALS[ 'popup-forms' ] ) || ! is_array( $GLOBALS[ 'popup-forms' ] ) )
{
	$GLOBALS[ 'popup-forms' ] = array();
}

// Get contact forms
$contactForms = get_posts(
	[
		'post_type'   => 'wpcf7_contact_form',
		'numberposts' => -1,
	]
);

// Loop forms
foreach ( $contactForms as $contactForm )
{
	// If it's the service booking form (accessible everywhere via header) or a form used in content
	if ( 286 === ( int ) $contactForm->ID || in_array( $contactForm->ID, $GLOBALS[ 'popup-forms' ] ) )
	{
?>
		<div class="custom-popup popup-form" id="popup-form-<?php echo $contactForm->ID; ?>">
			<div class="popup-form__outer-wrap">
				<div class="popup-form__overlay">
				</div>
				<div class="popup-form__wrap">
					<div class="popup-form__inner-wrap">
						<h2 class="custom-popup__heading popup-form__heading">
<?php
							echo str_replace(
								[
									'frågor',
									'service',
									'rådgivning',
								],
								[
									'<span>frågor</span>',
									'<span>service</span>',
									'<span>rådgivning</span>',
								],
								$contactForm->post_title
							);
?>
						</h2>
<?php
						echo do_shortcode( '[contact-form-7 id="' . $contactForm->ID . '" title="' . $contactForm->post_title . '"]' );
?>
					</div>
					<button type="button" class="custom-popup__close-button popup-form__close-button">
						<i class="fa fa-close"></i>
					</button>
				</div>
			</div>
		</div>
<?php
	}
}

global $addXepcPopup;

if ( ! empty( $addXepcPopup ) && true === $addXepcPopup )
{
?>
	<div class="custom-popup husqvarna-xepc-popup">
		<div class="husqvarna-xepc-popup__overlay"></div>
		<div class="husqvarna-xepc-popup__wrapper">
			<div class="husqvarna-xepc-popup__content">
				<h2 class="custom-popup__heading">Lägg i <span>varukorgen</span></h2>

				<div class="husqvarna-xepc-popup__loading">
					<i class="fa fa-spinner fa-spin"></i>
					<span class="husqvarna-xepc-popup__loading-text">Hämtar reservdelsinformation...</span>
				</div>

				<div class="husqvarna-xepc-popup__price-unavailable">
					<p><a href="/kontakta-oss/">Kontakta oss</a> för information om reservdelen.</p>
				</div>

				<div class="husqvarna-xepc-popup__product-info summary-product-wrap">
					<div class="woocommerce-variation-add-to-cart variations_button">
						<form action="" class="cart">
							<div class="add-to-cart-wrap">

								<div class="husqvarna-xepc-popup__product-title-wrapper">
									<span class="woocommerce-Price-amount amount">
										<label>Beskrivning:</label> <span class="husqvarna-xepc-popup__product-title"></span>
									</span>
								</div>

								<div class="husqvarna-xepc-popup__price-wrapper">
									<span class="woocommerce-Price-amount amount">
										<label>Pris:</label> <span class="husqvarna-xepc-popup__price"></span>&nbsp;<span class="woocommerce-Price-currencySymbol">kr</span>
									</span>
								</div>

								<div class="husqvarna-xepc-popup__sku-wrapper">
									<span class="sku_wrapper">
										<label>Artikelnr:</label> <span class="sku husqvarna-xepc-popup__sku" itemprop="sku">-</span>
									</span>
								</div>

								<div class="product-quantity">
									<div class="husqvarna-xepc-popup__quantity quantity">
<?php
										woocommerce_quantity_input(
											[
												'input_value' =>
												(
													isset( $_POST[ 'quantity' ] )
													? wc_stock_amount( $_POST[ 'quantity' ] )
													: 1
												)
											]
										);
?>

										<div class="husqvarna-xepc-popup__link-wrap">
										</div>
									</div>
								</div>

								<input type="hidden" name="add-to-cart" value="0" />
								<input type="hidden" name="product_id" value="0" />
								<input type="hidden" name="variation_id" class="variation_id" value="0" />
							</div>
						</form>
					</div>
				</div>

				<button type="button" class="husqvarna-xepc-popup__close-button custom-popup__close-button">
					<i class="fa fa-close"></i>
				</button>
			</div>
		</div>
	</div>
<?php
}


// Inject the variables we need from our classes
Content\Content::injectJsVariables();
Content\Cards::injectJsVariables();
Content\FacebookFeed::injectJsVariables();

// Let WP paste whatever it likes into the footer
wp_footer();
?>
<script>
	if ( window.kcoAjax ) {

		window.kcoAjax.coupon_fail    = 'Rabattkoden kunde inte läggas till.';
		window.kcoAjax.coupon_success = 'Rabattkod tillagd.';
	}
</script>
<!-- START: Global site tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GTM-NZBJ6RV"></script>
<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'GTM-NZBJ6RV'); gtag('config', 'AW-784523663');</script>
<!-- END: Global site tag (gtag.js) -->
<?php
// Is this the thank you page?
if ( ! empty( $_GET[ 'key' ] ) && ! empty( $_GET[ 'kco_confirm' ] ) && 'yes' === $_GET[ 'kco_confirm' ] && ! empty( $_GET[ 'kco_order_id' ] ) )
{
	$order_key = filter_input( INPUT_GET, 'key', FILTER_SANITIZE_STRING );

	$order_id = \wc_get_order_id_by_order_key( $order_key );

	// Get order object
	$order = \wc_get_order( $order_id );
?>
	<!-- Event snippet for Spårning försäljning conversion page -->
	<script>gtag('event', 'conversion', { 'send_to': 'AW-784523663/86gUCKusr4sBEI_Di_YC', 'value': <?php echo number_format( $order->get_total(), 2, ".", "" ); ?>, 'currency': 'SEK', 'transaction_id': '<?php echo $orderID; ?>' }); </script>

<?php
}
?>
</body>
</html>