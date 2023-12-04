<?php
/*
 * ACF helper functionality.
 */



/**
 * Namespace and imports.
 */
namespace Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;



/*
 * The main class for ACF helper functions.
 */
class FieldHelper extends ACF
{
	/**
	 * Gets the alt text for a link field.
	 */
	public static function linkFieldAlt( $fieldData, bool $echo = true )
	{
		$href = '';

		// Did we get a title provided?
		if ( ! empty( $fieldData[ 'title' ] ) )
		{
			$href = $fieldData[ 'title' ];
		}

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $href;
		}
		// Or returned?
		else
		{
			return $href;
		}
	}



	/**
	 * Gets the alt attribute for a link field.
	 */
	public static function linkFieldAltAttr( $fieldData, bool $echo = true )
	{
		// Start buffering output
		ob_start();
?>
		 alt="<?php static::linkFieldAlt( $fieldData ); ?>"
<?php
		// Collect the buffer
		$buffer = ob_get_clean();

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $buffer;
		}
		// Or returned?
		else
		{
			return $buffer;
		}
	}



	/**
	 * Checks if a link field has a value.
	 */
	public static function linkFieldHasValue( $fieldData )
	{
		return ! empty( $fieldData );
	}



	/**
	 * Gets the title from a link field.
	 */
	public static function linkFieldTitle( $fieldData, bool $echo = true )
	{
		// Start buffering output
		ob_start();

		// Did we get a URL provided?
		if ( ! empty( $fieldData[ 'title' ] ) )
		{
			echo $fieldData[ 'title' ];
		}

		// Collect the buffer
		$buffer = ob_get_clean();

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $buffer;
		}
		// Or returned?
		else
		{
			return $buffer;
		}
	}



	/**
	 * Gets the href for a link field.
	 */
	public static function linkFieldHref( $fieldData, bool $echo = true )
	{
		$href = '';

		// Did we get a URL provided?
		if ( ! empty( $fieldData[ 'url' ] ) )
		{
			$href = $fieldData[ 'url' ];
		}

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $href;
		}
		// Or returned?
		else
		{
			return $href;
		}
	}



	/**
	 * Gets the href attribute for a link field.
	 */
	public static function linkFieldHrefAttr( $fieldData, bool $echo = true )
	{
		// Start buffering output
		ob_start();
?>
		 href="<?php static::linkFieldHref( $fieldData ); ?>"
<?php
		// Collect the buffer
		$buffer = ob_get_clean();

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $buffer;
		}
		// Or returned?
		else
		{
			return $buffer;
		}
	}



	/**
	 * Gets the target for a link field.
	 */
	public static function linkFieldTarget( $fieldData, bool $echo = true )
	{
		$target = '';

		// Did we get a target provided?
		if ( ! empty( $fieldData[ 'target' ] ) )
		{
			$target = $fieldData[ 'target' ];
		}

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $target;
		}
		// Or returned?
		else
		{
			return $target;
		}
	}



	/**
	 * Gets the target attribute for a link field.
	 */
	public static function linkFieldTargetAttr( $fieldData, bool $echo = true )
	{
		// Start buffering output
		ob_start();

		// Get target data
		$target = static::linkFieldTarget( $fieldData, false );

		// If we have a target
		if ( ! empty( $target ) )
		{
?>
			 target="<?php echo $target; ?>"
<?php
		}

		// Collect the buffer
		$buffer = ob_get_clean();

		// Did we want that echo'ed
		if ( true === $echo )
		{
			echo $buffer;
		}
		// Or returned?
		else
		{
			return $buffer;
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
