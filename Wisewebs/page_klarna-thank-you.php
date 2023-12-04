<?php
/**
 * Template Name: Klarna tacksida
 *
 * @package Wisewebs
 */

// Import relevant namespaces
Use Wisewebs\Classes\Content;

// Set a variable so we know it's the thank you page
$isKlarnaThankYouPage = true;

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
