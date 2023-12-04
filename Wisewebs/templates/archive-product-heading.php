<?php
/**
 * Heading for product arhives.
*/


// Import relevant namespaces
Use Wisewebs\Classes\Content;


// Print the hero image
Content\HeroImage::output(
	Array(
		Content\HeroImage::FIELD_IMAGE   => get_field(
			Content\HeroImage::FIELD_IMAGE,
			wc_get_page_id( 'shop' )
		),
		Content\HeroImage::FIELD_HEADING => woocommerce_page_title( false ),
	)
);
