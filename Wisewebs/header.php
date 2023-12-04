<?php
/*
 * The main site header.
 */


// Import relevant namespaces
Use Wisewebs\Classes\Content;
Use Wisewebs\Classes\Tracking;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link>  
<?php
	$yolo_options = yolo_get_options();
	$yolo_footer_id = yolo_include_footer_id(); // Use this to fix get footer_id in footer block

	wp_head();

	// Print the cookie bar CSS
	Content\CookieBar::printCSS();
?>
</head>
<body <?php body_class( Array( 'boxed', 'woocommerce' ) ); ?>>
	<img class="tracking-pixel adnuntius-tracking-pixel" src="https://delivery.adnuntius.com/pixelr.gif?network=ntm&crossfix=crossfix-170915.au&expiry=2592000">
<?php
	// Print the cookiebar HTML & JS
	Content\CookieBar::printHTML();
	Content\CookieBar::printJS();
?>
	<!-- START: Mobile menu -->
	<div id="yolo-nav-mobile-menu" class="yolo-mobile-header-nav menu-drop-fly">
<?php
		echo apply_filters( 'yolo_before_menu_mobile_filter','' );

		if ( has_nav_menu( 'mobile' ) ) :

			$args = array(
				'container'      => '',
				'theme_location' => 'mobile',
				'menu_class'     => 'yolo-nav-mobile-menu', // Note: if edit this class must edit in function: replace_walker_to_yolo_mega_menu()
				'walker'         => new Yolo_MegaMenu_Walker()
			);


			wp_nav_menu( $args );

		endif;

		echo apply_filters( 'yolo_after_menu_mobile_filter','' );
?>
		<div class="below-mobile-menu">
<?php
			echo the_field( 'text_below_mobile_menu', 'option' );
?>
		</div>
	</div>
	<!-- END: Mobile menu -->



	<!-- START: Section -->
	<div id="yolo_search_popup_wrapper" class="dialog animated">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="dialog-inner">
<?php
				// Seach box
				get_product_search_form();
?>
				<div><button class="action" data-dialog-close="close" type="button"><i class="fa fa-close"></i></button></div>
			</div>
		</div>
	</div>
	<!-- END: Section -->



	<!-- START: Perspective-wrapper -->
	<!-- <div id="perspective-wrapper"> -->
<?php
		/*
		*	@hooked - yolo_site_loading - 5;
		*	@hooked - yolo_popup_window - 10;
		*/
		do_action( 'yolo_before_page_wrapper' );
?>
		<!-- Open yolo wrapper -->
		<div id="yolo-wrapper">
<?php
				/*
				*	@hooked - yolo_page_above_header - 5
				*	@hooked - yolo_page_top_bar - 10
				*	@hooked - yolo_page_header - 15
				*/
				do_action( 'yolo_before_page_wrapper_content' );
?>
			<!-- Open Yolo Content Wrapper -->
			<div id="yolo-content-wrapper" class="clearfix">
<?php
				/*
				*	@hooked - yolo_main
				*/
				do_action( 'yolo_main_wrapper_content_start' );
