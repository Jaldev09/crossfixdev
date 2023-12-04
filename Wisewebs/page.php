<?php
/**
 * The generic page template in WP.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\Content;
use Wisewebs\Classes\FlexibleContent;

get_header();


if ( 'flexible-content' === get_field( 'page-layout' ) )
{
	// Output flexible content
	FlexibleContent\FlexibleContent::output();
}
else
{
?>
	<div id="yolo-content-wrapper" class="clearfix">
<?php

		// Print the hero image
		Content\HeroImage::output(
			Array(
				Content\HeroImage::FIELD_HEADING => get_the_title(),
				Content\HeroImage::FIELD_IMAGE   => get_field(
					Content\HeroImage::FIELD_IMAGE
				),
			)
		);
?>
		<main class="yolo-site-content-page">
			<div class="container clearfix">
				<div class="row clearfix">
					<div class="yolo-site-content-page-inner col-md-12">
<?php
						if ( true === is_checkout() )
						{
							$customCheckoutMessageIcon = get_field( 'custom-checkout-message__icon' );
							$customCheckoutMessageText = get_field( 'custom-checkout-message__text' );

							if ( true !== empty( $customCheckoutMessageText ) )
							{
?>
								<div class="custom-checkout-message <?php if ( true !== empty( $customCheckoutMessageIcon ) ) { ?>custom-checkout-message--has-icon<?php } ?>">
<?php
									if ( true !== empty( $customCheckoutMessageIcon ) )
									{
?>
										<img alt="" class="custom-checkout-message__icon" src="<?php echo wp_get_attachment_image_src( ( int ) $customCheckoutMessageIcon, 'full' )[ 0 ]; ?>" />
<?php
									}
?>
									<div class="custom-checkout-message__text">
<?php
										echo $customCheckoutMessageText;
?>
									</div>
								</div>
<?php
							}
						}
?>
						<div class="page-content">
<?php
							if ( have_posts() ) {

								while ( have_posts() ) {
?>
									<div class="entry-content">
<?php
										the_post();
										the_content();
?>
									</div>
<?php
								}
							}
?>
						</div>
					</div>
				</div>
			</div>
		</main>
<?php
		// Print the cards as they appear on the frontpage
		Content\Cards::output(
			get_field(
				Content\Cards::FIELD_NAME,
				'option'
			)
		);

		// Print the logotype list as it appears on the frontpage
		Content\LogotypeList::output(
			get_field(
				Content\LogotypeList::FIELD_NAME,
				'option'
			)
		);
?>
	</div>
<?php
}

get_footer();
