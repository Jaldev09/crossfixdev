<?php
/**
 * Template for WooCommerce messages.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



/**
 * Runtime.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
// Name of the module
$moduleName = 'woocommerce-messages';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );
?>
<div class="<?php $BEMHelper(); ?>">
<?php
	// Print any Woocommerce messages
	do_action( 'woocommerce_before_single_product' );
?>
</div>
