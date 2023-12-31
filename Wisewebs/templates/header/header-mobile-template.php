<?php

// Import relevant namespaces
use Wisewebs\Classes\Content;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( 'mobile-header' );

// Get the logo
$logo = get_field( Content\Header::FIELD_NAME, 'option' );
?>
<!-- START: Redesigned header -->
<header class="<?php $BEMHelper(); ?>">
	<button class="<?php $BEMHelper( 'menu-toggle-button' ); ?>" type="button">
		<span class="<?php $BEMHelper( 'menu-toggle-button-line', 'first' ); ?>" aria-hidden="true"></span>
		<span class="<?php $BEMHelper( 'menu-toggle-button-line', 'middle' ); ?>" aria-hidden="true"></span>
		<span class="<?php $BEMHelper( 'menu-toggle-button-line', 'last' ); ?>" aria-hidden="true"></span>
		<span class="<?php $BEMHelper( 'menu-toggle-button-label', [ 'mobile-menu-closed' ] ); ?>">Meny</span>
		<span class="<?php $BEMHelper( 'menu-toggle-button-label', [ 'mobile-menu-open' ] ); ?>">Stäng<span class="<?php $BEMHelper( 'menu-toggle-button-label-extra-text' ); ?>"> meny</span></span>
	</button>
	<button class="<?php $BEMHelper( 'service-booking-button' ); ?>" data-form-id="286" type="button">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 389.5L378.2 265c-15.6-15.6-36.1-23.4-56.6-23.4-15.4 0-30.8 4.4-44.1 13.3L192 169.4V96L64 0 0 64l96 128h73.4l85.5 85.5c-20.6 31.1-17.2 73.3 10.2 100.7l124.5 124.5c6.2 6.2 14.4 9.4 22.6 9.4 8.2 0 16.4-3.1 22.6-9.4l67.9-67.9c12.4-12.6 12.4-32.8-.1-45.3zM160 158.1v1.9h-48L42.3 67 67 42.3l93 69.7v46.1zM412.1 480L287.7 355.5c-9.1-9.1-14.1-21.1-14.1-33.9 0-12.8 5-24.9 14.1-33.9 9.1-9.1 21.1-14.1 33.9-14.1 12.8 0 24.9 5 33.9 14.1L480 412.1 412.1 480zM64 432c0 8.8 7.2 16 16 16s16-7.2 16-16-7.2-16-16-16-16 7.2-16 16zM276.8 66.9C299.5 44.2 329.4 32 360.6 32c6.9 0 13.8.6 20.7 1.8L312 103.2l13.8 83 83.1 13.8 69.3-69.3c6.7 38.2-5.3 76.8-33.1 104.5-8.9 8.9-19.1 16-30 21.5l23.6 23.6c10.4-6.2 20.2-13.6 29-22.5 37.8-37.8 52.7-91.4 39.7-143.3-2.3-9.5-9.7-17-19.1-19.6-9.5-2.6-19.7 0-26.7 7l-63.9 63.9-44.2-7.4-7.4-44.2L410 50.3c6.9-6.9 9.6-17.1 7-26.5-2.6-9.5-10.2-16.8-19.7-19.2C345.6-8.3 292 6.5 254.1 44.3c-12.9 12.9-22.9 27.9-30.1 44v67.8l22.1 22.1c-9.6-40.4 1.6-82.2 30.7-111.3zM107 467.1c-16.6 16.6-45.6 16.6-62.2 0-17.1-17.1-17.1-45.1 0-62.2l146.1-146.1-22.6-22.6L22.2 382.3c-29.6 29.6-29.6 77.8 0 107.5C36.5 504.1 55.6 512 75.9 512c20.3 0 39.4-7.9 53.7-22.3L231.4 388c-6.7-9.2-11.8-19.3-15.5-29.8L107 467.1z"/></svg>
		<span class="<?php $BEMHelper( 'service-booking-button-text' ); ?>">
			Boka service
		</span>
	</button>
	<div class="<?php $BEMHelper( 'sticky-wrap' ); ?>">
		<div class="<?php $BEMHelper( 'row', 'top' ); ?>">
			<div class="<?php $BEMHelper( 'column', 'first' ); ?>">
			</div>

			<div class="<?php $BEMHelper( 'column', 'middle' ); ?>">
				<a
					class="<?php $BEMHelper( 'home-link' ); ?>"
					href="<?php echo home_url(); ?>"
				>
<?php
				yolo_get_template( 'header/logo' );
?>
				</a>
			</div>

			<div class="<?php $BEMHelper( 'column', 'last' ); ?>">
	<?php
				yolo_get_template( 'header/mini-cart' );
	?>
			</div>
		</div>
	</div>
	<div class="<?php $BEMHelper( 'row', 'bottom' ); ?>">
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<input type="text" class="search-field" placeholder="Sök tillbehör&hellip;" value="<?php echo get_search_query(); ?>" name="s" title="Sök:" />
			<button type="submit">
				<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="45.000000pt" height="46.000000pt" viewBox="0 0 45.000000 46.000000" preserveAspectRatio="xMidYMid meet">
					<g transform="translate(0.000000,46.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
						<path d="M98 420 c-100 -53 -110 -205 -17 -271 43 -30 124 -37 169 -14 l32 17 65 -71 c36 -39 69 -71 75 -71 16 0 6 16 -60 89 l-62 70 20 33 c61 100 -20 239 -139 238 -25 -1 -62 -10 -83 -20z m150 -20 c64 -39 86 -106 58 -174 -39 -93 -158 -112 -231 -36 -40 42 -47 122 -14 164 51 65 125 83 187 46z" />
					</g>
				</svg>
			</button>
			<input type="hidden" name="post_type" value="product" />
		</form>
	</div>
</header>
	<!-- END: Redesigned header -->

<!-- START: Old header remnants -->
<header id="yolo-mobile-header" class="yolo-mobile-header header-mobile-2">
	<div class="yolo-header-container-wrapper menu-drop-fly header-mobile-sticky">
		<div class="container yolo-mobile-header-wrapper">
			<div id="yolo-nav-mobile-menu" class="yolo-mobile-header-nav menu-drop-fly">
<?php
				echo apply_filters( 'yolo_before_menu_mobile_filter', '' );

				if ( has_nav_menu( 'mobile' ) )
				{
					wp_nav_menu(
						[
							'container'      => '',
							'menu_class'     => 'yolo-nav-mobile-menu',
							'theme_location' => 'mobile',
							'walker'         => new Yolo_MegaMenu_Walker(),
						]
					);
				}

				echo apply_filters( 'yolo_after_menu_mobile_filter', '' );
?>
			</div>
			<div class="yolo-mobile-menu-overlay"></div>
		</div>
	</div>
</header>
<!-- END: Redesigned header -->
