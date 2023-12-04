<?php
/*
 * Functionality for flexible content.
 */



/**
 * Namespace and imports.
 */
namespace Wisewebs\Classes\FlexibleContent;
use Wisewebs\Classes\Utility;



/*
 * The main class for flexible content.
 */
class FlexibleContent
{
	/**
	 * Shows the flexible content fields for the current page.
	 */
	public static function output( $postID = false )
	{
		global $flexibleContentSectionNumber;

		$flexibleContentSectionNumber = 0;

		/**
		 * Check if we have any rows
		 */
		if ( have_rows( 'flexible-content', $postID ) )
		{
			// Loop rows
			while ( have_rows( 'flexible-content', $postID ) )
			{
				// Setup row data
				the_row();

				$flexibleContentSectionNumber++;

				// Get layout type
				$layout = get_row_layout();

				// Get the relevant template
				get_template_part( 'modules/' . $layout . '/' . $layout );
			}
		}
	}




	/**
	 * Utilize the magic function __set to make sure we can't overload this
	 * class.
	 *
	 * @param      string  $name   Unused, we only care to receive it for
	 *                             compatibility
	 * @param      string  $val    Unused, we only care to receive it for
	 *                             compatibility
	 */
	public function __set( $name, $val )
	{
		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
