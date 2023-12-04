<?php
/**
 * Heading for product archives.
*/


// Import relevant namespaces
Use Wisewebs\Classes\Content;

// Print the hero image
Content\LargeHeroImage::output(
    [
        Content\LargeHeroImage::FIELD_HEADING         => get_the_title(),
        'ingress'                                     => '',
        Content\LargeHeroImage::FIELD_IMAGE           => get_field( Content\LargeHeroImage::FIELD_IMAGE, wc_get_page_id( 'shop' ) ),
        Content\LargeHeroImage::FIELD_TONE_DOWN_IMAGE => ( bool ) get_field( Content\LargeHeroImage::FIELD_TONE_DOWN_IMAGE, wc_get_page_id( 'shop' ) ),
    ]
);
