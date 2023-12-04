<?php
/**
 * Template for the general text.
 */



// Import relevant namespaces
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'general-text';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );
?>
<div class="<?php $BEMHelper(); ?>">
<?php
	the_sub_field( $moduleName . '__text' );
?>
</div>
