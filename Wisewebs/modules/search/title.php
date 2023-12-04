<?php
/**
 * Template for WooCommerce search.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;



/**
 * Runtime.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'search-title';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );
?>
<div class="<?php $BEMHelper(); ?>">
	<h2 class="<?php $BEMHelper( 'text' ); ?>">Sökresultat för: "<?php echo get_search_query(); ?>"</h2>
</div>
