<?php
/**
 * Template Name: PartStream/Husqvarna xEPC-sida
 *
 * @package Wisewebs
 */



// Import relevant namespaces
use Wisewebs\Classes\Content;
use Wisewebs\Classes\FlexibleContent;



// Access the global post object
global $post;

// Check if we're on a child page
$isChildPage = ( is_page() && $post->post_parent );

// Header
get_header();

// Standard WP crap
if ( have_posts() )
{
	// Standard WP crap
	while ( have_posts() )
	{
		// Setup postdata
		the_post();

		// Shop banner
		get_template_part( 'modules/shop-banner/shop-banner' );

		// If we're on the top level page
		if ( ! $isChildPage )
		{
			get_template_part( 'modules/breadcrumbs/breadcrumbs--woocommerce' );

			// Print the hero image
			Content\LargeHeroImage::output(
				[
					Content\LargeHeroImage::FIELD_HEADING         => get_field( 'spare_parts_title' ),
					'ingress'                                     => get_field( 'spare_parts_ingress' ),
					Content\LargeHeroImage::FIELD_IMAGE           => get_field( Content\LargeHeroImage::FIELD_IMAGE ),
					Content\LargeHeroImage::FIELD_TONE_DOWN_IMAGE => ( bool ) get_field( Content\LargeHeroImage::FIELD_TONE_DOWN_IMAGE ),
				]
			);
		}

		// Woocommerce message
		get_template_part( 'modules/woocommerce-messages/woocommerce-messages' );

		// If we're on the top level page
		if ( ! $isChildPage )
		{
			// Get category links
			get_template_part( 'modules/category/category-links--partstream' );
		}
		// Child page
		else
		{
			// Get category information
			get_template_part( 'modules/category/category-information--partstream' );

			if ( 'husqvarna_xepc' === get_field( 'epc_selection' ) )
			{
				// Get Husqvarna xEPC
				get_template_part( 'modules/husqvarna-xepc/husqvarna-xepc' );
			}
			else
			{
				// Get Partstream content
				get_template_part( 'modules/partstream/partstream' );
			}
		}
	}
}

// If we're on a child page
if ( $isChildPage )
{
	$pageID = wp_get_post_parent_id( get_the_ID() );
}
// Parent page
else
{
	$pageID = get_the_ID();
}

// Output flexible content
FlexibleContent\FlexibleContent::output( $pageID );

// Footer
get_footer();
