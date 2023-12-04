<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    26/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

global $wp_version;
$yolo_options = yolo_get_options();
?>
<?php
if (version_compare($wp_version, '4.1', '<')) : ?>
	<title><?php wp_title('|', true, 'right'); ?></title>
<?php endif; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>

<meta name="viewport" content="width=device-width, initial-scale=1">

<?php if (isset($yolo_options['custom_ios_title']) && !empty($yolo_options['custom_ios_title'])) :?>
	<meta name="apple-mobile-web-app-title" content="<?php echo esc_attr($yolo_options['custom_ios_title']); ?>">
<?php endif;?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>



<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->