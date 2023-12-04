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
<?php 
if(is_user_logged_in()) {
    ?>
    <script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     var dropdown = document.getElementById('cf7-vehicle-list');
    //     console.log(dropdown);
    //     if (dropdown) {
    //         dropdown.addEventListener('change', function() {
    //             var selectedValue = dropdown.value;
    //             document.querySelector('input[name="customer-vehicle-hidden-field"]').value = selectedValue;
    //         });
    //     }
    // });
    jQuery(document).ready(function($) {

        $(document).on('change',"#select_boka_service,#select_boka_storage,#select_sell_machine", function() {   
            $(this).removeAttr('selected');
            $(this).find("option:selected").attr('selected', 'selected');
        });   
        $(document).on('submit','#book_service_form form.wpcf7-form', function() {    
            var selectedValue = $(document).find("#select_boka_service :selected").val();
            var splitValues = selectedValue.split('|');
            var firstValue = splitValues[0];
            var secondValue = splitValues[1];
            $('input[name="boka-service-vehicle"]').val(firstValue);
            $('input[name="service-vehicle-post-name"]').val(secondValue);
        });
        
        $(document).on('submit','#book_storage_form form.wpcf7-form', function() {            
            var selectedValue = $(document).find("#select_boka_storage :selected").val();
            var splitValues = selectedValue.split('|');
            var firstValue = splitValues[0];
            var secondValue = splitValues[1];
            $('input[name="boka-storage-vehicle"]').val(firstValue);
            $('input[name="storage-vehicle-post-name"]').val(secondValue);
        });

        $(document).on('submit','#sell_machine_form form.wpcf7-form', function() {            
            var selectedValue = $(document).find("#select_sell_machine :selected").val();
            var splitValues = selectedValue.split('|');
            var firstValue = splitValues[0];
            var secondValue = splitValues[1];
            $('input[name="sell-machine-vehicle"]').val(firstValue);
            $('input[name="sell-machine-post-name"]').val(secondValue);
        });
    });
    </script>
    <?php
}
?>
<?php 
global $wp;
$request = explode( '/', $wp->request );
if( ( in_array('mitt-konto',$request)  && is_account_page() ) ){ 
	$accessories_shortcode = get_field('accessories_shortcode','options');
	$service_form_shortcode = get_field('service_form_shortcode','options');
	$storage_form_shortcode = get_field('storage_form_shortcode','options');
	$selling_machine_shortcode = get_field('selling_machine_shortcode','options');
?>
<div class="woo_account_settings modal" tabindex="-1" id="woo_account_settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="woo_accform_title"></h5>
                <!-- <a href="javaScript:void(0);" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-window-close" aria-hidden="true"></i></a> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php if(!empty($accessories_shortcode)): ?>
            <div class="account-custom-forms accessories-form" id="machine_accessories_form" style="display:none;">
                <?php  echo do_shortcode($accessories_shortcode); ?>
            </div>
            <?php endif; ?>
            <?php if(!empty($service_form_shortcode)): ?>
            <div class="account-custom-forms book-service-form" id="book_service_form" style="display:none;">
                <?php echo do_shortcode($service_form_shortcode); ?>
            </div>
            <?php endif; ?>
            <?php if(!empty($storage_form_shortcode)): ?>
            <div class="account-custom-forms book-storage-form" id="book_storage_form" style="display:none;">
                <?php echo do_shortcode($storage_form_shortcode); ?>
            </div>
            <?php endif; ?>
            <?php if(!empty($selling_machine_shortcode)): ?>
            <div class="account-custom-forms sell-machine-form" id="sell_machine_form" style="display:none;">
                <?php echo do_shortcode($selling_machine_shortcode); ?>
            </div>
            <?php endif; ?>
            <!-- 
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
</div>
<?php } ?>
</body>
</html>