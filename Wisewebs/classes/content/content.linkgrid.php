<?php
/*
 * Class file for cards.
 */


// Set namespace
namespace Wisewebs\Classes\Content;


// Import relevant namespaces
use Wisewebs\Interfaces;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;


/**
 * Class used for displaying cards.
 */
class LinkGrid extends Content
{
	// CSS classes & IDs
	const CSS_CLASS_SECTION = 'link-grid';





	/**
	 * Compile and output section. As we expect to receive an array we define a
	 * function in this class calling parent instead of utilising direct
	 * inheritance.
	 *
	 * @param      array  $data   The field contents.
	 */
	public static function output( $data = Array() )
	{
		// Classes to set for the slideshow
		parent::output( $data );
	}





	/**
	 * Create the actual section content.
	 *
	 * @param      array   $data   The field contents.
	 *
	 * @return     string  Formatted content.
	 */
	protected static function content( $data = Array() )
	{
		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		// Replace defaults with user args where applicable
		$data = array_replace_recursive(
			[
				'gridItems' =>
				[
				]
			],
			$data
		);

		// Make sure we have some grid items
		if ( ! empty( $data[ 'gridItems' ] ) && is_array( $data[ 'gridItems' ] ) )
		{
?>
			<div class="link-grid">
<?php
				// Loop grid items
				foreach ( $data[ 'gridItems' ] as $item )
				{
					// Do we have a link?
					if ( ! empty( $item[ 'link' ] ) )
					{
?>
						<a
						 class="link-grid__item"
						 href="<?php echo $item[ 'link' ]; ?>"
						>
<?php
					}
					// No link
					else
					{
?>
						<div
						 class="link-grid__item <?php echo Cards::CSS_CLASS_POPUP_CARD; ?>"
<?php
						if ( ! empty( $item[ 'popup' ] ) )
						{
?>
						 	data-<?php echo Cards::FIELD_POPUP; ?>="<?php echo $item[ 'popup' ]; ?>"
<?php
						}
?>
						>
<?php
					}
?>
					<div
					 class="link-grid__item__wrap"
					 style="background-image: url( <?php if ( ! empty( $item[ 'background' ] ) ) echo $item[ 'background' ]; ?> );"
					>
<?php
						if ( ! empty( $item[ 'h1' ] ) && true === $item[ 'h1' ] )
						{
							$heading = 'h1';
						}
						else
						{
							$heading = 'h2';
						}
?>
						<<?php echo $heading; ?> class="link-grid__item__heading">
<?php
							echo $item[ 'title' ];
?>
						</<?php echo $heading; ?>>

						<p class="link-grid__item__text">
<?php
							echo $item[ 'text' ];
?>
						</p>
						<span class="link-grid__item__button">
<?php
							echo $item[ 'buttonText' ];
?>
						</span>
					</div>
<?php
					// Do we have a link?
					if ( ! empty( $item[ 'link' ] ) )
					{
?>
						</a>
<?php
					}
					// No link
					else
					{
?>
						</div>
<?php
					}
				}
?>
			</div>
<?php
		}

		// Get the buffered data and clean it out.
		return ob_get_clean();
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
