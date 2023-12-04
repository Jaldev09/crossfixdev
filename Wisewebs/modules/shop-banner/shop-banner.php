<?php
/**
 * Template for the shop banner.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'shop-banner';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

// If banner is enabled
if ( true === get_field( 'shop-banner__enabled', 'option' ) )
{
?>
	<div class="<?php $BEMHelper(); ?>">
		<div class="<?php $BEMHelper( 'inner-wrap' ); ?>">
<?php
			the_field( 'shop-banner__text', 'option' );
?>
		</div>
	</div>
<?php
}
