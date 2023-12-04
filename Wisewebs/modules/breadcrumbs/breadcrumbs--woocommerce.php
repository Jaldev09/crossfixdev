<?php
// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<div class="custom-breadcrumb">
<?php
	woocommerce_breadcrumb(
		[
			'delimiter' => '&nbsp;<span class="breadcrumb-delimiter">/</span>&nbsp;',
		]
	);
?>
</div>
