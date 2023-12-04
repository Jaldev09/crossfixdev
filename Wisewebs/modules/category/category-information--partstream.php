<?php
/**
 * Template for category information for WooCommerce categories.
 */



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Make variables global
global $title;
global $fieldModifier;

// Default to using category name as title
$title = get_the_title();

// Set field modifier
$fieldModifier = get_the_ID();

// Category information
get_template_part( 'modules/category/category-information' );
