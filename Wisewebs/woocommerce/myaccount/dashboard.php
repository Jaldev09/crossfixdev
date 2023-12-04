<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// $allowed_html = array(
// 	'a' => array(
// 		'href' => array(),
// 	),
// );
?>

<!-- <p> -->
    <?php
	// printf(
	// 	/* translators: 1: user display name 2: logout url */
	// 	wp_kses( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
	// 	'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
	// 	esc_url( wc_logout_url() )
	// );
	?>
<!-- </p> -->

<!-- <p> -->
    <?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	// $dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	// if ( wc_shipping_enabled() ) {
	// 	/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
	// 	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	// }
	// printf(
	// 	wp_kses( $dashboard_desc, $allowed_html ),
	// 	esc_url( wc_get_endpoint_url( 'orders' ) ),
	// 	esc_url( wc_get_endpoint_url( 'edit-address' ) ),
	// 	esc_url( wc_get_endpoint_url( 'edit-account' ) )
	// );
	?>
<!-- </p> -->
<!-- <div class="product-gallery-wrapper">
    <div class="product-gallery-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/vehicle.png" alt="">
    </div>
    <div class="product-entry-summary">
        <h1 class="common-title">Lynx 49 Ranger Pro 850 E-Tec 2024</h1>
        <p class="common-description">Perfekt, nu kan vi anpassa innehållet på sidan så det passar just DIG.</p>
    </div>
</div>
<div class="how-can-help-wrapper">
    <h2 class="section-heading">Hur kan vi hjälpa dig idag?</h2>
    <div class="help-options-wrapper">
        <div class="help-option">
            <div class="option-icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/plus-sign.svg" alt="plus-sign">
            </div>
            <p class="option-title">Visa tillbehör som passar denna maskin</p>
        </div>
        <div class="help-option">
            <div class="option-icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/setting-service.svg"
                    alt="setting-service">
            </div>
            <p class="option-title">Boka service för denna maskin</p>
        </div>
        <div class="help-option">
            <div class="option-icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/storage.svg" alt="storage">
            </div>
            <p class="option-title">Boka förvaring för denna maskin</p>
        </div>
        <div class="help-option">
            <div class="option-icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sell-machine.svg" alt="sell-machine">
            </div>
            <p class="option-title">Önskar sälja denna maskin</p>
        </div>
    </div>
    <div class="add-more-machines">
        <a href="#" class="add-more-btn">Lägg till fler maskiner</a>
    </div>
</div>

<div class="your-machines-wrapper">
    <h3 class="mb-2 common-title">Din maskin</h3>
    <p class="common-description">För att ge dig BÄSTA service och matchning av tillbehör kan du lägga till din maskin.
    </p>
    <div class="select-options-wrapper">
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="select-option-item">
                    <select>
                        <option selected>Välj varumärke</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="select-option-item">
                    <select>
                        <option selected>Välj ärsmodell</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="select-option-item">
                    <select>
                        <option selected>Välj Modell</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div> -->

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */