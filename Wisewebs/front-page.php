<?php
/**
 * The template for displaying the static frontpage.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\Content;
use Wisewebs\Classes\FlexibleContent;

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) )
{
	die;
}

// Get the header
get_header();

// Output flexible content
FlexibleContent\FlexibleContent::output();

// Get the footer
get_footer();
