<?php
/**
 * Template Name: Sida m. Google karta
 *
 * @package Wisewebs
 */


// Import relevant namespaces
Use Wisewebs\Classes\Content;


get_header();

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


	// Print the Google map
	Content\GoogleMap::output(
		Array(
			Content\GoogleMap::FIELD_NAME__GOOGLE_MAP => get_field(
				Content\GoogleMap::FIELD_NAME__GOOGLE_MAP
			),
			Content\GoogleMap::FIELD_NAME__INFO_COLUMN => get_field(
				Content\GoogleMap::FIELD_NAME__INFO_COLUMN
			),
		)
	);
?>
	<main class="yolo-site-content-page">
		<div class="container clearfix">
			<div class="row clearfix">
				<div class="yolo-site-content-page-inner col-md-12">
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
									<div class="generic-form">
										<h2 class="generic-form__main-heading">Allmänna frågor</h2>
										<h3 class="generic-form__sub-heading">Webbshop & reservdelar</h3>
<?php
										echo do_shortcode( '[contact-form-7 id="8013" title="Allmänna frågor"]' );
?>
									</div>
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

get_footer();
