<?php
/**
 * Template for the Hero image.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$moduleName              = 'grid';

$BEMHelper               = Utility\Strings::BEMHelper( $moduleName );
$columnCount             = get_sub_field( $moduleName . '__column-count' );
$largeDesktopColumnCount = get_sub_field( $moduleName . '__column-count-large-desktop' );
$smallDesktopColumnCount = get_sub_field( $moduleName . '__column-count-small-desktop' );

if ( have_rows( $moduleName . '__item-list' ) )
{
?>
	<div
		class="<?php
			$BEMHelper(
				'',
				[
					'column-count-'               . $columnCount             => true,
					'column-count-large-desktop-' . $largeDesktopColumnCount => true,
					'column-count-small-desktop-' . $smallDesktopColumnCount => true,
				]
			);
		?>"
	>
		<div class="<?php $BEMHelper( 'item-wrap' ); ?>">
<?php
			while ( have_rows( $moduleName . '__item-list' ) )
			{
				the_row();
?>
				<div class="<?php $BEMHelper( 'item' ); ?>">
<?php
					the_sub_field( $moduleName . '__item' );
?>
				</div>
<?php
			}
?>
		</div>
	</div>
<?php
}
